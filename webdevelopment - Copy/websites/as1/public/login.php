<?php
require_once 'dbconnect.php';

// Initialize variables
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        // Check user in DB
        $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($dbUsername, $dbPasswordHash);
            $stmt->fetch();

            if (password_verify($password, $dbPasswordHash)) {
                $_SESSION['logged-in'] = true;
                $_SESSION['username'] = $dbUsername;
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'User not found.';
        }

        $stmt->close();
    }
}
?>

<style>
    .login-form {
        max-width: 400px;
        margin: 2em auto;
        padding: 2em;
        background: #f2f2f2;
        border-radius: 10px;
        font-family: Arial, sans-serif;
    }

    .login-form h2 {
        text-align: center;
        margin-bottom: 1em;
    }

    .login-form label {
        display: block;
        margin-top: 1em;
    }

    .login-form input[type="text"],
    .login-form input[type="password"] {
        width: 100%;
        padding: 0.5em;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .login-form input[type="submit"] {
        margin-top: 1em;
        width: 100%;
        padding: 0.6em;
        background-color: #00adb5;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .login-form .error {
        color: red;
        text-align: center;
        margin-top: 1em;
    }
</style>

<div class="login-form">
    <h2>Login to Car Purchase</h2>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required />

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required />

        <input type="submit" value="Login" />
    </form>
</div>
