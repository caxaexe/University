<?php
session_start();

// Проверка авторизации и роли администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../../app/core/Database.php';

if (isset($_GET['id'])) {
    $pokemonId = (int)$_GET['id'];

    // Удаление покемона
    $db = Database::connect();
    $stmt = $db->prepare("DELETE FROM pokemons WHERE id = :id");
    $stmt->execute(['id' => $pokemonId]);

    header("Location: manage_pokemons.php");
    exit;
}
?>
