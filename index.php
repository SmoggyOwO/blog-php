<?php
$connection = mysqli_connect("localhost", "root", "dashingadi", "blog1");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        .btn-login {
            background-color: #3498db;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #2980b9;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-container">
        <h2 class="login-header">Blog Login</h2>
        <?php
        if (isset($_POST['submit'])) {
            $name = mysqli_real_escape_string($connection, $_POST['name']);
            $pass = $_POST['password'];

            $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE name = ?");
            mysqli_stmt_bind_param($stmt, 's', $name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($pass, $row['password'])) {
                    $_SESSION['name'] = $name;
                    header("Location: admin.php");
                    exit();
                } else {
                    echo '<div class="alert alert-danger">Incorrect username or password.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">User does not exist.</div>';
            }
        }
        ?>
        <form action="index.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="name" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-login btn-primary w-100">Login</button>
        </form>
        <div class="register-link">
            <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>