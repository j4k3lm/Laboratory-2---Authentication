<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <p><strong>Welcome, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</strong></p>
        <p>You are now logged in.</p>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
