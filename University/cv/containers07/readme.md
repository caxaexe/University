# Лабораторная работа №7. Создание многоконтейнерного приложения

## Цель работы
Цель данной лабораторной работы является ознакомление с работой многоконтейнерного приложения на базе docker-compose.  

## Задание
Создать php приложение на базе трех контейнеров: nginx, php-fpm, mariadb, используя docker-compose. 

## Ход работы
Для выполнения данной работы я создаю репозиторий `containers07`, внутри него создаю директорию `mounts/site` и добавляю туда свой идеальный сайт про начос на PHP.  

---
Создаю файл `.gitignore` в корне проекта и добавляю строки:
```
# Ignore files and directories
mounts/site/*
```
![Снимок экрана 2025-04-11 134824](https://github.com/user-attachments/assets/9fea4a79-4165-4219-a0ba-85dc116aa73a)  

Создаю в директории файл `nginx/default.conf` со следующим содержимым:
```
server {
    listen 80;
    server_name _;
    root /var/www/html;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    location ~ \.php$ {
        fastcgi_pass backend:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
![Снимок экрана 2025-04-11 134924](https://github.com/user-attachments/assets/3d6c8a5e-97a9-4677-a779-206219727450)  

Далее создаю файл `docker-compose.yml` со следующим содержимым:
```
version: '3.9'

services:
  frontend:
    image: nginx:1.19
    volumes:
      - ./mounts/site:/var/www/html
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf
    ports:
      - "80:80"
    networks:
      - internal
  backend:
    image: php:7.4-fpm
    volumes:
      - ./mounts/site:/var/www/html
    networks:
      - internal
    env_file:
      - mysql.env
  database:
    image: mysql:8.0
    env_file:
      - mysql.env
    networks:
      - internal
    volumes:
      - db_data:/var/lib/mysql

networks:
  internal: {}

volumes:
  db_data: {}
```
![Снимок экрана 2025-04-11 135015](https://github.com/user-attachments/assets/a896a402-4898-439e-915f-3ef622037371)  

А теперь создаю файл `mysql.env` в корне проектра и добавляю строки:
```
MYSQL_ROOT_PASSWORD=secret
MYSQL_DATABASE=app
MYSQL_USER=user
MYSQL_PASSWORD=secret
```
![Снимок экрана 2025-04-11 135047](https://github.com/user-attachments/assets/362720f6-1c3e-4fdb-a583-38c842329779)  

---
На следдующем этапе запускаю контейнер командой `docker-compose up -d`:
![Снимок экрана 2025-04-11 135252](https://github.com/user-attachments/assets/976dbc6e-8119-4e47-ab25-60bfeb735f72)  

И в итоге проверяю работу сайта в браузере, переходя по адресу `http://localhost`. И можно заметить такой результат ʕ •ᴥ• ʔ 
![Снимок экрана 2025-04-11 135326](https://github.com/user-attachments/assets/56efec3b-bf95-40cb-acba-f55409e38ff6)  

## Вывод
В ходе лабораторной работы было развернуто многоконтейнерное приложение с использованием Docker, включающее `nginx`, `php-fpm` и `mariadb`. Настроены конфигурационные файлы, подключены тома и переменные окружения. Приложение успешно запущено и проверено в браузере по адресу `http://localhost`.

## Контрольные вопросы
**1. В каком порядке запускаются контейнеры?**  
 Контейнеры запускаются в порядке, зависящем от директивы `depends_on` в `docker-compose.yml`. Если указано:
 ```yaml
services:
  backend:
    depends_on:
      - db
```
то сначала запустится контейнер `db`, затем `backend`.

**2. Где хранятся данные базы данных?**  
Данные базы обычно хранятся:
- Либо внутри контейнера (если volume не указан) — но тогда они исчезают при удалении контейнера.
- Либо во внешнем томе (volume), если указано в docker-compose.yml:
  ```yaml
  services:
    db:
      volumes:
        - db_data:/var/lib/postgresql/data

  volumes:
    db_data:
  ```

**3. Как называются контейнеры проекта?**  
Имена контейнеров формируются по шаблону: `<имя_проекта>_<имя_сервиса>_<номер>`.  
Имя проекта определяется:
- По имени папки, в которой находится docker-compose.yml
- Или можно задать вручную с помощью -p: `docker-compose -p myproject up`

**4. Вам необходимо добавить еще один файл app.env с переменной окружения APP_VERSION для сервисов backend и frontend. Как это сделать?** 
1. Нужно создать файл `app.env` в корне проекта со строкой:
   ```ini
    APP_VERSION=1.0.0
   ```
2. Изменить `docker-compose.yml`, добавив `env_file` в нужные сервисы:
   ```yaml
      services:
    backend:
      env_file:
        - app.env
  
    frontend:
      env_file:
        - app.env
   ```  
3. Теперь переменная `APP_VERSION` будет доступна внутри контейнеров `backend` и `frontend`.
