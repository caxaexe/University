# Используем официальный образ Python
FROM python:3.11-slim

# Устанавливаем cron и нужные библиотеки
RUN apt-get update && apt-get upgrade -y && apt-get install -y cron && rm -rf /var/lib/apt/lists/*

# Рабочая директория
WORKDIR /app

# Копируем скрипты и cron-задачи
COPY currency_exchange_rate.py /app/
COPY cronjob /etc/cron.d/cronjob
COPY entrypoint.sh /entrypoint.sh

# Настраиваем права
RUN chmod 0644 /etc/cron.d/cronjob && \
    chmod +x /entrypoint.sh

# Лог файл cron
RUN touch /var/log/cron.log

# Точка входа
ENTRYPOINT ["/entrypoint.sh"]
