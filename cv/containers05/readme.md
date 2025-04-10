# Лабораторная работа №5. Запуск сайта в контейнере

## Цель работы
Целью данной лабораторной работы является подготовка образа контейнера для запуска веб-сайта на базе Apache HTTP Server + PHP (mod_php) + MariaDB.

## Задание
Создать Dockerfile для сборки образа контейнера, который будет содержать веб-сайт на базе Apache HTTP Server + PHP (mod_php) + MariaDB. База данных MariaDB должна храниться в монтируемом томе. Сервер должен быть доступен по порту 8000.

Установить сайт WordPress. Проверить работоспособность сайта.

## Ход работы
Убедившись, что у меня на компьютере установлен `Docker Desktop`, я начинаю лабораторную работу (⊙_⊙)  

Для начала я создаю репозиторий `containers05`, содержимое которого также создаю еще необходимые папки:
- files/apache2 - для файлов конфигурации apache2
- files/php - для файлов конфигурации php
- files/mariadb - для файлов конфигурации mariadb

Затем в главном репозитории я создаю файл `Dockerfile` со следующим содержимым:
![Снимок экрана 2025-03-23 133911](https://github.com/user-attachments/assets/60d51b1a-1860-4307-b1a8-e65bcf19a6d4)  

Строю образ контейнера с именем `apache2-php-mariadb`, используя команду `docker build -t apache2-php-mariadb .`.
![Снимок экрана 2025-03-23 133901](https://github.com/user-attachments/assets/d688753a-0c9b-4a7f-9e82-485452bb35cb)  
И создаю контейнер `apache2-php-mariadb` из образа `apache2-php-mariadb`, запускаю его в фоновом режиме `docker run -d --name apache2-php-mariadb apache2-php-mariadb bash`.  
![Снимок экрана 2025-03-23 133948](https://github.com/user-attachments/assets/699e7112-a6e0-4509-84d7-9918884566da)  

Далее копирую из контейнера файлы конфигурации apache2, php, mariadb в папку files/ на компьютере, выполнив следующие команды:
```
docker cp apache2-php-mariadb:/etc/apache2/sites-available/000-default.conf files/apache2/
docker cp apache2-php-mariadb:/etc/apache2/apache2.conf files/apache2/
docker cp apache2-php-mariadb:/etc/php/8.2/apache2/php.ini files/php/
docker cp apache2-php-mariadb:/etc/mysql/mariadb.conf.d/50-server.cnf files/mariadb/
```
![Снимок экрана 2025-03-23 135218](https://github.com/user-attachments/assets/c3cb2933-aad5-4b66-b504-02f4b3eeb532)  

После выполнения предыдущих команд внутри имеющихся папок появились файлы конфигурации apache2, php, mariadb.
![Снимок экрана 2025-03-23 135318](https://github.com/user-attachments/assets/33c0dec7-7830-4b20-b2b7-b81672dc24d4)  

После этого я останавливаю и удаляю данный контейнер *(а все так хорошо начиналось)*
![Снимок экрана 2025-03-23 135259](https://github.com/user-attachments/assets/d0b060de-c76b-4baf-956f-903880e04376)  

---

На следующем этапе, следуя инструкции, я ввожу измненения в конфигурационные файлы:
- В файле files/apache2/000-default.conf, строку `#ServerName www.example.com` заменяю на `ServerName localhost`.
- В строке `ServerAdmin webmaster@localhost` заменяю почтовый адрес на свой.
- После строки `DocumentRoot /var/www/html` добавляю `DirectoryIndex index.php index.html`.
  ![image](https://github.com/user-attachments/assets/f6030107-0f04-4f80-890a-3b97cba666b3)

- В конце файла files/apache2/apache2.conf добавляю строку `ServerName localhost`.
  ![Снимок экрана 2025-03-23 135507](https://github.com/user-attachments/assets/affd2f0a-5fe5-4f5a-afda-e81b892cc7ab)

- В файле files/php/php.ini строку `;error_log = php_errors.log` заменяю на `error_log = /var/log/php_errors.log`.
  ![Снимок экрана 2025-03-23 135554](https://github.com/user-attachments/assets/7d3e5826-84e2-4eb5-ad4a-4e81b0452661)  
- Настраиваю параметры memory_limit, upload_max_filesize, post_max_size и max_execution_time следующим образом:
```
memory_limit = 128M
upload_max_filesize = 128M
post_max_size = 128M
max_execution_time = 120
```

- В файле files/mariadb/50-server.cnf нахожу строку `#log_error = /var/log/mysql/error.log` и убираю знак комментария.
  ![Снимок экрана 2025-03-23 141459](https://github.com/user-attachments/assets/2250cfaa-d526-415d-a90b-ee095d47a017)

---

Далее, находясь в files/ я создаю новую папку supervisor, внутри которой будет находиться файл `supervisord.conf` со следующим содержимым:  
![Снимок экрана 2025-03-23 222710](https://github.com/user-attachments/assets/5745947f-1f59-4146-b112-d4131097f09b)  

---

Следующим шагом является создание `Dockerfile`. Я снова открываю необходимый файл и обновляю его:
- после инструкции FROM ... добавляю монтирование томов
- в инструкции RUN ... добавляю установку пакета supervisor
- после инструкции RUN ... добавляю копирование и распаковку сайта WordPress
- после копирования файлов WordPress добавляю копирование конфигурационных файлов apache2, php, mariadb, а также скрипта запуска
- для функционирования mariadb создайте папку /var/run/mysqld и установите права на неё
- открываю порт 80
- добавляю команду запуска supervisord
![Снимок экрана 2025-03-25 171402](https://github.com/user-attachments/assets/1ecd55f6-a4b3-4fe4-b5e0-0cc2e3d04206)


Далее снова создаю образ контейнера с именем `apache2-php-mariadb` и запускаю контейнер `apache2-php-mariadb` из образа `apache2-php-mariadb`.
![Снимок экрана 2025-03-25 171241](https://github.com/user-attachments/assets/d0038d4f-46cb-45ee-89a3-c4e735a9940a)
![Снимок экрана 2025-03-23 145901](https://github.com/user-attachments/assets/b138bc32-2bab-4686-b0a2-883fd8c1e190)  

Проверяю наличие сайта `WordPress` в папке /var/www/html/, при помощи команды `docker exec -it apache2-php-mariadb ls /var/www/html/`. Можно заметить, что присутствуют файлы `index.php` и другие файлы, относящиеся к WordPress.
![Снимок экрана 2025-03-25 171318](https://github.com/user-attachments/assets/71e0e017-141f-44de-93ec-f93f763aeb60)

Также проверяю изменения конфигурационного файла apache2 командой `docker exec -it apache2-php-mariadb cat /etc/apache2/sites-available/000-default.conf`.
![Снимок экрана 2025-03-25 171523](https://github.com/user-attachments/assets/86de6780-db44-49ae-b3a1-12ad59a807f4)  

---

Создаю базу данных `wordpress` и пользователя `wordpress` с паролем `wordpress` в контейнере `apache2-php-mariadb`. Для этого, в контейнере `apache2-php-mariadb`, я выполняю следующую команду `docker exec -it apache2-php-mariadb mysql -u root` для запуска mysql, после чего ввожу:
```mysql
CREATE DATABASE wordpress;
CREATE USER 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
![Снимок экрана 2025-03-25 171609](https://github.com/user-attachments/assets/6b0556ec-426a-4704-83c2-ef3b965e44b3)  

---

Следующим шагом я перехожу по адресу `http://localhost/` и открываю сайт `Wordpress` в браузере.
![Снимок экрана 2025-03-25 172154](https://github.com/user-attachments/assets/cbb0c48f-caca-4af3-a1fa-518cf9679b9f)  
Далее указываю там параметры подключения к базе данных:
![Снимок экрана 2025-03-25 172449](https://github.com/user-attachments/assets/3cc2f776-f912-4a81-af0d-1295f8c34139)  
Открывается окно с содержимым файла wp-config.php, которое я скопирую себе в соответствующую директорию:
![Снимок экрана 2025-03-25 172521](https://github.com/user-attachments/assets/87410edb-c94b-4183-935a-b5b89b00efb8)  

---

Здесь я обновляю файл `Dockerfile`, добавляя в него файл конфигурации `Wordpress`.
![image](https://github.com/user-attachments/assets/fba61422-15c2-46fb-a673-30a5b04452ba)  

---

Далее я пересобираю образ контейнера с именем `apache2-php-mariadb` и запускаю заново контейнер `apache2-php-mariadb` из образа `apache2-php-mariadb`.
![image](https://github.com/user-attachments/assets/57b1d130-cdf5-4f1b-9dc9-0f2dffa1169b)
![image](https://github.com/user-attachments/assets/7eca40b5-d777-4a12-8485-bccee973eac6)  
 
И в финале работы я проверяю работоспособность сайта `WordPress` (ᵔ◡ᵔ) 
![image](https://github.com/user-attachments/assets/bfe8c676-04c8-4eb7-9d1b-c699284df823)  
Все не работает прекрасно и великолепно, чему можно только порадоваться. Посовещавшись с коллегами, было принято решение кое что поменять при создании базы данных в mysql. Заменяю "localhost" на знак процента %, чтобы разрешить подключение с любого IP-адреса. Сейчас все покажу:
```mysql
CREATE DATABASE wordpress;
CREATE USER 'wordpress'@'%' IDENTIFIED BY 'wordpress';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'%';
FLUSH PRIVILEGES;
EXIT;
```
![image](https://github.com/user-attachments/assets/f9f063cd-db0d-48a2-b04d-e879e85d3ab1)  

При очередном запуске `http://localhost/` появляется приветственное окно с полями для ввода своих данных. Ввожу все красивенько *(только без взлома)*:  
![image](https://github.com/user-attachments/assets/8d920a30-9b84-445d-84f7-e2fa5b8f14f0)  
![image](https://github.com/user-attachments/assets/4bd0fd2e-eefe-4040-94f0-85cac75217b8)
![image](https://github.com/user-attachments/assets/1f96ce2a-9a92-4df0-a973-814a2c47cd46)  
![image](https://github.com/user-attachments/assets/c66802de-4c3f-4d52-ab3a-29b20c5cfeb6)


## Вывод
Лабораторная работа позволила изучить основы развёртывания серверных сред в Docker, работы с конфигурационными файлами Apache, PHP и MariaDB, а также управления процессами с помощью Supervisor.  

## Контрольные вопросы
**1. Какие файлы конфигурации были изменены?**  
В ходе выполнения лабораторной работы были изменены следующие файлы конфигурации:
-files/apache2/000-default.conf – изменены параметры ServerName, ServerAdmin, добавлена директива DirectoryIndex.
-files/apache2/apache2.conf – добавлена строка ServerName localhost.
-files/php/php.ini – изменены параметры error_log, memory_limit, upload_max_filesize, post_max_size, max_execution_time.
-files/mariadb/50-server.cnf – раскомментирована строка log_error = /var/log/mysql/error.log.
-files/supervisor/supervisord.conf – добавлена конфигурация для запуска Apache и MariaDB.
-files/wp-config.php – добавлена конфигурация для подключения WordPress к базе данных.  

**2. За что отвечает инструкция DirectoryIndex в файле конфигурации apache2?**  
Директива DirectoryIndex определяет, какой файл будет загружаться первым при обращении к каталогу. В данном случае, добавление index.php index.html означает, что при открытии корневого каталога сайта веб-сервер сначала попытается отобразить index.php, а если его нет, то index.html.  

**3. Зачем нужен файл wp-config.php?**  
Файл wp-config.php содержит основные настройки WordPress, включая параметры подключения к базе данных (DB_NAME, DB_USER, DB_PASSWORD, DB_HOST), ключи безопасности, префикс таблиц и другие настройки.  

**4. За что отвечает параметр post_max_size в файле конфигурации php?**  
Параметр post_max_size определяет максимальный размер данных, которые могут быть переданы серверу методом POST. Это особенно важно для загрузки файлов через формы на веб-сайте.  

**5. Укажите, на ваш взгляд, какие недостатки есть в созданном образе контейнера?**  
- WordPress загружается во время сборки - если версия изменится, образ устареет
- Неоптимизированный размер образа - используется debian:latest, который довольно тяжелый
- Логи хранятся внутри контейнера - при удалении контейнера логи будут потеряны, лучше настраивать их на хранение вне контейнера







