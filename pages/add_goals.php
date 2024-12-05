<?php
session_start();
include '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];  // Use 'description' as it matches the column in the database
    $target_date = $_POST['target_date'];  // Optionally handle a target date
    $user_id = $_SESSION['user_id'];

    // Insert into the database, using the 'description' column for the goal
    $stmt = $pdo->prepare("INSERT INTO goals (user_id, description, target_date) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $description, $target_date])) {
        echo "<p>Goal added successfully!</p>";
    } else {
        echo "<p>Error adding goal.</p>";
    }
}
?>

<!-- HTML form to input the goal and target date -->
<div class="container">
    <h2>Set Your Goal</h2>
    <form method="POST">
        <input type="text" name="description" placeholder="Describe your goal" required>
        <input type="date" name="target_date" placeholder="Target date (optional)">
        <button type="submit">Set Goal</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>


