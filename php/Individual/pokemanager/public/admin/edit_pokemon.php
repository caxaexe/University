<?php
session_start();

// Проверка авторизации и роли администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../../app/core/Database.php';

$errors = [];
$success = [];

if (isset($_GET['id'])) {
    $pokemonId = (int)$_GET['id'];
    
    // Получаем текущие данные покемона из базы
    $db = Database::connect();
    $stmt = $db->prepare("SELECT id, name, type, level FROM pokemons WHERE id = :id");
    $stmt->execute(['id' => $pokemonId]);
    $pokemon = $stmt->fetch();

    if (!$pokemon) {
        echo "Покемон не найден.";
        exit;
    }

    // Обработка формы редактирования
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_pokemon'])) {
        $name = trim($_POST['name']);
        $type = trim($_POST['type']);
        $level = (int)$_POST['level'];

        if (empty($name) || empty($type) || $level <= 0) {
            $errors[] = "Все поля обязательны для заполнения и уровень должен быть больше 0.";
        } else {
            // Обновление данных покемона
            $stmt = $db->prepare("UPDATE pokemons SET name = :name, type = :type, level = :level WHERE id = :id");
            $stmt->execute([
                'name' => $name,
                'type' => $type,
                'level' => $level,
                'id' => $pokemonId
            ]);
            $success[] = "Данные покемона обновлены.";
        }
    }
} else {
    echo "Ошибка: ID покемона не указан.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование покемона</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Редактирование покемона</h2>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <ul style="color: green;">
            <?php foreach ($success as $msg): ?>
                <li><?= htmlspecialchars($msg) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Имя покемона:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($pokemon['name']) ?>" required><br><br>

        <label>Тип покемона:</label><br>
        <input type="text" name="type" value="<?= htmlspecialchars($pokemon['type']) ?>" required><br><br>

        <label>Уровень покемона:</label><br>
        <input type="number" name="level" value="<?= htmlspecialchars($pokemon['level']) ?>" min="1" required><br><br>

        <button type="submit" name="edit_pokemon">Сохранить изменения</button>
    </form>
</body>
</html>
