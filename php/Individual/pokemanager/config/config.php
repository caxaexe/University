<?php

// Настройки базы данных
define('DB_HOST', 'localhost');  // Адрес сервера базы данных
define('DB_USER', 'root');       // Имя пользователя базы данных
define('DB_PASS', '');           // Пароль пользователя базы данных
define('DB_NAME', 'pokemanager'); // Название базы данных

// Путь к директориям для загрузки изображений
define('UPLOAD_DIR', __DIR__ . '/../uploads/');

// URL для правильной работы сессий
define('BASE_URL', 'http://localhost/PokeManager');

// Секретный ключ для хэширования токенов (например, для восстановления пароля)
define('SECRET_KEY', 'your_secret_key');

// Включение отладчика (для разработки)
define('DEBUG', true);  // false в продакшене

// Конфигурация почты для восстановления пароля (если необходимо)
define('MAIL_HOST', 'smtp.example.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'your_email@example.com');
define('MAIL_PASSWORD', 'your_email_password');

?>
