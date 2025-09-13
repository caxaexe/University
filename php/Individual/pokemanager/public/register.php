<?php
require_once '../app/core/Database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    // Простейшая валидация
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "Пожалуйста, заполните все поля.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email.";
    } elseif ($password !== $confirm) {
        $errors[] = "Пароли не совпадают.";
    }

    // Проверка уникальности пользователя
    if (empty($errors)) {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = "Пользователь с таким именем или email уже существует.";
        }
    }

    // Регистрация
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        header("Location: login.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Регистрация</h2>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form id="register_form" method="POST" action="register.php">
    <div id="error_messages" style="color: red;"></div>
    <label for="username">Имя пользователя:</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>

    <label for="confirm_password">Подтверждение пароля:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <button type="submit">Зарегистрироваться</button>
</form>

</body>
</html>
