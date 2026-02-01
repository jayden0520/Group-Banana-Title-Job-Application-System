<?php
require_once 'includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

/* UPDATE APPLICATION STATUS */
if (isset($_POST['update'])) {
    $id = intval($_POST['application_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "
        UPDATE job_applications 
        SET status='$status'
        WHERE application_id=$id
    ");
    header("Location: applications.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Job Applications</title>
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

            <h2 class="mt-4 fw-bold">Job Applications</h2>
            <p class="text-muted">Review and manage applications</p>

            <div class="card">
                <div class="card-header fw-bold">
                    Application List
                </div>

                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Applicant</th>
                                <th>Job Title</th>
                                <th>Status</th>
                                <th width="220">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $result = mysqli_query($conn, "
                            SELECT a.application_id, a.status,
                                   ap.full_name, j.title
                            FROM job_applications a
                            JOIN applicants ap ON a.applicant_id = ap.applicant_id
                            JOIN jobs j ON a.job_id = j.job_id
                            ORDER BY a.application_id DESC
                        ");
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?= $row['application_id']; ?></td>
                                <td><?= $row['full_name']; ?></td>
                                <td><?= $row['title']; ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php elseif ($row['status'] == 'Rejected'): ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="application_id"
                                               value="<?= $row['application_id']; ?>">
                                        <select name="status" class="form-select form-select-sm">
                                            <option <?= $row['status']=='Pending'?'selected':''; ?>>Pending</option>
                                            <option <?= $row['status']=='Approved'?'selected':''; ?>>Approved</option>
                                            <option <?= $row['status']=='Rejected'?'selected':''; ?>>Rejected</option>
                                        </select>
                                        <button class="btn btn-sm btn-primary" name="update">
                                            Update
                                        </button>
                                    </form>
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
