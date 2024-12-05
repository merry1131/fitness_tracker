<?php 
session_start();
include '../includes/config.php'; 
include '../includes/header.php'; 
?>

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
<body>
    <div class="container">
        <h2>Welcome to Fitness Tracker</h2>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="login-container">
                <h3>Login</h3>
                <form method="POST" action="login.php"> <!-- Adjust the action to your login processing file -->
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        <?php else: ?>
            <p>You are logged in!</p>
            <div class="dashboard-links">
                <p><a class="btn" href="dashboard.php">Dashboard</a></p>
                <p><a class="btn" href="add_workout.php">Add Workout</a></p>
                <p><a class="btn" href="view_workouts.php">View Workouts</a></p>
                <p><a class="btn" href="view_goals.php">View Goals</a></p>
                <p><a class="btn" href="logout.php">Logout</a></p>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
