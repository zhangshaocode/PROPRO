<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../../config.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<body>
    <h1>欢迎 <?= htmlspecialchars($user['username']) ?></h1>
    <p>用户码：<?= $user['user_code'] ?></p>
    <p>账户状态：<?= $user['is_active'] ? '已激活' : '未激活' ?></p>
    <a href="/p/logout.php">退出登录</a>
</body>
</html>
