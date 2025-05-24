<?php
session_start();
require_once __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: main/index.php");
            exit();
        } else {
            echo "邮箱或密码错误！";
        }
    } catch(PDOException $e) {
        echo "错误: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>用户登录</h2>
    <form method="post">
        邮箱：<input type="email" name="email" required><br>
        密码：<input type="password" name="password" required><br>
        <input type="submit" value="登录">
    </form>
    <p>没有账号？<a href="register.php">立即注册</a></p>
</body>
</html>