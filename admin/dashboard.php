<?php
require_once 'includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Dashboard statistics
$totalJobs = mysqli_fetch_row(
    mysqli_query($conn, "SELECT COUNT(*) FROM jobs")
)[0];

$totalApplicants = mysqli_fetch_row(
    mysqli_query($conn, "SELECT COUNT(*) FROM applicants")
)[0];

$totalApplications = mysqli_fetch_row(
    mysqli_query($conn, "SELECT COUNT(*) FROM job_applications")
)[0];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== Custom Branding =====
           Purpose: improve visual identity and consistency
        */
        body {
            background-color: #f8f9fa;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.15);
        }
    </style>
</head>

<body>

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

            <h2 class="mt-4 fw-bold">Dashboard</h2>
            <p class="text-muted">Welcome, <?php echo $_SESSION['admin']; ?></p>

            <!-- Stat Cards -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card text-bg-primary">
                        <div class="card-body">
                            <h4><?php echo $totalJobs; ?></h4>
                            <p>Total Jobs</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card text-bg-success">
                        <div class="card-body">
                            <h4><?php echo $totalApplicants; ?></h4>
                            <p>Total Applicants</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card text-bg-warning">
                        <div class="card-body">
                            <h4><?php echo $totalApplications; ?></h4>
                            <p>Total Applications</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="card-header fw-bold">
                    Recent Applications
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Job</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ali</td>
                                <td>Web Developer</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Siti</td>
                                <td>UI Designer</td>
                                <td><span class="badge bg-success">Approved</span></td>
                            </tr>
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
