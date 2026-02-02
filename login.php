<?php
session_start(); // 这一行必须在最上面
require 'db_connect.php'; // 你的数据库连接

// --- 新加的安检门 ---
// 如果用户已经有 ID 了（说明已登录），直接送去 Dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
// -------------------

// ... 下面才是原本的登录/注册逻辑 ...
require 'db_connect.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. 根据邮箱查找用户
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // 2. 验证密码 (将输入的密码与数据库里的哈希密码对比)
        if (password_verify($password, $row['password'])) {
            // 3. 密码正确，设置 Session 变量
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];

            // 4. 跳转到 Dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error_msg = "Invalid password.";
        }
    } else {
        $error_msg = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="system.css">
</head>
<body>
    <nav>
        <div class="container">
            <h1>JobSeeker</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php">Sign Up</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h2 style="text-align: center;">Welcome Back</h2>
        
        <?php if($error_msg != ""): ?>
            <p style="color: red; text-align: center;"><?php echo $error_msg; ?></p>
        <?php endif; ?>

        <form action="" method="POST"> 
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn" style="width: 100%;">Login</button>
        </form>
        <p style="text-align: center;">Don't have an account? <a href="register.php">Sign Up</a></p>
    </div>
</body>
</html>