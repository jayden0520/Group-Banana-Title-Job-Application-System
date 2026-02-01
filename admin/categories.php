<?php
require_once 'includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$msg = "";

/* ADD CATEGORY */
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['category_name']);
    if (!empty($name)) {
        mysqli_query($conn, "INSERT INTO job_categories (category_name) VALUES ('$name')");
        $msg = "Category added successfully.";
    }
}

/* DELETE CATEGORY */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM job_categories WHERE category_id=$id");
    header("Location: categories.php");
    exit();
}

/* UPDATE CATEGORY */
if (isset($_POST['update'])) {
    $id = intval($_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['category_name']);
    mysqli_query($conn, "UPDATE job_categories SET category_name='$name' WHERE category_id=$id");
    header("Location: categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Job Categories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== Custom Branding ===== */
        body {
            background-color: #f8f9fa;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.15);
        }
    </style>
</head>

<body>

<!-- Mobile Navbar -->
<nav class="navbar navbar-dark bg-dark d-md-none">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand">JobPortal Admin</span>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <h2 class="mt-4 fw-bold">Job Categories</h2>
            <p class="text-muted">Manage job classification</p>

            <?php if ($msg): ?>
                <div class="alert alert-success"><?= $msg; ?></div>
            <?php endif; ?>

            <!-- Add Category -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <input type="text" name="category_name" class="form-control"
                                       placeholder="Category Name" required>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary w-100" name="add">
                                    Add Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category Table -->
            <div class="card">
                <div class="card-header fw-bold">
                    Category List
                </div>

                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM job_categories ORDER BY category_id DESC");
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?= $row['category_id']; ?></td>
                                <td><?= $row['category_name']; ?></td>
                                <td>
                                    <a href="?edit=<?= $row['category_id']; ?>" class="btn btn-sm btn-success">
                                        Edit
                                    </a>
                                    <a href="?delete=<?= $row['category_id']; ?>"
                                       onclick="return confirm('Delete this category?');"
                                       class="btn btn-sm btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Category -->
            <?php
            if (isset($_GET['edit'])):
                $id = intval($_GET['edit']);
                $cat = mysqli_fetch_assoc(
                    mysqli_query($conn, "SELECT * FROM job_categories WHERE category_id=$id")
                );
            ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h5>Edit Category</h5>
                    <form method="POST">
                        <input type="hidden" name="category_id" value="<?= $cat['category_id']; ?>">
                        <input type="text" name="category_name"
                               value="<?= $cat['category_name']; ?>"
                               class="form-control mb-2" required>
                        <button class="btn btn-warning" name="update">Update</button>
                        <a href="categories.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
            <?php endif; ?>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
