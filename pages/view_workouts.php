<?php 
session_start();
include '../includes/config.php'; 
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user's workouts
$stmt = $pdo->prepare("SELECT * FROM workouts WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$workouts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Workouts - Fitness Tracker</title>
    <!-- Correct CSS link -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Basic table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Workouts</h2>

        <?php if (empty($workouts)): ?>
            <p>No workouts found. <a href="add_workout.php">Add a workout</a> to get started!</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Exercise</th>
                        <th>Reps</th>
                        <th>Sets</th>
                        <th>Weight (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($workouts as $workout): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($workout['date']); ?></td>
                            <td><?php echo htmlspecialchars($workout['exercise']); ?></td>
                            <td><?php echo htmlspecialchars($workout['reps']); ?></td>
                            <td><?php echo htmlspecialchars($workout['sets']); ?></td>
                            <td><?php echo htmlspecialchars($workout['weight']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>

