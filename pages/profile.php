<?php 
session_start();
include '../includes/config.php'; 
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch the user's profile data
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $login_name = $_POST['login_name'];
    $profile_picture = $user['profile_picture']; // Keep current profile picture by default

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $upload_dir = '../uploads/'; // Ensure this directory exists
        $file_name = basename($_FILES['profile_picture']['name']);
        $target_file = $upload_dir . $file_name;
        
        // Validate the file type (you can add more types as needed)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['profile_picture']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            // Move the file to the uploads directory
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file;  // Update profile picture path
            } else {
                echo "<p>Error uploading file.</p>";
            }
        } else {
            echo "<p>Invalid file type. Please upload a JPG, PNG, or GIF image.</p>";
        }
    }

    // Update user profile in the database
    $stmt = $pdo->prepare("UPDATE users SET name = ?, age = ?, login_name = ?, profile_picture = ? WHERE user_id = ?");
    if ($stmt->execute([$name, $age, $login_name, $profile_picture, $user_id])) {
        echo "<p>Profile updated successfully!</p>";
        header('Location: profile.php');  // Reload the profile page to show updated info
        exit;
    } else {
        echo "<p>Error updating profile.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile - Fitness Tracker</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Your stylesheet -->
</head>
<body>
    <div class="container">
        <h2>Your Profile</h2>

        <!-- Display current profile information -->
        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
            <p><strong>Login Name:</strong> <?php echo htmlspecialchars($user['login_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

            <?php if ($user['profile_picture']): ?>
                <p><strong>Profile Picture:</strong></p>
                <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" width="150">
            <?php else: ?>
                <p>No profile picture uploaded.</p>
            <?php endif; ?>
        </div>

        <!-- Form to update profile information -->
        <h3>Update Your Profile</h3>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>

            <label for="login_name">Login Name:</label>
            <input type="text" id="login_name" name="login_name" value="<?php echo htmlspecialchars($user['login_name']); ?>" required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
