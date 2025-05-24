<?php
require_once __DIR__ . 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user_code = substr(md5(uniqid(rand(), true)), 0, 8);

        $stmt = $conn->prepare("INSERT INTO users (email, username, password, user_code) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $username, $password, $user_code]);

        echo "注册成功！";
        header("Location: /p/index.php");
        exit();
    } catch(PDOException $e) {
        echo "错误: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>用户注册</h2>
    <form method="post">
        邮箱：<input type="email" name="email" required><br>
        用户名：<input type="text" name="username" required><br>
        密码：<input type="password" name="password" required><br>
        <input type="submit" value="注册">
    </form>
    <p>已有账号？<a href="/p/index.php">立即登录</a></p>
</body>
</html>