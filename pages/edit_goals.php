<?php 
session_start();
include '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get goal information
if (isset($_GET['id'])) {
    $goal_id = $_GET['id'];
    
    // Fetch goal from database
    $stmt = $pdo->prepare("SELECT * FROM goals WHERE goal_id = ? AND user_id = ?");
    $stmt->execute([$goal_id, $_SESSION['user_id']]);
    $goal = $stmt->fetch();

    if (!$goal) {
        echo "<p>Goal not found!</p>";
        exit;
    }
}

// Handle form submission for editing a goal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_goal'])) {
    $description = $_POST['description'];  
    $target_date = $_POST['target_date'];
    
    // Update the goal in the database
    $stmt = $pdo->prepare("UPDATE goals SET description = ?, target_date = ? WHERE goal_id = ? AND user_id = ?");
    if ($stmt->execute([$description, $target_date, $goal_id, $_SESSION['user_id']])) {
        echo "<p>Goal updated successfully!</p>";
        header('Location: view_goals.php');  // Redirect to view goals after update
        exit;
    } else {
        echo "<p>Error updating goal.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Goal - Fitness Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Your Goal</h2>

        <form method="POST">
            <input type="text" name="description" value="<?php echo htmlspecialchars($goal['description']); ?>" required>
            <input type="date" name="target_date" value="<?php echo $goal['target_date']; ?>">
            <button type="submit" name="update_goal">Update Goal</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
