<?php
session_start();

// Проверка авторизации и роли администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../../app/core/Database.php';

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];

    // Проверка, чтобы не удалить администратора
    if ($userId == $_SESSION['user_id']) {
        echo "Вы не можете удалить свой аккаунт.";
        exit;
    }

    // Удаление пользователя
    $db = Database::connect();
    $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);

    header("Location: manage_users.php");
    exit;
}
?>
