<?php
$connection = mysqli_connect("localhost", "root", "dashingadi", "blog1");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();

$registration_error = '';
if (isset($_POST['submit'])) {
    $name = trim(mysqli_real_escape_string($connection, $_POST['name']));
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if (empty($name)) {
        $registration_error = "Username cannot be empty.";
    } elseif (strlen($name) < 3) {
        $registration_error = "Username must be at least 3 characters long.";
    } elseif (strlen($pass) < 8) {
        $registration_error = "Password must be at least 8 characters long.";
    } elseif ($pass !== $confirm_pass) {
        $registration_error = "Passwords do not match.";
    } else {
        $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE name = ?");
        mysqli_stmt_bind_param($stmt, 's', $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) {
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($connection, "INSERT INTO users (name, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, 'ss', $name, $hashed_pass);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit();
            } else {
                $registration_error = "Registration failed. Please try again.";
            }
        } else {
            $registration_error = "Username already exists.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .registration-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
        .registration-header {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        .btn-register {
            background-color: #2ecc71;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-register:hover {
            background-color: #27ae60;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52,152,219,0.25);
        }
        .password-requirements {
            font-size: 0.8em;
            color: #7f8c8d;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="registration-container">
        <h2 class="registration-header">Create Your Account</h2>
        
        <?php if (!empty($registration_error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($registration_error); ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="name" 
                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                       required minlength="3">
                <div class="password-requirements">
                    Username must be at least 3 characters long
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" 
                       required minlength="8">
                <div class="password-requirements">
                    Password must be at least 8 characters long
                </div>
            </div>
            
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" 
                       name="confirm_password" required minlength="8">
            </div>
            
            <button type="submit" name="submit" class="btn btn-register btn-success w-100">
                Create Account
            </button>
            
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted">Already have an account? Login</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>