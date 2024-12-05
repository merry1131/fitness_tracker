<?php 
session_start();
include '../includes/config.php'; 
include '../includes/header.php';



// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user's goals
$stmt = $pdo->prepare("SELECT * FROM goals WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$goals = $stmt->fetchAll();

// Handle form submission for adding a new goal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_goal'])) {
    $description = $_POST['description'];  
    $target_date = $_POST['target_date']; 
    $user_id = $_SESSION['user_id'];

    // Insert new goal into database
    $stmt = $pdo->prepare("INSERT INTO goals (user_id, description, target_date) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $description, $target_date])) {
        echo "<p>Goal added successfully!</p>";
        header('Location: view_goals.php');  // Reload the page after insertion
        exit;
    } else {
        echo "<p>Error adding goal.</p>";
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $goal_id = $_GET['delete'];
    
    // Delete goal from the database
    $stmt = $pdo->prepare("DELETE FROM goals WHERE goal_id = ? AND user_id = ?");
    if ($stmt->execute([$goal_id, $_SESSION['user_id']])) {
        echo "<p>Goal deleted successfully!</p>";
        header('Location: view_goals.php');  // Reload the page after deletion
        exit;
    } else {
        echo "<p>Error deleting goal.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Goals - Fitness Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Your Goals</h2>

        <?php if (empty($goals)): ?>
            <p>No goals set yet.</p>  
        <?php else: ?>
            <ul>
                <?php foreach ($goals as $goal): ?>
                    <li>
                        <?php echo htmlspecialchars($goal['description']); ?> 
                        (Set for <?php echo isset($goal['target_date']) ? date('Y-m-d', strtotime($goal['target_date'])) : 'No date set'; ?>)

                        <!-- Add Edit and Delete buttons -->
                        <a href="edit_goals.php?id=<?php echo $goal['goal_id']; ?>">Edit</a> |
                        <a href="view_goals.php?delete=<?php echo $goal['goal_id']; ?>" onclick="return confirm('Are you sure you want to delete this goal?');">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Form to Add New Goal -->
        <h3>Add a New Goal</h3>
        <form method="POST">
            <input type="text" name="description" placeholder="Describe your goal" required>
            <input type="date" name="target_date" placeholder="Target date (optional)">
            <button type="submit" name="add_goal">Add Goal</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
