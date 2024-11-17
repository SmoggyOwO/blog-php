<?php
// Connect to MySQL using mysqli
$connection = mysqli_connect("localhost", "root", "dashingadi", "blog1");

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        .well { margin-top: 50px; }
    </style>
</head>
<body>

<?php
if (isset($_POST['submit'])) {
    // Sanitize inputs
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $pass = $_POST['password'];

    // Use prepared statement to fetch user data
    $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE name = ?");
    mysqli_stmt_bind_param($stmt, 's', $name); // 's' means string
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if user exists and verify password
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row['password'])) {  // Verify hashed password
            $_SESSION['name'] = $name;
            header("Location: admin.php");
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User does not exist.";
    }
}
?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="well">
            <form action="index.php" method="post">
                Username <input class="form-control" type="text" name="name" required><br>
                Password <input class="form-control" type="password" name="password" required><br>
                <input type="submit" name="submit" value="Login" class="btn btn-success btn-block"><br>
                <a href="register.php">Register?</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
