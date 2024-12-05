<?php 
session_start();
include '../includes/config.php'; 
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise = $_POST['exercise'];
    $reps = $_POST['reps'];
    $sets = $_POST['sets'];
    $weight = $_POST['weight'];
    $user_id = $_SESSION['user_id'];

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO workouts (user_id, date, exercise, reps, sets, weight) VALUES (?, CURDATE(), ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $exercise, $reps, $sets, $weight])) {
        echo "<p>Workout added successfully!</p>";
    } else {
        echo "<p>Error adding workout.</p>";
    }
}
?>

<div class="container">
    <h2>Add Workout</h2>
    <form method="POST">
        <input type="text" name="exercise" placeholder="Exercise Name" required>
        <input type="number" name="reps" placeholder="Reps" required>
        <input type="number" name="sets" placeholder="Sets" required>
        <input type="number" name="weight" placeholder="Weight (Kg)" step="0.1" required>
        <button type="submit">Add Workout</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
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