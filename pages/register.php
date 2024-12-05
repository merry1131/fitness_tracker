<?php
include '../includes/config.php'; 
include '../includes/header.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $email]);
    header("Location: login.php");
}
?>
<form method="post" action="register.php" onsubmit="return validateRegisterForm()">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Register</button>
</form>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fitness Tracker</title>
    <!-- Correct CSS link -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Go up one level to css folder -->
</head>
