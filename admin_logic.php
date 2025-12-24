<?php
session_start();
require_once 'config.php'; // $conn connected to users_db

// Only allow logged-in admins
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    // If not an admin, send them to user page or login
    if (isset($_SESSION['user_id'])) {
        header('Location: user_page.php');
    } else {
        header('Location: login_page.php');
    }
    exit;
}

$adminId   = (int) $_SESSION['user_id'];
$adminName = $_SESSION['name'] ?? 'Admin';

$message     = '';
$messageType = ''; // 'success' or 'error'

// 1) Handle delete user request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $deleteId = (int) $_POST['delete_user_id'];

    if ($deleteId === $adminId) {
        $message     = 'You cannot delete your own admin account.';
        $messageType = 'error';
    } else {
        $res = $conn->query("SELECT Role FROM users WHERE id = $deleteId");
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();

            if ($row['Role'] === 'admin') {
                $message     = 'You cannot delete another admin account.';
                $messageType = 'error';
            } else {
                // Delete user's transactions first (works even if FK is set)
                $conn->query("DELETE FROM transactions WHERE user_id = $deleteId");

                if ($conn->query("DELETE FROM users WHERE id = $deleteId")) {
                    $message     = 'User account deleted successfully.';
                    $messageType = 'success';
                } else {
                    $message     = 'Failed to delete user account.';
                    $messageType = 'error';
                }
            }
        } else {
            $message     = 'User not found.';
            $messageType = 'error';
        }
    }
}

// 2) Fetch all users (admin + normal)
$users = [];
$res = $conn->query("SELECT id, Name, Email, Role FROM users ORDER BY Role DESC, Name ASC");
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $users[] = $row;
    }
}

// 3) If a specific user is selected, fetch their details and transactions
$selectedUser              = null;
$selectedUserBalance       = 0;
$selectedUserTransactions  = [];

if (isset($_GET['user_id'])) {
    $viewId = (int) $_GET['user_id'];

    $res = $conn->query("SELECT id, Name, Email, Role FROM users WHERE id = $viewId");
    if ($res && $res->num_rows > 0) {
        $selectedUser = $res->fetch_assoc();

        // Get balance for this user
        $balSql = "
            SELECT COALESCE(SUM(
                CASE 
                    WHEN type = 'deposit'  THEN amount
                    WHEN type = 'withdraw' THEN -amount
                END
            ), 0) AS balance
            FROM transactions
            WHERE user_id = $viewId
        ";
        $balRes = $conn->query($balSql);
        if ($balRes && $balRes->num_rows > 0) {
            $balRow             = $balRes->fetch_assoc();
            $selectedUserBalance = (float) $balRow['balance'];
        }

        // Get last 10 transactions for this user
        $txSql = "
            SELECT type, amount, description, created_at
            FROM transactions
            WHERE user_id = $viewId
            ORDER BY created_at DESC
            LIMIT 10
        ";
        $txRes = $conn->query($txSql);
        if ($txRes && $txRes->num_rows > 0) {
            while ($row = $txRes->fetch_assoc()) {
                $selectedUserTransactions[] = $row;
            }
        }
    }
}
