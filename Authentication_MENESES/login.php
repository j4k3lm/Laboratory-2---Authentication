<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $message = 'All fields are required.';
        $messageType = 'error';
    } else {
        $file = 'data/users.json';
        $users = json_decode(file_get_contents($file), true);

        $foundUser = null;
        foreach ($users as $user) {
            if ($user['email'] == $email) {
                $foundUser = $user;
                break;
            }
        }

        if ($foundUser && password_verify($password, $foundUser['password'])) {
            $_SESSION['user'] = $foundUser;
            header('Location: dashboard.php');
            exit();
        } else {
            $message = 'Invalid email or password.';
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (!empty($message)) { ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <form method="POST" onsubmit="return validateLoginForm()">
            <input type="email" name="email" id="email" placeholder="Enter your email">
            <input type="password" name="password" id="password" placeholder="Enter your password">
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
