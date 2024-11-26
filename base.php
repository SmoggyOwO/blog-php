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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            padding-top: 50px;
        }
        .blog-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 30px;
        }
        .blog-header {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .blog-table {
            margin-top: 20px;
        }
        .btn-read {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .btn-read:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container blog-container">
        <h1 class="blog-header">My Blog Posts</h1>
        <div class="table-responsive">
            <table class="table table-hover blog-table">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Preview</th>
                        <th>Posted By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($sql)) {
                        $title = htmlspecialchars($row['title']);
                        $content = htmlspecialchars($row['content']);
                        $category = htmlspecialchars($row['category']);
                        $posted = htmlspecialchars($row['Postedby']);
                    ?>
                        <tr>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $category; ?></td>
                            <td><?php echo substr($content, 0, 50) . "..."; ?></td>
                            <td><?php echo $posted; ?></td>
                            <td>
                                <a href="read_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-read">
                                    Read More
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>