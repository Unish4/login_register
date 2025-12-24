<?php
session_start();
require_once 'config.php'; // $conn connected to users_db

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login_page.php');
    exit;
}

$userId   = (int) $_SESSION['user_id'];
$userName = $_SESSION['name'] ?? 'User';

$message     = '';
$messageType = ''; // 'success' or 'error'

// 1) Handle deposit/withdraw form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';      // 'deposit' or 'withdraw'
    $amount = isset($_POST['amount']) ? (float) $_POST['amount'] : 0;
    $desc   = trim($_POST['description'] ?? '');

    if ($amount <= 0) {
        $message     = 'Amount must be greater than 0.';
        $messageType = 'error';
    } elseif ($action !== 'deposit' && $action !== 'withdraw') {
        $message     = 'Invalid action.';
        $messageType = 'error';
    } else {
        // Get current balance from transactions
        $balanceSql = "
            SELECT COALESCE(SUM(
                CASE 
                    WHEN type = 'deposit'  THEN amount
                    WHEN type = 'withdraw' THEN -amount
                END
            ), 0) AS balance
            FROM transactions
            WHERE user_id = $userId
        ";
        $balanceResult = $conn->query($balanceSql);
        $balanceRow    = $balanceResult ? $balanceResult->fetch_assoc() : ['balance' => 0];
        $currentBalance = (float) $balanceRow['balance'];

        // Check sufficient funds for withdraw
        if ($action === 'withdraw' && $amount > $currentBalance) {
            $message     = 'Insufficient balance.';
            $messageType = 'error';
        } else {
            // Escape description to avoid issues
            $safeDesc = $conn->real_escape_string($desc);

            // Insert new transaction
            $insertSql = "
                INSERT INTO transactions (user_id, type, amount, description)
                VALUES ($userId, '$action', $amount, '$safeDesc')
            ";
            if ($conn->query($insertSql)) {
                $message     = ucfirst($action) . ' of $' . number_format($amount, 2) . ' successful.';
                $messageType = 'success';
            } else {
                $message     = 'Error saving transaction.';
                $messageType = 'error';
            }
        }
    }
}

// 2) Get updated balance
$balanceSql2 = "
    SELECT COALESCE(SUM(
        CASE 
            WHEN type = 'deposit'  THEN amount
            WHEN type = 'withdraw' THEN -amount
        END
    ), 0) AS balance
    FROM transactions
    WHERE user_id = $userId
";
$balanceResult2 = $conn->query($balanceSql2);
$balanceRow2    = $balanceResult2 ? $balanceResult2->fetch_assoc() : ['balance' => 0];
$currentBalance = (float) $balanceRow2['balance'];

// 3) Get last 10 transactions
$transactions = [];
$txSql = "
    SELECT type, amount, description, created_at
    FROM transactions
    WHERE user_id = $userId
    ORDER BY created_at DESC
    LIMIT 10
";
$txResult = $conn->query($txSql);
if ($txResult && $txResult->num_rows > 0) {
    while ($row = $txResult->fetch_assoc()) {
        $transactions[] = $row;
    }
}
// End of logic; user_page.php will use $userName, $message, $messageType, $currentBalance, $transactions
