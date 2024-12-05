<?php 
session_start();
include '../includes/config.php'; 
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user's profile data from the database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, name, age, profile_picture FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Check if the user exists in the database
if ($user) {
    $username = htmlspecialchars($user['username']);
    $name = htmlspecialchars($user['name']);
    $age = htmlspecialchars($user['age']);
    $profile_picture = $user['profile_picture'];
} else {
    // Handle case where user data is not found
    $username = 'Unknown';
    $name = 'Not set';
    $age = 'Not set';
    $profile_picture = null;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard - Fitness Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <p>Welcome, <?php echo $username; ?>!</p>

        
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Age:</strong> <?php echo $age; ?></p>

        

        <p><a class="btn" href="edit_profile.php">Edit Profile</a></p>
        <p><a class="btn" href="add_workout.php">Add Workout</a></p>
        <p><a class="btn" href="view_workouts.php">View Workouts</a></p>
        <p><a class="btn" href="view_goals.php">View Goals</a></p>
    </div>

<?php include '../includes/footer.php'; ?>
</body>
</html>





