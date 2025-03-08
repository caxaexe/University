# Лабораторная работа №1. Виртуальный сервер
 
## Студентка
- **Фамилия и имя:** Павлышина Александра
- **Группа:** I2302
- **Дата:** 14.02.2025

## Описание работы
Целью данной лабораторной работы является ознакомление с виртуализацией операционных систем и настройкой виртуального HTTP сервера.  
Работа состоит из следующих этапов:
- Установка ОС `Debian` для системы x64 и без графического интерфейса на виртуальную машину и систему виртуализации `QEMU`.
- Создание образа диска для виртуальной машины размером 8 ГБ, формата qcow2, используя утилиту qemu-img.
- Установка набора серверного программного обеспечения `LAMP`, включающего в себя:
  - `apache2` – веб-сервер.
  - `php` – язык серверного программирования.
  - `libapache2-mod-php` – модуль для обработки PHP в Apache.
  - `php-mysql` – поддержка MySQL/MariaDB в PHP.
  - `mariadb-server` – сервер базы данных.
  - `mariadb-client` – клиент для управления БД.
  - `unzip` – распаковка .zip-архивов.
- Установка допольнительных веб-приложений `PhpMyAdmin` для управления базами данных MySQL/MariaDB и `Drupal` для создания и администрирования веб-сайтов.
- Создание базы данных для `CMS Drupal`.
- Тестирование установки и конфигурации сервисов.

## Ход работы
1. На первом этапе я скачиваю дистрибутив `Debian` с официального сайта для серверов с архитектурой x64, без графического интерфейса.
![image](https://github.com/user-attachments/assets/2ccbea4a-657a-40d7-b7a6-b2ee9f1a59ef)  
Далее в командной строке, используя команду `pacman -S mingw-w64-x86_64-qemu`, устанавливаю систему виртуализации `QEMU`.
![Снимок экрана 2025-02-08 101057](https://github.com/user-attachments/assets/4f408437-5495-491f-ac0e-5452a8f07525)  
Скачанный образ переименовываю в `debian.iso`. Создаю директорию `lab01`, внутри которой находятся папка `dvd`(с образом debian) и отчет `readme.md`.
```
mkdir lab01
cd lab01
mkdir dvd
nano readme.md
touch readme.md
```
В папке `lab01` создаю образ диска для виртуальной машины, используя утилиту qemu-img.  
![Снимок экрана 2025-02-08 101229](https://github.com/user-attachments/assets/f65b9da9-17ac-4171-a5a6-755de0a65e3a)  

2. На втором этапе следует установка операционной системы Debian на виртуальную машину командой `qemu-system-x86_64 -hda debian.qcow2 -cdrom dvd/debian.iso -boot d -m 2G`.
![Снимок экрана 2025-02-14 110550](https://github.com/user-attachments/assets/4d8d1f05-fce1-4fdb-bf26-24a9a0596ccc)  
Далее происходила многовековая установка, в процессе которой я использовала следующие данные:
- Имя компьютера: debian
- Хостовое имя: debian.localhost
- Имя пользователя: usercaxa
- Пароль пользователя: password

Скриншоты `Debian` на виртуальной машине на разных этапах установки:  
![Снимок экрана 2025-02-08 101738](https://github.com/user-attachments/assets/9235d691-d158-42e0-a851-5bd9fc4abfab)
![Снимок экрана 2025-02-08 102136](https://github.com/user-attachments/assets/6d4a7964-dbad-463f-add1-92b1d3375df3)
![Снимок экрана 2025-02-08 120558](https://github.com/user-attachments/assets/92a98ec9-fe07-4778-879b-f92b56f35457)

По окончании установки, я перезагружаю виртуальную машину и для повторного запуска использую команду:
![Снимок экрана 2025-02-14 115909](https://github.com/user-attachments/assets/cbeac9a0-9416-4551-aee6-1581e036530d)  
Открывается окно, в котором запрашивают логин пользователя и пароль.
![Снимок экрана 2025-02-14 120039](https://github.com/user-attachments/assets/6c421573-de78-4384-b8b5-e59377675d1c)


3. На третьем этапе идет загрузка программного обеспечения `LAMP`. Переключаясь на суперпользователя при помощи команды `su`, обновляю информацию о доступных пакетах в системе `apt update -y` и устанавливаю полный набор модулей `apt install -y apache2 php libapache2-mod-php php-mysql mariadb-server mariadb-client unzip`.
![Снимок экрана 2025-02-14 121510](https://github.com/user-attachments/assets/92ed4f5a-eb71-4f2a-b9e1-d3eb64f0df79)
![Снимок экрана 2025-02-14 1220401](https://github.com/user-attachments/assets/9f70c811-dc51-423e-a7be-03fb6924e81e)

4. Четвертый этап включает в себя скачивание и установка `PhpMyAdmin` и `Duplan`, в командной строке виртуальной машины я прописываю команды:
```
wget https://files.phpmyadmin.net/phpMyAdmin/5.2.2/phpMyAdmin-5.2.2-all-languages.zip
wget https://ftp.drupal.org/files/projects/drupal-10.0.5.zip
```
![Снимок экрана 2025-02-14 122447](https://github.com/user-attachments/assets/1790dad6-4c85-4a4a-aabe-571d1096194a)
![Снимок экрана 2025-02-14 122559](https://github.com/user-attachments/assets/31970265-1913-48b3-9827-c1f0d22faf95)  
Проверяю наличие файлов командой `ls -l`.
![image](https://github.com/user-attachments/assets/e62811a1-07ed-4836-b397-cb3a46d629ea)
Распаковываю их в папки */var/www/phpmyadmin* для `PhpMyadmin` и в */var/www/drupal* соответственно для `Drupal`. 
```
unzip phpMyAdmin-5.2.2-all-languages.zip
mv phpMyAdmin-5.2.2-all-languages /var/www/phpmyadmin
```
```
unzip drupal-10.0.5.zip
mv drupal-10.0.5 /var/www/drupal
```
![image](https://github.com/user-attachments/assets/c5d1f116-a2cc-4485-b969-0cbfada154c9)

5. На пятом этапе происходит создание базы данных `drupal_bd`. Через командную строку ввожу `mysql -u root`, что запускает MySQL/MariaDB клиент от имени пользователя root. Затем в интерактивной консоли MariaDB я выполняю следующие запросы:
```mysql
CREATE DATABASE drupal_db;
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON drupal_db.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
![Снимок экрана 2025-02-14 123332](https://github.com/user-attachments/assets/9e415374-78bb-420b-8ff7-117e5c014b6f)  
В папке /etc/apache2/sites-available создаю файл 01-phpmyadmin.conf с содержимым:
```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot "/var/www/phpmyadmin"
    ServerName phpmyadmin.localhost
    ServerAlias www.phpmyadmin.localhost
    ErrorLog "/var/log/apache2/phpmyadmin.localhost-error.log"
    CustomLog "/var/log/apache2/phpmyadmin.localhost-access.log" common
</VirtualHost>
```
![Снимок экрана 2025-02-14 123456](https://github.com/user-attachments/assets/751a7e36-8bde-4455-81ba-a04d77d6d132)
![Снимок экрана 2025-02-14 124019](https://github.com/user-attachments/assets/90cca5c2-df42-49e4-85ff-897bfa1a3ec7)

В папке /etc/apache2/sites-available создаю файл 02-drupal.conf с содержимым:
```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot "/var/www/drupal"
    ServerName drupal.localhost
    ServerAlias www.drupal.localhost
    ErrorLog "/var/log/apache2/drupal.localhost-error.log"
    CustomLog "/var/log/apache2/drupal.localhost-access.log" common
</VirtualHost>
```
![Снимок экрана 2025-02-14 124252](https://github.com/user-attachments/assets/b2e1e86c-8526-4207-aff6-d7390a117f1a)
![Снимок экрана 2025-02-14 124608](https://github.com/user-attachments/assets/c06e0628-ae53-4da2-9616-9e00b8270a37)

Далее я регистрирую конфигурации, выполнив команды:
```
/usr/sbin/a2ensite 01-phpmyadmin
/usr/sbin/a2ensite 02-drupal
```
![Снимок экрана 2025-02-14 130508](https://github.com/user-attachments/assets/ee7f1acb-35fc-4c79-9b1a-079120a6e9a8)  
В конце я перезапускаю Apache HTTP Server.
![Снимок экрана 2025-02-14 135251](https://github.com/user-attachments/assets/8cbe5fa7-e850-444f-8bf3-e4a7cfffb7ca)

6. На финальном этапе я проверяю установки и конфигурации сервисов. Ипользую команду `uname -a`, благодаря которой выводится подробная информация о системе, такие как: имя ядра, имя хоста, версия ядра, дата сборки ядра, архитектура процессора и операционная система.
![Снимок экрана 2025-02-14 155336](https://github.com/user-attachments/assets/6db3b98a-91a2-4e25-bb3a-61b0695655b8)
Перезагружаю Apache Web Server командой `systemctl restart apache2`.
![Снимок экрана 2025-02-15 122351](https://github.com/user-attachments/assets/e2b26797-02f7-442e-ab16-b19b86778acd)  
Далее проверяю в браузере доступность сайтов *http://drupal.localhost:1080* и *http://phpmyadmin.localhost:1080* и завершаю установку сайтов.  
В PhpMyAdmin появляется окно с авторизацией пользователя, где я ввожу логин и пароль.
![Снимок экрана 2025-02-14 144246](https://github.com/user-attachments/assets/6b2d15e4-829d-47c0-87fc-01745ad60a50)
![image](https://github.com/user-attachments/assets/4383d970-b24d-4b17-9daf-6dfefda796a8)  
В Drupal появляется окно, в котором установка состоит из нескольких шагов, нужно выбрать язык, профиль, проверить требования, сконфигурировать базу данных, установить и настроить сайт.
![Снимок экрана 2025-02-14 144057](https://github.com/user-attachments/assets/1a8c93a3-7cfc-4419-a03d-f90f02be920d)
![Снимок экрана 2025-02-14 145359](https://github.com/user-attachments/assets/5b415702-aade-4834-a41b-adaefe5c4ad2)  
![Снимок экрана 2025-02-14 145444](https://github.com/user-attachments/assets/3ded875e-c274-4759-af14-f5a0ecd6590f)  

## Заключение
В ходе данной лабораторной работы был развернут виртуальный сервер на Debian с использованием QEMU. Установлен и настроен LAMP для работы веб-приложений, PhpMyAdmin для управления базами данных MySQL и Drupal для создания и управления сайтом. Настроены виртуальные хосты и доступ к сервисам. Освоены команды по управлению виртуальной машиной, установке и настройке серверных компонентов.

## Ключевые вопросы
**1. Каким образом можно скачать файл в консоли при помощи утилиты wget?**  
Чтобы скачать файл в командной строке, используя утилиту wget, нужно использовать команду:
```
wget <URL>
```
, где `<URL>` - это адрес сайта к определенному файлу. Например:
```
wget https://files.phpmyadmin.net/phpMyAdmin/5.2.2/phpMyAdmin-5.2.2-all-languages.zip
```
**2. Зачем необходимо создавать для каждого сайта свою базу и своего пользователя?**
Создавать для каждого сайта свою базу и своего пользователя необходимо по нескольким причинам, такие как: безопасность - если злоумышленник получит доступ к одной базе, он не сможет навредить другим; изоляция данных - разные сайты могут иметь разные схемы данных и настройки; гибкость управления - можно задавать индивидуальные права и лимиты для пользователей баз данных; облегчение резервного копирования - проще делать бэкапы и восстанавливать данные.

**3. Как поменять доступ к системе управления БД на порт 1234?**
Для того, чтобы поменять доступ к системе управления базы данных на порт 1234 на MySQL и MariaDB, нужно открыть файл конфигурации (/etc/mysql/my.cnf или /etc/mysql/mariadb.conf.d/50-server.cnf) и изменить параметр port в `mysql`: 
```mysql
port = 1234
```
Затем нужно перезапустить сервер:
```
systemctl restart mysql
```  
**4. Какие преимущества, с вашей точки зрения, даёт виртуализация?**
Виртуализация дает, по-моему мнению, следующие преимущества: несколько виртуальных машин могут работать на одном физическом сервере, можно легко менять конфигурации ВМ и тестировать ПО в разных средах, также отказ или взлом одной ВМ не влияет на другие, можно быстро создать копию и откатить изменения, можно запускать разные ОС на одном сервере.  
**5. Для чего необходимо устанавливать время / временную зону на сервере?**
Устанавливать время и временную зону на сервере необходимо для того, чтобы корректно отображалось время в логах для анализа событий, некоторые сервисы, например, базы данных, могут некорректно работать при расхождении времени и для синхронизации с другими системами.
**6. Сколько места занимает установленная вами ОС (виртуальный диск) на хостовой машине?**
В лабораторной работе виртуальному диску было выделено 8гб, файл qcow2 сразу занимает лишь несколько мегабайт, по мере использования размер увеличивается, но не превышает эти 8гб. Также благодаря использованию файла с форматом qcow2 используемое место на диске значительно меньше, так как формат поддерживает динамическое выделение пространства.
**7. Какие есть рекомендации по разбиению диска для серверов? Почему рекомендуется так разбивать диск?**
Разбивать диск рекомендуется для управления ресурсами, повышения отказоустойчивости и безопасности. Существуют следующие рекомендации для разбивания диска:
- /boot	: выделяется 500M–1G памяти,	это загрузочные файлы (ядро, GRUB).
- /	: выделяется 10–20G памяти, это основная система.
- /var	: выделяется 10–50G памяти, это логи, базы данных.
- /tmp	: выделяется 2–10G памяти,	это временные файлы.
- swap	: выделяется 1–2×RAM (≤32G)	памяти, это подкачка при нехватке памяти.
- /home	: выделяется опционально памяти, это данные пользователей.
- /mnt/data	: выделяется остаток	памяти, этоа ахивы, файлы.

## Библиография
1. Debian - https://www.debian.org/distrib/
2. QEMU - https://www.qemu.org/download/#windows
3. Руководство по установке Debian - https://www.debian.org/releases/stable/i386/index.ru.html
4. PhpMyAdmin - https://www.phpmyadmin.net/downloads/
5. CMS Drupal - https://www.phpmyadmin.net/downloads/
6. Apache - https://httpd.apache.org/docs/









 




