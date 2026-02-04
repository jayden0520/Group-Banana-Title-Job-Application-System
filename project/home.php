<?php
include 'config/db.php';
$jobs = mysqli_query($conn, "SELECT * FROM jobs");
$selectedJobId = $_GET['job_id'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Listings</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/job.js" defer></script>
</head>
<body>

<div class="main-layout">

    <!-- LEFT: Job Catalogue -->
    <div class="job-list-column">
        <?php while ($job = mysqli_fetch_assoc($jobs)) { ?>
            <div class="job-card <?= ($job['job_id']==$selectedJobId)?'active':'' ?>">
                <h3><?= $job['title'] ?></h3>
                <p><?= $job['location'] ?></p>
                <a href="home.php?job_id=<?= $job['job_id'] ?>" class="btn">View</a>
            </div>
        <?php } ?>
    </div>

    <!-- RIGHT: Job Details -->
    <div class="job-preview-column">
        <?php
        if ($selectedJobId) {
            $detail = mysqli_query($conn, "SELECT * FROM jobs WHERE job_id=$selectedJobId");
            $job = mysqli_fetch_assoc($detail);
        ?>
            <div class="detail-content active">
                <h2><?= $job['title'] ?></h2>
                <p><b>Department:</b> <?= $job['department'] ?></p>
                <p><b>Location:</b> <?= $job['location'] ?></p>

                <h4>Description</h4>
                <p><?= $job['description'] ?></p>

                <h4>Requirements</h4>
                <p><?= $job['requirements'] ?></p>

                <a href="apply.php?job_id=<?= $job['job_id'] ?>" class="btn">Apply Now</a>
            </div>
        <?php } else { ?>
            <p>Select a job to view details.</p>
        <?php } ?>
    </div>

</div>

</body>
</html>
