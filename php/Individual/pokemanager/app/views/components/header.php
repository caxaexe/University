<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeManager</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <script defer src="/public/js/validation.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <h1><a href="public/index.php">PokeManager</a></h1>
        </div>
        <nav>
            <ul>
                <li><a href="public/index.php">Главная</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="public/login.php">Войти</a></li>
                    <li><a href="public/register.php">Зарегистрироваться</a></li>
                <?php else: ?>
                    <li><a href="public/dashboard.php">Личный кабинет</a></li>
                    <li><a href="public/logout.php">Выйти</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <li><a href="public/admin/manage_users.php">Управление пользователями</a></li>
                    <li><a href="public/admin/manage_pokemon.php">Управление покемонами</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
