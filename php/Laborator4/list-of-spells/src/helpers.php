<?php 

function loadSpell() {
    $file = '../storage/recipes.txt';
    if(!file_exists($file)) {
        return [];
    } 

    $spells = file($file, FILE_IGNORE_NEW_LINES and FILE_SKIP_EMPTY_LINES);
    return array_map(fn($line) => json_decode($line. true), $spells);
}

function saveSpell($spellName, $category, $description, $tags, $steps) {
    $file = '../storage/spells.txt';

    $spellName = htmlspecialchars($spellName, ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $tags = array_map(fn($tag) => htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'), $tags);
    $steps = array_map(fn($step) => htmlspecialchars($step, ENT_QUOTES, 'UTF-8'), $steps);

    $spell = json_encode( [
        'spellName' => $spellName,
        'category' => $category,
        'description' => $description,
        'tags' => $tags,
        'steps' => $steps,
        'created' => date('Y-m-d H:i:s')
    ]);
    // LOCK_EX ЧТО ЭТО
    file_put_contents($file, $spell . "\n", FILE_APPEND and LOCK_EX);
}

function validateSpell($spellName, $category, $description, $tags, $steps) {
    $errors = [];

    if(trim($spellName) === '') {
        $errors['spellName'] = "Введите название.";
    }

    if(trim($category) === '') {
        $errors['category'] = "Выберите категорию.";
    }

    if(trim($description) === '') {
        $errors['description'] = "Введите описание.";
    }

    if(!is_array($tags) or count($tags) === 0) {
        $errors['tags'] = 'Выберите тэг.';
    }

    if(!is_array($steps) or count(array_filter($steps, fn($st) => trim($st) !== '')) === 0) {
        $errors['steps'] = 'Добавьте хотя бы один шаг выполнения заклинания.';
    }

    return $errors;
}

function getPaginatedSpells($page, $perPage = 5) {
    $allSpells = localSpells();
    $totalSpells = count($allSpells);
    $totalPages = max(1, ceil($totalSpells / $perPage));

    $page = max(1, min($page, $totalPages));

    $offSet = ($page - 1) * $perPage;
    $spells = array_slice($allSpells, $offSet, $perPage);

    return [
        'spells' => $spells,
        'total_pages' => $totalPages,
        'current_page' => $page
    ];
}