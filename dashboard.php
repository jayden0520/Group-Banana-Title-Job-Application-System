<?php
session_start();

// security feature if no login will sent to login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - JobSeeker</title>
    <link rel="stylesheet" href="system.css">
</head>
<body>

    <nav>
        <div class="container">
            <h1>JobSeeker</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="dashboard.php?logout=true" style="color: #ff6b6b;">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        
        <aside class="sidebar">
            <div style="padding: 20px; text-align: center; border-bottom: 1px solid #eee;">
                <img src="https://via.placeholder.com/80" alt="User Profile" style="border-radius: 50%; margin-bottom: 10px;">
                <h4 style="margin:0;"><?php echo $_SESSION['fullname']; ?></h4>
                <small style="color:#777;"><?php echo $_SESSION['email']; ?></small>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active">My Overview</a></li>
                <li><a href="#">My Applications</a></li>
                <li><a href="#">Saved Jobs</a></li>
                <li><a href="#">Profile Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            
            <h2 style="margin-top:0;">Welcome back, <?php echo $_SESSION['fullname']; ?>!</h2>
            <p style="color: #666; margin-bottom: 30px;">Here is what's happening with your job applications today.</p>

            <div class="stats-grid">
                <div class="card">
                    <h3>0</h3>
                    <p>Applications Sent</p>
                </div>
                <div class="card">
                    <h3>0</h3>
                    <p>Interviews</p>
                </div>
            </div>

            <div class="table-container">
                <h3 style="margin-top: 0; margin-bottom: 20px;">Recent Applications</h3>
                <p>No applications yet.</p>
                </div>

        </main>
    </div>

    <footer style="text-align: center; padding: 20px; background-color: #ddd; margin-top: 50px;">
        <p>&copy; 2026 JobSeeker System. All rights reserved.</p>
    </footer>

</body>
</html>
