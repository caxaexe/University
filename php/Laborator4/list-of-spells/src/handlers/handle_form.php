<?php

require_once __DIR__ . '/../../src/helpers.php';

function handlerForm($data) {
    $title = $data['title'] ?? '';
    $category = $data['category'] ?? '';
    $description = $data['description'] ?? '';
    $tags = $data['tags'] ?? '';
    $steps = $data['steps'] ?? '';

    $errors = validateSpell($title, $category, $description, $tags, $steps);

    if(empty($errors)) {
        saveSpell($title, $category, $description, $tags, $steps);
        return ['success' => true];
    }

    return['errors' => $errors];
}

 