<header>
    <h1>Fitness Tracker</h1>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="add_workout.php">Add Workout</a>
            <a href="view_workouts.php">View Workouts</a>
            <a href="view_goals.php">View Goals</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="index.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<style>
    body {
        background-color: #ffe6f0;
    }
</style>

