<?php
require_once '../app/core/Database.php';
require_once '../app/views/home.php';

$db = Database::connect();
$stmt = $db->query("SELECT name, type, level, generation FROM pokemons ORDER BY name LIMIT 6");
$pokemonList = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мир Покемонов</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Добро пожаловать в мир Покемонов!</h1>
        <nav>
            <a href="public/login.php">Вход</a>
            <a href="public/register.php">Регистрация</a>
        </nav>
    </header>

    <main>
        <h2>Некоторые из наших покемонов</h2>
        <div class="pokemon-list">
            <?php foreach ($pokemonList as $pokemon): ?>
                <div class="pokemon-card">
                    <h3><?= htmlspecialchars($pokemon['name']) ?></h3>
                    <p>Тип: <?= htmlspecialchars($pokemon['type']) ?></p>
                    <p>Уровень: <?= htmlspecialchars($pokemon['level']) ?></p>
                    <p>Поколение: <?= htmlspecialchars($pokemon['generation']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>
