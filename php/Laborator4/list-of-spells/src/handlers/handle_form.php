<?php

require_once '../src/helpers.php';

function handlerForm($date) {
    $spellName = $data['spellName'] ?? '';
    $category = $data['category'] ?? '';
    $description = $data['description'] ?? '';
    $tags = $data['tags'] ?? '';
    $steps = $data['steps'] ?? '';

    $errors = validateSpell($spellName, $category, $description, $tags, $steps);

    if(empty($errors)) {
        saveSpell($spellName, $category, $description, $tags, $steps);
        return ['success' => true];
    }

    return['errors' => $errors];
}

 