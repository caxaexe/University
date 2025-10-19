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
  
<img width="1915" height="410" alt="image" src="https://github.com/user-attachments/assets/8ea7e44a-dab5-4b8e-bd8f-9bfa052b14bf" />  

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




