<?php
session_start();
require_once 'config.php';

// Grab errors and success message from session
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'register'; // show register first
$successMsg = $_SESSION['register_success'] ?? '';
session_unset();

// Function to display error messages
function showError($error){
    return !empty($error) 
        ? "<p class='error-message text-red-600 font-semibold bg-red-100 border border-red-400 rounded-lg px-4 py-2 mb-4'>$error</p>" 
        : '';
}

// Function to set form visibility
function isActiveForm($formName, $activeForm){
    return $formName === $activeForm ? 'block' : 'hidden';
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg ">

<!-- LOGIN FORM -->
<div class="form-box bg-white rounded-lg p-8 <?= isActiveForm('login',$activeForm); ?>" id="login-form">
    <form action="login_register.php" method="post">
        <h2 class="text-black font-bold text-2xl flex justify-center items-center">Login</h2>

        <?= showError($errors['login']); ?>
        <?= !empty($successMsg) ? "<p class='text-green-600 font-semibold bg-green-100 border border-green-400 rounded-lg px-4 py-2 mb-4'>$successMsg</p>" : ''; ?>

        <div class="placeholders flex flex-col p-3 m-3">
            <input type="email" placeholder="Email" name="email" class="w-full mb-4 px-7 py-2 border rounded-lg
                placeholder-gray-400 placeholder:text-sm placeholder:italic
                focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <input type="password" placeholder="Password" name="password" class="w-full px-7 py-2 border rounded-lg
                placeholder-gray-400 placeholder:text-sm placeholder:italic
                focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <button class="bg-blue-600 mt-4 px-3 py-1 rounded-lg text-white hover:bg-blue-700" type="submit" name="login">Login</button>
        </div>

        <p class="text-gray-500 flex justify-center items-center text-sm gap-2">
            Don't have an account? 
            <a href="#" class="text-blue-600 hover:underline" onclick="showForm('register-form')">Register</a>
        </p>
    </form>
</div>

<!-- REGISTER FORM -->
<div class="form-box bg-white rounded-lg p-8 <?= isActiveForm('register',$activeForm); ?>" id="register-form">
    <form action="login_register.php" method="post">
        <h2 class="text-black font-bold text-2xl flex justify-center items-center">Register</h2>

        <?= showError($errors['register']); ?>

        <div class="placeholders flex flex-col p-3 m-3">
            <input type="text" placeholder="Name" name="name" class="w-full mb-4 px-7 py-2 border rounded-lg
                placeholder-gray-400 placeholder:text-sm placeholder:italic
                focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <input type="email" placeholder="Email" name="email" class="w-full mb-4 px-7 py-2 border rounded-lg
                placeholder-gray-400 placeholder:text-sm placeholder:italic
                focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <input type="password" placeholder="Password" name="password" class="w-full px-7 py-2 border rounded-lg
                placeholder-gray-400 placeholder:text-sm placeholder:italic
                focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <select name="role" class="w-full mb-4 px-7 py-2 border rounded-lg mt-4" required>
                <option value="">--Select Role--</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button class="bg-blue-600 mt-4 px-3 py-1 rounded-lg text-white hover:bg-blue-700" type="submit" name="register">Register</button>
        </div>

        <p class="text-gray-500 flex justify-center items-center text-sm gap-2">
            Already have an account? 
            <a href="#" class="text-blue-600 hover:underline" onclick="showForm('login-form')">Login</a>
        </p>
    </form>
</div>

<script src="script.js"></script>
</body>
</html>
