<?php
//чтение данных из файла игноируя новые строки
$spells = file('../storage/spells.txt', FILE_IGNORE_NEW_LINES);

// преобразование строки json в массив объектов или ассоц массивов если true
$spells = array_map('json_decode', $spells);

// получение два послдених заклинания
$latestSpells = array_slice($spells, -2);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список последних заклинаний</title>
    <style>
        .spell-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .spell-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Последние заклинания</h1>


    <?php if(empty($latestSpells)): ?>
        <p>Пока нет добавленных заклинаний.</p>
    <?php else: ?>
        <?php foreach ($latestSpells as $spells): ?>
            <?php if($spells): ?>
                <div class="spell-item">
                    <h2 class="spell-name><?php ecgo</h2>

                </div>
