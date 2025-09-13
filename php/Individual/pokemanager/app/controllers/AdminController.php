<?php
require_once '../app/core/auth.php';

class AdminController {
    public function dashboard() {
        require_admin();
        include '../app/views/admin_dashboard.php';
    }

    public function users() {
        require_admin();
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM users");
        $users = $stmt->fetchAll();

        include '../app/views/manage_users.php';
    }

    public function deleteUser($id) {
        require_admin();
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: manage_users.php");
    }
}
