<?php
require_once '../../app/controllers/PokemonController.php';

$controller = new PokemonController();
$controller->index(); // список покемонов

session_start();

// Проверка авторизации и роли администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../../app/core/Database.php';

$errors = [];
$success = [];

// Переменные для поиска
$searchName = $searchType = $searchLevel = $searchGeneration = '';

// Получение значений поисковых параметров из формы
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $searchName = isset($_GET['name']) ? trim($_GET['name']) : '';
    $searchType = isset($_GET['type']) ? trim($_GET['type']) : '';
    $searchLevel = isset($_GET['level']) ? (int)$_GET['level'] : '';
    $searchGeneration = isset($_GET['generation']) ? (int)$_GET['generation'] : '';
}

// Параметры сортировки
$sortColumn = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'name'; // по умолчанию сортировка по имени
$sortOrder = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'desc' : 'asc'; // по умолчанию сортировка по возрастанию

// Создание нового покемона
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_pokemon'])) {
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $level = (int)$_POST['level'];
    $generation = (int)$_POST['generation'];

    if (empty($name) || empty($type) || $level <= 0 || $generation <= 0) {
        $errors[] = "Все поля обязательны для заполнения, а уровень и поколение должны быть больше 0.";
    } else {
        // Добавление покемона в базу данных
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO pokemons (name, type, level, generation) VALUES (:name, :type, :level, :generation)");
        $stmt->execute([
            'name' => $name,
            'type' => $type,
            'level' => $level,
            'generation' => $generation
        ]);
        $success[] = "Покемон успешно добавлен.";
    }
}

// Получение покемонов по заданным критериям поиска и сортировке
$db = Database::connect();
$sql = "SELECT id, name, type, level, generation FROM pokemons WHERE 1=1";

$params = [];

if (!empty($searchName)) {
    $sql .= " AND name LIKE :name";
    $params['name'] = "%" . $searchName . "%";
}

if (!empty($searchType)) {
    $sql .= " AND type LIKE :type";
    $params['type'] = "%" . $searchType . "%";
}

if ($searchLevel > 0) {
    $sql .= " AND level = :level";
    $params['level'] = $searchLevel;
}

if ($searchGeneration > 0) {
    $sql .= " AND generation = :generation";
    $params['generation'] = $searchGeneration;
}

// Добавляем сортировку
$sql .= " ORDER BY " . $sortColumn . " " . $sortOrder;

$stmt = $db->prepare($sql);
$stmt->execute($params);
$pokemons = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление покемонами</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Управление покемонами</h2>

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

    <h3>Создание нового покемона</h3>
    <form method="POST" action="">
        <label>Имя покемона:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Тип покемона:</label><br>
        <input type="text" name="type" required><br><br>

        <label>Уровень покемона:</label><br>
        <input type="number" name="level" min="1" required><br><br>

        <label>Поколение покемона:</label><br>
        <input type="number" name="generation" min="1" required><br><br>

        <button type="submit" name="create_pokemon">Добавить покемона</button>
    </form>

    <h3>Поиск покемонов</h3>
    <form method="GET" action="">
        <label>Имя покемона:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($searchName) ?>"><br><br>

        <label>Тип покемона:</label><br>
        <input type="text" name="type" value="<?= htmlspecialchars($searchType) ?>"><br><br>

        <label>Уровень покемона:</label><br>
        <input type="number" name="level" value="<?= htmlspecialchars($searchLevel) ?>"><br><br>

        <label>Поколение покемона:</label><br>
        <input type="number" name="generation" value="<?= htmlspecialchars($searchGeneration) ?>"><br><br>

        <button type="submit">Поиск</button>
    </form>

    <h3>Список покемонов</h3>
    <table>
        <tr>
            <th><a href="?sort_column=name&sort_order=<?= $sortOrder === 'asc' ? 'desc' : 'asc' ?>">Имя</a></th>
            <th><a href="?sort_column=type&sort_order=<?= $sortOrder === 'asc' ? 'desc' : 'asc' ?>">Тип</a></th>
            <th><a href="?sort_column=level&sort_order=<?= $sortOrder === 'asc' ? 'desc' : 'asc' ?>">Уровень</a></th>
            <th><a href="?sort_column=generation&sort_order=<?= $sortOrder === 'asc' ? 'desc' : 'asc' ?>">Поколение</a></th>
            <th>Действия</th>
        </tr>
        <?php foreach ($pokemons as $pokemon): ?>
            <tr>
                <td><?= htmlspecialchars($pokemon['name']) ?></td>
                <td><?= htmlspecialchars($pokemon['type']) ?></td>
                <td><?= htmlspecialchars($pokemon['level']) ?></td>
                <td><?= htmlspecialchars($pokemon['generation']) ?></td>
                <td>
                    <a href="edit_pokemon.php?id=<?= $pokemon['id'] ?>">Редактировать</a> |
                    <a href="delete_pokemon.php?id=<?= $pokemon['id'] ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
