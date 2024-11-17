<?php
session_start();

$connection = mysqli_connect("localhost", "root", "dashingadi", "blog1");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['name'])) {
    echo "You must log in first <a href='index.php'>Login</a>";
    exit();
}

$sql = mysqli_query($connection, "SELECT * FROM blogdata ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>

<h1>Here is my Blog</h1><hr>

<table class="table table-stripped">
    <thead>
        <tr><th>Title</th><th>Category</th><th>Content</th><th>Posted By</th></tr>
    </thead>

    <?php
    while ($row = mysqli_fetch_array($sql)) {
        $title = $row['title'];
        $content = $row['content'];
        $category = $row['category'];
        $posted = $row['Postedby'];
    ?>
        <tbody>
            <tr>
                <td><?php echo $title; ?></td>
                <td><?php echo $category; ?></td>
                <td><?php echo substr($content, 0, 20) . "..."; ?></td>
                <td><?php echo $posted; ?></td>
                <td><button class="btn btn-success">Read</button></td>
            </tr>
        </tbody>
    <?php } ?>
</table>

</body>
</html>
