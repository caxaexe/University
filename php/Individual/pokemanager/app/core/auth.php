<?php
session_start();

// Проверка, вошёл ли пользователь
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Проверка, является ли пользователь администратором
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Перенаправление на login, если не вошёл в систему
function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

// Перенаправление на главную, если не админ
function require_admin() {
    if (!is_admin()) {
        header("Location: index.php");
        exit;
    }
}

// Авторизация пользователя после логина
function login_user($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
}

// Выход из аккаунта
function logout_user() {
    session_unset();
    session_destroy();
}
