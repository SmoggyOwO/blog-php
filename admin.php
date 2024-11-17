<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    echo "You must log in first <a href='index.php'>Login</a>";
    exit();
}

$connection = mysqli_connect("localhost", "root", "dashingadi", "blog1");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $content = mysqli_real_escape_string($connection, $_POST['content']);
    $postedBy = $_SESSION['name'];

    // Insert new blog post
    $stmt = mysqli_prepare($connection, "INSERT INTO blogdata (title, category, content, Postedby) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $title, $category, $content, $postedBy);
    mysqli_stmt_execute($stmt);

    header("Location: base.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        .well { margin-top: 41px; }
        .col-md-4 { margin-top: 40px; }
    </style>
</head>
<body>

<div class="col-md-4 col-md-offset-8">
    Signed in as <?php echo $_SESSION['name']; ?><br><a href="logout.php">Logout</a>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="well">
            <h1>Create New Post</h1>
            <hr>
            <form action="admin.php" method="post">
                <h4>Title:</h4><input class="form-control" type="text" name="title" required><br>
                <h4>Category:</h4><input class="form-control" type="text" name="category"><br>
                <h4>Content:</h4><textarea class="form-control" name="content" required></textarea><br>
                <input type="submit" name="submit" value="Post" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>
</div>

</body>
</html>
