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
// 引入数据库连接
require 'db_connect.php';

$error_msg = "";
$success_msg = "";

// 只有当用户点击 "Register" 提交表单时，才会执行下面的代码
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. 后端简单验证
    if ($password !== $confirm_password) {
        $error_msg = "Passwords do not match!";
    } else {
        // 2. 检查邮箱是否已被注册
        $check_sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($result) > 0) {
            $error_msg = "Email is already registered!";
        } else {
            // 3. 密码加密 (非常重要！永远不要存明文密码)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 4. 插入数据库
            $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";

            if (mysqli_query($conn, $sql)) {
                // 注册成功，跳转到登录页
                echo "<script>alert('Registration Successful! Please Login.'); window.location.href='login.php';</script>";
                exit();
            } else {
                $error_msg = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Job Portal</title>
    <link rel="stylesheet" href="system.css">
</head>
<body>
    <nav>
        <div class="container">
            <h1>JobSeeker</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h2 style="text-align: center;">Create an Account</h2>
        
        <?php if($error_msg != ""): ?>
            <p style="color: red; text-align: center;"><?php echo $error_msg; ?></p>
        <?php endif; ?>

        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" id="fullname" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" required>
                <small class="error-msg" id="passError">Password must be at least 6 characters.</small>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <small class="error-msg" id="matchError">Passwords do not match.</small>
            </div>

            <button type="submit" class="btn" style="width: 100%;">Register</button>
        </form>
        <p style="text-align: center;">Already have an account? <a href="login.php">Login</a></p>
    </div>

    <script>
        function validateForm() {
            var pass = document.getElementById("password").value;
            var confirmPass = document.getElementById("confirm_password").value;
            var isValid = true;
            if (pass.length < 6) {
                document.getElementById("passError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("passError").style.display = "none";
            }
            if (pass !== confirmPass) {
                document.getElementById("matchError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("matchError").style.display = "none";
            }
            return isValid;
        }
    </script>
</body>
</html>
</html>