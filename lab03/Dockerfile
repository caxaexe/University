# Используем официальный образ Python
FROM python:3.9-slim

# Установка cron и других необходимых утилит
# 'vim-tiny' и 'curl' не обязательны, но могут быть полезны для отладки
RUN apt-get update && \
    apt-get install -y cron vim-tiny curl && \
    rm -rf /var/lib/apt/lists/*

# Создание рабочего каталога
WORKDIR /app

# Копирование файлов скрипта, cronjob и точки входа
COPY currency_exchange_rate.py .
COPY cronjob .
COPY entrypoint.sh .

# Установка необходимых Python-зависимостей (зависит от вашего скрипта)
# Предполагая, что используется 'requests' или 'openpyxl'
RUN pip install requests

# Настройка cron: Добавление cron-задач из файла 'cronjob' в систему cron.
# Используем 'sed' для удаления символов Windows-CR ('\r') для совместимости с crontab в Linux.
RUN sed 's/\r//g' cronjob | crontab -

# Точка входа в контейнер
ENTRYPOINT ["/app/entrypoint.sh"]

# Команда по умолчанию (будет заменена ENTRYPOINT)
CMD ["cron", "-f"]