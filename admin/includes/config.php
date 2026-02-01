<?php
$conn = mysqli_connect("localhost", "root", "", "job_application");

if (!$conn) {
    die("Database connection failed");
}

session_start();
?>