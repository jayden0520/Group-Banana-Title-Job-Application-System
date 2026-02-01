<?php
require_once 'includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

/* ADD JOB */
if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = intval($_POST['category_id']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn, "
        INSERT INTO jobs (title, category_id, location, salary, description)
        VALUES ('$title', $category, '$location', '$salary', '$desc')
    ");
}

/* DELETE JOB */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM jobs WHERE job_id=$id");
    header("Location: jobs.php");
    exit();
}

/* UPDATE JOB */
if (isset($_POST['update'])) {
    $id = intval($_POST['job_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = intval($_POST['category_id']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn, "
        UPDATE jobs SET
            title='$title',
            category_id=$category,
            location='$location',
            salary='$salary',
            description='$desc'
        WHERE job_id=$id
    ");
    header("Location: jobs.php");
    exit();
}

/* FETCH CATEGORIES */
$categories = mysqli_query($conn, "SELECT * FROM job_categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Job Postings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }
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

            <h2 class="mt-4 fw-bold">Job Postings</h2>
            <p class="text-muted">Create and manage job vacancies</p>

            <!-- ADD JOB -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Add New Job</h5>
                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control"
                                       placeholder="Job Title" required>
                            </div>

                            <div class="col-md-6">
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php while ($c = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?= $c['category_id']; ?>">
                                            <?= $c['category_name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="location" class="form-control"
                                       placeholder="Location">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="salary" class="form-control"
                                       placeholder="Salary Range">
                            </div>

                            <div class="col-12">
                                <textarea name="description" class="form-control"
                                          placeholder="Job Description" rows="4" required></textarea>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" name="add">Add Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- JOB TABLE -->
            <div class="card">
                <div class="card-header fw-bold">
                    Job List
                </div>

                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th width="160">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $result = mysqli_query($conn, "
                            SELECT j.*, c.category_name
                            FROM jobs j
                            JOIN job_categories c ON j.category_id = c.category_id
                            ORDER BY j.job_id DESC
                        ");
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?= $row['job_id']; ?></td>
                                <td><?= $row['title']; ?></td>
                                <td><?= $row['category_name']; ?></td>
                                <td><?= $row['location']; ?></td>
                                <td><?= $row['salary']; ?></td>
                                <td>
                                    <a href="?edit=<?= $row['job_id']; ?>"
                                       class="btn btn-sm btn-success">Edit</a>
                                    <a href="?delete=<?= $row['job_id']; ?>"
                                       onclick="return confirm('Delete this job?');"
                                       class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- EDIT JOB -->
            <?php if (isset($_GET['edit'])):
                $id = intval($_GET['edit']);
                $job = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM jobs WHERE job_id=$id"));
                $cats2 = mysqli_query($conn, "SELECT * FROM job_categories");
            ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h5>Edit Job</h5>
                    <form method="POST">
                        <input type="hidden" name="job_id" value="<?= $job['job_id']; ?>">

                        <input type="text" name="title" class="form-control mb-2"
                               value="<?= $job['title']; ?>" required>

                        <select name="category_id" class="form-select mb-2">
                            <?php while ($c = mysqli_fetch_assoc($cats2)): ?>
                                <option value="<?= $c['category_id']; ?>"
                                    <?= $c['category_id']==$job['category_id']?'selected':''; ?>>
                                    <?= $c['category_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <input type="text" name="location" class="form-control mb-2"
                               value="<?= $job['location']; ?>">

                        <input type="text" name="salary" class="form-control mb-2"
                               value="<?= $job['salary']; ?>">

                        <textarea name="description" class="form-control mb-3"
                                  rows="4"><?= $job['description']; ?></textarea>

                        <button class="btn btn-warning" name="update">Update Job</button>
                        <a href="jobs.php" class="btn btn-secondary">Cancel</a>
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
