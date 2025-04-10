<?php 

function sanitizeInput($data){
    return htmlspecialchars(trim($data));
}

function validateRecipe($data){
    $errors = [];

    if(empty($data['title'])){
        $errors['title'] = 'Нужно добавить название.';
    }

    if(empty($data['category'])){
        $errors['category'] = 'Нужно выбрать категорию.';
    }

    if(empty($data['description'])){
        $errors['description'] = 'Нужно добавить описание.';
    }

    if(empty($data['steps']) or !is_array($data['steps']) or count(array_filter($data['steps']) === 0)){
        $errors['steps'] = 'Нужно указать хотя бы один шаг выполнения заклинания.';
    }

    return $errors;
}