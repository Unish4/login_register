<?php
session_start();
require_once 'config.php';

// REGISTER
if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password']; // plain text
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmail = $conn->query("SELECT Email FROM users WHERE Email = '$email'");
    if($checkEmail && $checkEmail->num_rows > 0){
        $_SESSION['register_error'] = 'Email is already registered';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO users (Name, Email, Password, Role) VALUES ('$name','$email','$password','$role')");
        $_SESSION['active_form'] = 'login';
        $_SESSION['register_success'] = 'Registered successfully! Please login.';
    }
    header("Location: index.php");
    exit();
}

// LOGIN
if(isset($_POST['login'])){
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE Email = '$email'");
    if($result && $result->num_rows > 0){
        $user = $result->fetch_assoc();

        // Plain text password check (case-sensitive)
        if($password === $user['Password']){
            $_SESSION['name'] = $user['Name'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['role'] = $user['Role'];

            // Redirect based on role
            if($user['Role'] === 'admin'){
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}
?>
