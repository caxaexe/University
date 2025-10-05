#!/bin/sh

create_log_file() {
    echo "Creating log file..."
    touch /var/log/cron.log
    # Установка прав для записи
    chmod 666 /var/log/cron.log
    echo "Log file created at /var/log/cron.log"
}

monitor_logs() {
    echo "=== Monitoring cron logs ==="
    # Отслеживание логов в фоновом режиме
    tail -f /var/log/cron.log
}

run_cron() {
    echo "=== Starting cron daemon ==="
    # Запуск cron в фоновом режиме (режим переднего плана)
    exec cron -f
}

# 1. Экспорт всех переменных окружения для cron
env > /etc/environment

# 2. Создание файла логов
create_log_file

# 3. Отслеживание логов в фоновом режиме (позволяет видеть вывод в консоли)
monitor_logs &

# 4. Запуск cron (запускается как основная команда контейнера)
run_cron