<?php
require_once '../app/core/auth.php';
require_admin();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Панель администратора</h1>
        <nav>
            <a href="manage_pokemon.php">Управление покемонами</a> |
            <a href="manage_users.php">Пользователи</a> |
            <a href="logout.php">Выход</a>
        </nav>
    </header>

    <main>
        <p>Вы вошли как <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> (<?= $_SESSION['role'] ?>).</p>
        <p>Выберите нужный раздел.</p>
    </main>
</body>
</html>
