<?php

require_once '../src/helpers.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = sanitizeInput($_POST['title'] ?? '');
    $category = sanitizeInput($_POST['category'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $tags = isset($_POST['tags']) ? array_map('sanitizeInput', $_POST['tags']) : [];
    $steps = isset($_POST['steps'] )? array_map('sanitizeInput', $_POST['steps']) : [];

    $formData = [
        'title' => $title,
        'category' => $category,
        'description' => $description,
        'tags' => $tags,
        'steps' => $steps,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $errors = validateRecipe($formData);
    if(!empty($errors)){
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $formData;
        header('Location: ../src/handle_form.php');
        exit;
    }

    $jsonLine = json_encode($formData, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    file_put_contents('../storage/spells.txt');
    
    header('Location: ../index.php');
    exit;
}