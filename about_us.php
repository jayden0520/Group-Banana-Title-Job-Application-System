<?php
// 1. 开启 Session (必须在第一行)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Job Portal</title>
    <link rel="stylesheet" href="system.css">
</head>
<body>

    <nav>
        <div class="container">
            <h1>JobSeeker</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="dashboard.php?logout=true" style="color: #ff6b6b;">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container" style="text-align: center; margin-top: 50px;">
        <h2>Meet Our Team</h2>
        <p>We are a group of passionate students from MMU building the future of recruitment.</p>
        
        <div style="display: flex; justify-content: space-around; margin-top: 40px;">
            <div style="background: white; padding: 20px; width: 30%; border-radius: 8px;">
                <img src="https://via.placeholder.com/150" alt="Member A" style="border-radius: 50%;">
                <h3>Jayden Low Yong Yi</h3>
                <p>Lead Developer (Frontend)</p>
            </div>
            <div style="background: white; padding: 20px; width: 30%; border-radius: 8px;">
                <img src="https://via.placeholder.com/150" alt="Member B" style="border-radius: 50%;">
                <h3>Lim Ren Han</h3>
                <p>Backend Developer</p>
            </div>
            <div style="background: white; padding: 20px; width: 30%; border-radius: 8px;">
                <img src="https://via.placeholder.com/150" alt="Member C" style="border-radius: 50%;">
                <h3>Kelvin Lee Lun Hao</h3>
                <p>Database Admin</p>
            </div>
        </div>
    </div>

</body>
</html>