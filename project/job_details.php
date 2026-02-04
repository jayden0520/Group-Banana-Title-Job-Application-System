<?php
include 'config/db.php';

$id = $_GET['id'];
$result = mysqli_query($conn,"SELECT * FROM jobs WHERE job_id=$id");
$job = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav>
<div class="container">
<h1>JobSeeker</h1>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="about_us.php">About Us</a></li>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="dashboard.php?logout=true" style="color:#ff6b6b;">Logout</a></li>
</ul>
</div>
</nav>

<div class="form-container">

<h2><?= $job['title']?></h2>

<p><b>Department:</b> <?= $job['department']?></p>
<p><b>Location:</b> <?= $job['location']?></p>

<h3>Description</h3>
<p><?= $job['description']?></p>

<h3>Requirements</h3>
<p><?= $job['requirements']?></p>

<a href="apply.php?job_id=<?= $job['job_id']?>" class="btn">Apply Now</a>

</div>

</body>
</html>
