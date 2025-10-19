# Лабораторная работа №2. Введение в AWS. Вычислительные сервисы

## Цель
Познакомиться с основными вычислительными сервисами AWS, научиться создавать и настраивать виртуальные машины (EC2), а также развёртывать простые веб-приложения.

## Ход работы

### Задание 1. Создание IAM группы и пользовател

<img width="1812" height="731" alt="image" src="https://github.com/user-attachments/assets/2b62812a-9a84-44e8-84bc-aecaeabd5408" />
<img width="1871" height="250" alt="image" src="https://github.com/user-attachments/assets/c5e23d91-1924-4a16-9414-7babcc0be9b9" />
  
> Что делает политика AdministratorAccess?

Политика AdministratorAccess предоставляет полный административный доступ ко всем ресурсам AWS. Это эквивалент суперпользователя (root), но без возможности изменять данные самого root-аккаунта.

Ввожу имя нового юзера и даю ему права к AWS Management Console:  
  
<img width="1328" height="730" alt="image" src="https://github.com/user-attachments/assets/8478f713-c099-4be6-a5dc-27fbea83d3a4" />  
  
Добавляю этого юзера к ранее созданной группе `Admins`:  
  
<img width="1866" height="654" alt="image" src="https://github.com/user-attachments/assets/40aa3757-43d0-40e0-ad65-2f0517d9e064" />  

Убеждаюсь, что новый юзер точно создан и имеет доступ к AWS консоли. Выхожу из root-аккаунта и захожу под новым IAM пользователем.

---

### Задание 2. Настройка Zero-Spend Budget

На этом этапе настраивается Zero-Spend Budget, который будет высылать уведомления на электронную почту, если расходы превысят $0:  
  
<img width="1859" height="248" alt="image" src="https://github.com/user-attachments/assets/5a316620-5dd1-4da4-9c72-979cd8e89ceb" />

---

### Задание 3. Создание и запуск EC2 экземпляра (виртуальной машины)

> Что такое User Data и какую роль выполняет данный скрипт? Для чего используется nginx?
!!!User Data — это скрипт, который выполняется автоматически при первом запуске EC2-инстанса. Он используется для автоматической настройки и инициализации сервера без ручного входа по SSH. В данном случае скрипт: Обновляет систему (dnf -y update); Устанавливает утилиту htop для мониторинга ресурсов; Устанавливает и запускает nginx — популярный веб-сервер.  
  
!!!Nginx — это лёгкий и быстрый веб-сервер, используемый для: обслуживания статических веб-страниц; обратного проксирования и балансировки нагрузки; запуска веб-приложений. В данной лабораторной работе он используется для развёртывания простого веб-сервера, который будет доступен по публичному IP-адресу.  
<img width="1251" height="239" alt="image" src="https://github.com/user-attachments/assets/d9893624-ebc9-4284-981a-dfcc206e7808" />
<img width="1246" height="544" alt="image" src="https://github.com/user-attachments/assets/7007c254-d3b7-41cf-87b3-e072ab41ba89" />
<img width="1230" height="245" alt="image" src="https://github.com/user-attachments/assets/1e9d20a4-8974-4b53-bd0f-c9ba11385285" />
<img width="1237" height="216" alt="image" src="https://github.com/user-attachments/assets/d59157e9-4a38-45b4-80ac-c3850e71e035" />
<img width="1230" height="643" alt="image" src="https://github.com/user-attachments/assets/afbed0b6-5df1-4856-8edd-a19118c12ca4" />
<img width="1229" height="681" alt="image" src="https://github.com/user-attachments/assets/bcb58f71-1119-4932-b228-dc92938fba77" />
<img width="1235" height="355" alt="image" src="https://github.com/user-attachments/assets/43185de9-3bf5-462f-a3c7-cd6eccfdc528" />
<img width="1247" height="550" alt="image" src="https://github.com/user-attachments/assets/18fdd4f0-736e-4684-9e0e-527e68df84a9" />
<img width="1836" height="686" alt="image" src="https://github.com/user-attachments/assets/65c9aea3-2e6b-4f85-99e8-a0258e5cd82e" />

 
  
Проверяю, что веб-сервер работает, открыв в браузере URL: https://63.179.87.90:  
<img width="1913" height="288" alt="image" src="https://github.com/user-attachments/assets/0b1c260b-fd07-4d85-9691-af8041672392" />


---

### Задание 4. Логирование и мониторинг

3/3 значит я крутая?  
  
<img width="1835" height="218" alt="image" src="https://github.com/user-attachments/assets/2e9deb63-ed44-464d-b1d1-5f8a2f26bdea" />

Проверяю вкладку `Monitoring`:
<img width="1842" height="387" alt="image" src="https://github.com/user-attachments/assets/f10826d7-709e-4e6a-af98-9725cf44790a" />  

> В каких случаях важно включать детализированный мониторинг?
Детализированный мониторинг (1-минутный интервал сбора метрик) стоит включать, когда: требуется оперативная реакция на изменения нагрузки; вы настраиваете автоматическое масштабирование (Auto Scaling); необходимо точное SLA-отслеживание или детальные отчёты производительности; приложение чувствительно к пикам нагрузки (например, веб-сервисы, базы данных).

Проверяем логи, в качестве примера ищем строки с установкой `nginx`:  
  
<img width="1833" height="630" alt="image" src="https://github.com/user-attachments/assets/09b0f956-cc70-4f30-a25b-44b24f963953" />  


---

### Задание 5. Подключение к EC2 инстансу по SSH
<img width="534" height="646" alt="image" src="https://github.com/user-attachments/assets/7aa8b122-18fc-44f1-b05f-f4afaea4bf9c" />

<img width="1096" height="308" alt="image" src="https://github.com/user-attachments/assets/048b5f8d-56fa-49dd-82de-5588269f9c50" />
ssh -i caxa-key.pem ec2-user@63.179.87.90
<img width="1093" height="639" alt="image" src="https://github.com/user-attachments/assets/acc2b409-3f0d-4385-b841-5167a29b160a" />

> Почему в AWS нельзя использовать пароль для входа по SSH?
В AWS нельзя использовать пароль для входа по SSH, потому что это небезопасно — пароли легко подобрать. Вместо них используют ключи, которые гораздо труднее взломать.

---

### Задание 6c. Запуск PHP-приложения в Docker  

<img width="1100" height="145" alt="image" src="https://github.com/user-attachments/assets/499a4707-1d98-419b-9a7e-0e9f225b6af4" />

scp -i "D:\University\Local\AWS\caxa-key.pem" -r "D:\University\Local\sawm\sawmlab3" ec2-user@63.179.87.90:/home/ec2-user/php-docker-app/app
<img width="1560" height="271" alt="image" src="https://github.com/user-attachments/assets/7fe9396d-e50c-46c7-b727-358fc0c1619f" />

<img width="1890" height="850" alt="image" src="https://github.com/user-attachments/assets/c1af70ee-88e4-465e-b3f9-5a1a75041c79" />
<img width="1900" height="326" alt="image" src="https://github.com/user-attachments/assets/0af089e5-8539-46d3-986a-875880253ee4" />
<img width="1901" height="152" alt="image" src="https://github.com/user-attachments/assets/4fe6e10c-c00f-4d50-8c3c-d3a40e72890c" />
<img width="1900" height="144" alt="image" src="https://github.com/user-attachments/assets/8fb4d548-19c1-4c3b-b35e-114e5ee55479" />

Все великолепно не работает до сих пор ЮХУУУУУ:
<img width="1919" height="774" alt="image" src="https://github.com/user-attachments/assets/90a09548-13a3-426d-a9c7-bc7bb7cbba32" />
<img width="1919" height="793" alt="image" src="https://github.com/user-attachments/assets/ef6b9f9f-011a-4f73-b5c6-42435226d828" />













