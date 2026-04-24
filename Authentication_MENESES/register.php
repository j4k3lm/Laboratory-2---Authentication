<?php
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $message = 'All fields are required.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email.';
        $messageType = 'error';
    } else {
        $file = 'data/users.json';
        $users = json_decode(file_get_contents($file), true);

        $emailExists = false;
        foreach ($users as $user) {
            if ($user['email'] == $email) {
                $emailExists = true;
                break;
            }
        }

        if ($emailExists) {
            $message = 'Email already registered.';
            $messageType = 'error';
        } else {
            $users[] = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
            $message = 'Registration successful. You can now log in.';
            $messageType = 'success';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <h2>Register</h2>

        <?php if (!empty($message)) { ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <form method="POST" onsubmit="return validateRegisterForm()">
            <input type="text" name="name" id="name" placeholder="Enter your name">
            <input type="email" name="email" id="email" placeholder="Enter your email">
            <input type="password" name="password" id="password" placeholder="Enter your password">
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
