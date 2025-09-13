<?php
require_once '../app/core/Database.php';
require_once '../app/core/auth.php';

class AuthController {
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $db = Database::connect();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                login_user($user);
                header("Location: admin.php");
                exit;
            } else {
                $error = 'Неверный логин или пароль';
            }
        }

        include '../app/views/login.php';
    }

    public function logout() {
        logout_user();
        header("Location: index.php");
        exit;
    }

    public function register() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $role = 'user'; // по умолчанию

            if (strlen($username) < 3 || strlen($password) < 4) {
                $error = 'Слишком короткое имя или пароль';
            } else {
                $db = Database::connect();
                $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);

                if ($stmt->fetch()) {
                    $error = 'Пользователь с таким именем уже существует';
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $insert = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                    $insert->execute([$username, $hashed, $role]);

                    header("Location: login.php");
                    exit;
                }
            }
        }

        include '../app/views/register.php';
    }
}
