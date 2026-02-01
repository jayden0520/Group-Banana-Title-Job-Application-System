<?php
require_once 'includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

/* DELETE APPLICANT */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM applicants WHERE applicant_id=$id");
    header("Location: applicants.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Applicants</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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

            <h2 class="mt-4 fw-bold">Applicants</h2>
            <p class="text-muted">Registered job seekers</p>

            <div class="card">
                <div class="card-header fw-bold">
                    Applicant List
                </div>

                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registered Date</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $result = mysqli_query($conn, "
                            SELECT * FROM applicants 
                            ORDER BY applicant_id DESC
                        ");
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?= $row['applicant_id']; ?></td>
                                <td><?= $row['full_name']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td><?= $row['phone']; ?></td>
                                <td><?= $row['created_at']; ?></td>
                                <td>
                                    <a href="?delete=<?= $row['applicant_id']; ?>"
                                       onclick="return confirm('Delete this applicant?');"
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

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
