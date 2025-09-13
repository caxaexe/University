<?php
session_start();

// Проверка авторизации и роли администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Админ-панель</h2>

    <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['username']) ?>! Вы - администратор.</p>

    <ul>
        <li><a href="manage_users.php">Управление пользователями</a></li>
        <li><a href="manage_pokemons.php">Управление покемонами</a></li>
    </ul>

    <a href="../logout.php">Выйти</a>
</body>
</html>
