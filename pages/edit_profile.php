<?php 
session_start();
include '../includes/config.php'; 
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the user's current profile data
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, name, age, profile_picture FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted data
    $name = $_POST['name'];
    $age = $_POST['age'];

    // Handle file upload for the profile picture
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $uploadedFile = $_FILES['profile_picture'];
        $fileName = basename($uploadedFile['name']);
        $filePath = '../uploads/' . $fileName;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
            // Update the profile picture in the database
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
            $stmt->execute([$fileName, $user_id]);
        } else {
            echo "<p>Failed to upload the profile picture.</p>";
        }
    }

    // Update name and age in the database
    $stmt = $pdo->prepare("UPDATE users SET name = ?, age = ? WHERE user_id = ?");
    $stmt->execute([$name, $age, $user_id]);

    echo "<p>Your profile has been updated successfully!</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Your Profile</h2>

        <!-- Profile Edit Form -->
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>

            
        </form>
        
        <a href="dashboard.php" class="btn">Go Back to Dashboard</a>
    </div>
</body>
</html>


