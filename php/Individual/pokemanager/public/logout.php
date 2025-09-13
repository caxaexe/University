<?php
require_once '../app/core/auth.php';
require_once '../app/controllers/AuthController.php';

$controller = new AuthController();
$controller->logout();

logout_user();
header("Location: index.php");
exit;
