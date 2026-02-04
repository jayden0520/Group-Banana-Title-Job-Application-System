<?php
include 'config/db.php';
$job_id = $_GET['job_id'];

if (isset($_POST['submit'])) {
    $user_id = 1; // demo user
    $cover = $_POST['cover'];

    mysqli_query($conn,
        "INSERT INTO applications (user_id, job_id, cover_letter)
         VALUES ('$user_id', '$job_id', '$cover')"
    );

    header("Location: confirmation.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply Job</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/job.js"></script>
</head>
<body>

<div class="form-container">
    <h2>Apply for Job</h2>

    <form method="post" onsubmit="return validateApplyForm()">
        <div class="form-group">
            <textarea name="cover" id="cover" placeholder="Cover Letter"></textarea>
        </div>
        <button class="btn" name="submit">Submit Application</button>
    </form>
</div>

</body>
</html>
