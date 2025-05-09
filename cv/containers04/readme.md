# Лабораторная работа №4. Использование контейнеров как среды выполнения

## Цель работы
Данная лабораторная работа призвана напомнить основные команды ОС Debian/Ubuntu. Также она позволит познакомиться с Docker и его основными командами.

## Задание
Запустить контейнер Ubuntu, установить Web-сервер Apache и вывести в браузере страницу с текстом "Hello, World!".

## Ход работы
Находясь в папке ``containers04``, я ввожу в терминале команду, которая запускает контейнер Ubuntu с именем containers04, перенаправляет порт 8000 хоста на 80 контейнера и открывает интерактивную оболочку Bash.
![Снимок экрана 2025-03-08 164234](https://github.com/user-attachments/assets/4b2a149f-6dd9-4a5a-8e25-45ae3ba94ca4)  

В открывшемся окне я выполняю следующие команды:
- `apt update` - обновляет список пакетов и их версий из репозиториев
![Снимок экрана 2025-03-08 164320](https://github.com/user-attachments/assets/9fd68ad2-76b9-465f-a572-93c336a619b3)
- `apt install apache2 -y` - устанавливает веб-сервер Apache
![Снимок экрана 2025-03-08 164503](https://github.com/user-attachments/assets/3f034f35-1bec-4c62-b34e-9b0f34625567)
- `service apache2 start` - запускает службу Apache
![Снимок экрана 2025-03-08 164553](https://github.com/user-attachments/assets/5166c9e5-69ea-4226-bac7-2dcc524e0ec1)

Открыв браузер, я вводу в адресную строку `http://localhost:8000`, в результате чего можно увидеть следующее:
![Снимок экрана 2025-03-08 170722](https://github.com/user-attachments/assets/642b6d2c-9e94-4889-9258-267ae107411d)  

Далее я выполняю команды, которые выводят содержимое файлов и директорий в папке `ls -l /var/www/html/` и создает(или перезаписываеи) html файл `index.html`, добавляя в него заголовок "Hello, World!"  
![Снимок экрана 2025-03-08 171042](https://github.com/user-attachments/assets/1375f759-40de-478c-ad3e-58e5d2f182ec)
![Снимок экрана 2025-03-08 171101](https://github.com/user-attachments/assets/0feeb28c-1917-4897-adf6-87e7ce564029)

Я обновляю ранее открытую страницу в браузере, где теперь можно увидеть добавленный мной заголовок:  
![Снимок экрана 2025-03-08 171130](https://github.com/user-attachments/assets/26921f42-35fd-4eb3-9141-534e6559ca79)

Затем я возвращаюсь к терминалу и ввожу команды, благодаря которым перехожу в директорию с конфигурационными файлами виртуальных хостов Apache и вывожу содержимое файла `000-default.conf`  
![Снимок экрана 2025-03-08 171333](https://github.com/user-attachments/assets/5a743f1f-9b88-4704-862c-d9440918b91a)

В конце я выхожу из терминала при помощи команды `exit`. Посматриваю список активных контейнеров и удаляю `containers04`
![Снимок экрана 2025-03-08 171357](https://github.com/user-attachments/assets/575d6765-3a5d-4948-9437-aea89c718a1a)  
![Снимок экрана 2025-03-08 171422](https://github.com/user-attachments/assets/c4d7fa95-d6f4-46a4-8102-ef9a550e8682)
![Снимок экрана 2025-03-08 171438](https://github.com/user-attachments/assets/6d246c57-2399-4047-82fc-89af2a4189de)





## Вывод
В результате выполнения данной лабораторной работы я запустила новый контейнер Ubuntu и установила веб-сервер Apache, благодаря чему смогла вывести на страницу браузера текст "Hello, World!".
