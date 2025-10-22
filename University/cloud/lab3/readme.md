# Лабораторная работа №3. Облачные сети

## Цель
Научиться вручную создавать виртуальную сеть (VPC) в AWS, добавлять в неё подсети, таблицы маршрутов, интернет-шлюз (IGW) и NAT Gateway, а также настраивать взаимодействие между веб-сервером в публичной подсети и сервером базы данных в приватной.

## Ход работы

### Шаг 1. Подготовка среды

  
---
  
### Шаг 2. Создание VPC
<img width="1891" height="764" alt="image" src="https://github.com/user-attachments/assets/ba01cac8-bb4d-449b-ba1b-27990e3645a3" />  
  
 > **Что обозначает маска /16? И почему нельзя использовать, например, /8?** Маска /16 означает, что первые 16 бит адреса фиксированы, а остальные 16 бит можно использовать для хостов, всего ~65 000 адресов.
Использовать /8 нельзя, потому что это слишком большая сеть (~16 млн адресов), AWS такие большие VPC не поддерживает и это неуправляемо.

<img width="1625" height="423" alt="image" src="https://github.com/user-attachments/assets/49a293a7-40f8-4603-bd41-50d65917f6e9" />
  
---
  
### Шаг 3. Создание Internet Gateway (IGW)

<img width="1623" height="525" alt="image" src="https://github.com/user-attachments/assets/958546fc-3f01-41f0-b087-2e6b5fcba15d" />
<img width="1649" height="254" alt="image" src="https://github.com/user-attachments/assets/7013cd2d-52e4-4a21-a13b-2d11aa3ff000" />
<img width="1606" height="337" alt="image" src="https://github.com/user-attachments/assets/194d4520-c676-4fe0-83b7-4cbbd9339f10" />
  
---
  
### Шаг 4. Создание подсетей

Подсети (subnets) — это сегменты внутри VPC, которые позволяют изолировать ресурсы. То есть, подсети создаются для разделения ресурсов по функционалу и уровню доступа и для более гибкого управления трафиком. 
(ﾉಥ益ಥ)ﾉ

#### Шаг 4.1. Создание публичной подсети

<img width="1850" height="335" alt="image" src="https://github.com/user-attachments/assets/506d3dd7-aeb7-4c09-8de0-5c1e37f015d7" />
<img width="1847" height="593" alt="image" src="https://github.com/user-attachments/assets/46b4f527-b057-43e2-8fef-412ecef5fc31" />  
  
 > **Является ли подсеть "публичной" на данный момент? Почему?** На данный момент подсеть ещё не является публичной, на просто создана внутри VPC, но не имеет маршрута в Internet Gateway (IGW). Чтобы подсеть стала публичной, нужно добавить в её маршрутную таблицу

#### Шаг 4.2. Создание приватной подсети
<img width="1866" height="340" alt="image" src="https://github.com/user-attachments/assets/e3077ade-a649-40f0-8d98-118c0b35f3b8" />
<img width="1841" height="596" alt="image" src="https://github.com/user-attachments/assets/208319dd-7f6e-441f-9cb4-1827495614b7" />

> **Является ли подсеть "приватной" на данный момент? Почему?** Эта подсеть является приватной, потому что у неё нет маршрута в Internet Gateway (IGW). Трафик из неё не может напрямую попасть в Интернет, а доступ возможен только внутри VPC.
  
---
  
### Шаг 5. Создание таблиц маршрутов (Route Tables)

Теперь, когда у нас есть две подсети (публичная и приватная), необходимо настроить маршруты (Route Tables), которые определяют, как сетевой трафик будет двигаться внутри нашей VPC. (ﾉಥ益ಥ)ﾉ

#### Шаг 5.1. Создание публичной таблицы маршрутов

<img width="1879" height="316" alt="image" src="https://github.com/user-attachments/assets/5ddce595-1767-46b6-9da2-c1b8eea76b3a" />
  
<img width="1845" height="391" alt="image" src="https://github.com/user-attachments/assets/bc8fb9ad-b79e-49ce-a5d2-5392c554666e" />
<img width="1870" height="477" alt="image" src="https://github.com/user-attachments/assets/33163702-8765-43fc-bd24-6cf321c7182e" />

> **Зачем необходимо привязать таблицу маршрутов к подсети?** Привязка нужна, чтобы определить, по каким правилам будет идти трафик из этой конкретной подсети. Если таблица не привязана, подсеть использует основную (main) таблицу — в ней нет маршрута к Интернету, поэтому трафик просто не выйдет наружу.
  
#### Шаг 5.2. Создание приватной таблицы маршрутов

<img width="1862" height="603" alt="image" src="https://github.com/user-attachments/assets/b878b8c1-3b11-4662-90d0-706eac915cea" />
<img width="1861" height="476" alt="image" src="https://github.com/user-attachments/assets/e38a4c2e-0e97-42f6-aede-0684b9009e3a" />

  
---
  
### Шаг 6. Создание NAT Gateway

NAT Gateway позволяет ресурсам в приватной подсети выходить в Интернет (например, для обновления ПО), при этом оставаясь недоступными извне. (ﾉಥ益ಥ)ﾉ
  
> **Как работает NAT Gateway?** NAT Gateway принимает исходящий трафик от ресурсов в приватной подсети, меняет их внутренние IP-адреса на свой публичный, отправляет запросы в Интернет и возвращает ответы обратно.
Таким образом, приватные инстансы могут обращаться наружу, но внешние серверы не могут инициировать соединение обратно — сохраняется изоляция.

#### Шаг 6.1. Создание Elastic IP

<img width="1652" height="663" alt="image" src="https://github.com/user-attachments/assets/70219341-907a-4295-8a7e-14043be90bfb" />

#### Шаг 6.2. Создание NAT Gateway

<img width="1846" height="596" alt="image" src="https://github.com/user-attachments/assets/72e94f3c-612c-43d4-ba82-71d42b829bae" />

### Шаг 6.3. Изменение приватной таблицы маршрутов

<img width="1617" height="571" alt="image" src="https://github.com/user-attachments/assets/5e9eada6-b2bd-4989-9165-9e67bcfde666" />
<img width="1841" height="385" alt="image" src="https://github.com/user-attachments/assets/90d23402-25ac-4787-8207-8f9606dfdd02" />

  
---
  
### Шаг 7. Создание Security Groups

<img width="1856" height="384" alt="image" src="https://github.com/user-attachments/assets/f7d43ba1-915d-427f-96df-43093fea5862" />
<img width="1843" height="320" alt="image" src="https://github.com/user-attachments/assets/2a1f45d6-9cce-4f65-8f73-aa80c7beb0cb" />

<img width="1862" height="385" alt="image" src="https://github.com/user-attachments/assets/3e26e121-a6a5-433e-9d5b-a2402e0302a2" />
<img width="1841" height="241" alt="image" src="https://github.com/user-attachments/assets/8a3f20ca-a05f-4fb6-a13a-200b3ef6ea36" />

<img width="1851" height="383" alt="image" src="https://github.com/user-attachments/assets/7eafadbe-0256-44ad-a380-01ea1bbf280c" />
<img width="1839" height="401" alt="image" src="https://github.com/user-attachments/assets/60a0f760-eb4e-4647-b777-368c367078fa" />

> **Что такое Bastion Host и зачем он нужен в архитектуре с приватными подсетями?** Bastion Host — это публичный сервер, через который администраторы получают доступ к ресурсам в приватной подсети. Он нужен, чтобы безопасно управлять приватными инстансами, не открывая прямой доступ из Интернета.
  
---
  
### Шаг 8. Создание EC2-инстансов

web-server:
<img width="1237" height="235" alt="image" src="https://github.com/user-attachments/assets/81e53f18-b9b5-4d8c-934a-2ab621622383" />
<img width="1225" height="681" alt="image" src="https://github.com/user-attachments/assets/264b04de-4d26-4f4e-a985-15270c3e15c2" />
<img width="1222" height="480" alt="image" src="https://github.com/user-attachments/assets/92430ebe-e2cd-45b1-b3a3-02eb3d8c0495" />

db-server:
<img width="1254" height="236" alt="image" src="https://github.com/user-attachments/assets/89fdf338-2d25-41a9-98f2-728d66741b92" />
<img width="1227" height="682" alt="image" src="https://github.com/user-attachments/assets/18480a48-309a-499f-90a2-e9726feb34d6" />
<img width="1229" height="477" alt="image" src="https://github.com/user-attachments/assets/90b4a225-23ec-432d-84c7-e9246ba75f22" />

bastion-host:
<img width="1229" height="162" alt="image" src="https://github.com/user-attachments/assets/8870a27d-b151-4e54-9668-c4b2d6a6b631" />
<img width="1223" height="683" alt="image" src="https://github.com/user-attachments/assets/5c496ada-4776-4045-8ee3-4d30cf4f7f48" />
<img width="1225" height="474" alt="image" src="https://github.com/user-attachments/assets/09e04a4a-c78c-43da-8b58-a3fc807e9d6b" />


Для всех трех:  
<img width="1230" height="664" alt="image" src="https://github.com/user-attachments/assets/78544549-c320-4117-9a2d-5eeabfd23504" />
<img width="1219" height="231" alt="image" src="https://github.com/user-attachments/assets/971b567d-4994-4a55-812a-b0c3ab8bd29f" />
<img width="1228" height="337" alt="image" src="https://github.com/user-attachments/assets/8b606ae4-1c1c-42b2-8c67-7042f67470a0" />
<img width="1226" height="210" alt="image" src="https://github.com/user-attachments/assets/f42d9f33-8302-469b-abf5-6dce981550fe" />
  
---
  
### Шаг 9. Проверка работы

<img width="1893" height="236" alt="image" src="https://github.com/user-attachments/assets/b44af05c-a19b-4c6a-ac57-aa877b2432ba" />

<img width="1915" height="220" alt="image" src="https://github.com/user-attachments/assets/f1a1c70a-6395-405c-8c29-4e91de7901dc" />

```ssh -i student-key-k15.pem ec2-user@35.158.123.115```
<img width="1444" height="446" alt="image" src="https://github.com/user-attachments/assets/ba2db293-0304-4078-9e81-c45b0b5443cf" />
```mysql -h 10.15.2.143 -u root -p```

<img width="1418" height="66" alt="image" src="https://github.com/user-attachments/assets/0b649a01-57f5-4ac4-8a5f-4ee59ea68f68" />

  
---
  
### Шаг 10. Дополнительные задания. Подключение в приватную подсеть через Bastion Host
  
---
  

  
## Заключение

## Библиография
