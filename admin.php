<?php
session_start();

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .post-container {
            max-width: 700px;
            margin: auto;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .btn-post {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }
        .btn-post:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="header-section">
            <h2 class="mb-0">Create New Blog Post</h2>
            <div>
                <span class="me-3">Signed in as <?php echo $_SESSION['name']; ?></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>

        <div class="post-container">
            <form action="admin.php" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-post btn-primary w-100">Post Blog</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>