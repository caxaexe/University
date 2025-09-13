<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Добро пожаловать, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

    <p>Вы вошли как: <?= htmlspecialchars($_SESSION['role']) ?></p>

    <a href="logout.php">Выйти</a>
</body>
</html>
