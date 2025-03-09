<?php

$dir = './image';

$files = scandir($dir);

if ($files === false) {
    return;
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nachos nachos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header, footer {
            background-color: rgb(200, 161, 53);
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        nav {
            background-color: rgb(171, 131, 52);
            overflow: hidden;
        }
        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        nav a:hover {
            background-color:rgb(255, 221, 129);
        }
        .nachos {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }
        .nachos img {
            max-width: 100%;
            height: auto;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(255, 185, 72, 0.2);
            transition: transform 0.3s ease;
        }
        .nachos img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<header>
    <h1>Царство начос</h1>
</header>

<nav>
    <a href="#">Главная начоса на свете</a>
    <a href="#">Лучшие начос на свете</a>
    <a href="#">О лучших начос на свете</a>
</nav>

<div class="nachos">
    <?php
    for ($i = 0; $i < count($files); $i++) {
        if (($files[$i] != ".") && ($files[$i] != "..")) {
            $path = $dir . $files[$i];
            if (preg_match("/\.jpg$/i", $files[$i])) {
                echo "<img src='$path' alt='Изображение'>";
            }
        }
    }
    ?>
</div>

<footer>
    <p>©Начосини 2025</p>
</footer>

</body>
</html>


