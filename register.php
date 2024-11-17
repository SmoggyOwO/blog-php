<?php
$connection = mysqli_connect("localhost", "root", "dashingadi", "blog1");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $pass = $_POST['password'];

    // Check if the user already exists
    $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE name = ?");
    mysqli_stmt_bind_param($stmt, 's', $name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        // Hash the password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Insert the user into the database
        $stmt = mysqli_prepare($connection, "INSERT INTO users (name, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ss', $name, $hashed_pass);
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
    } else {
        echo "That user already exists. Go <a href='register.php'>back</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        .col-md-4 { margin-top: 50px; }
    </style>
</head>
<body>

<div class="col-md-4 col-md-offset-4">
    <div class="well">
        <form action="register.php" method="post">
            Username<input class="form-control" type="text" name="name" required><br>
            Password<input class="form-control" type="password" name="password" required><br>
            <input type="submit" name="submit" class="btn btn-warning btn-block" value="Register"><br>
            <a href="index.php">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>
