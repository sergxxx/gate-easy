# Ворота Просто — Удалённое управление воротами

Laravel + Vue3 SPA-приложение для удалённого открытия ворот через виртуальную телефонию.
Система позволяет авторизованным и активным пользователям:
- регистрироваться и авторизоваться;
- открывать ворота;
- получать список ворот.

Функциональность реализована на Laravel 11 + Sanctum + Vue3 (Vite).
Открытие ворот осуществляется через виртуальную телефонию Novofon — либо немедленно через API, либо через очередь RabbitMQ (через Laravel Queue Supervisor).

---

## Технологии

- **Backend Framework**: Laravel 11
- **БД**: Mysql
- **Frontend**: Vue 3, Vite
- **Очереди**: Laravel Queue (с поддержкой задержек, флагов, таймаутов) с помощью RabbitMQ
- **Телефония**: Novofon API

---

## Структура проекта

### Frontend

- resources/js/main.js — точка входа Vue3 SPA
- resources/views/gates.blade.php — HTML-шаблон, подключающий SPA

### Backend

- Laravel 11 (Bootstrap, Routes, Middleware, Controllers, Services, Jobs)
- API авторизация через Sanctum
- Использование Middleware check.active — для проверки активации пользователя
- Очереди и обработка задач через RabbitMQ и Supervisor
- NovofonClient — интеграция с внешним API телефонии

## Компоненты и их назначение

#### Основной bootstrap (bootstrap/app.php)
Создаёт и конфигурирует Laravel-приложение: маршруты, middleware, обработку исключений.

### Middleware: CheckUserActive
Проверяет, активирован ли пользователь (поле is_active в таблице users).

### API маршруты routes/api.php
- /v1/register
- /v1/login
- /v1/logout
- /v1/user
- /v1/gates
- /v1/gate/open

Авторизованные маршруты защищены auth:sanctum и check.active.

### Модель пользователя App\Models\User
- Использует HasApiTokens для работы с Sanctum
- is_active указывает, может ли пользователь пользоваться API

### Контроллер: AuthController

Реализует:
- register — регистрация пользователя, по умолчанию is_active = false
- login — проверка пароля и создание токена
- logout — удаление токенов пользователя
- user — текущий пользователь

### Контроллер: GateController
- getGates — возвращает список ворот через сервис GateService
- open — инициирует открытие ворот через сервис GateService

### Сервис: GateService

Инкапсулирует бизнес-логику:
- Получает список ворот (getGateList)
- Отправляет запрос на открытие ворот (openGate)
- - выбирает стратегию отправки: ImmediateGateSendStrategy или QueuedGateSendStrategy

### Репозиторий GateRepository
Содержит локальный конфиг со списком ворот

Методы:
- all() — список ворот
- getPhoneNumberByGateId(int $id) — номер по ID

### GateServiceProvider

В зависимости от конфигурации .env (GATE_SEND_QUEUE=true/false) подключает нужную стратегию отправки звонка:
- ImmediateGateSendStrategy — вызывает API сразу
- QueuedGateSendStrategy — добавляет задачу в очередь

### Стратегии отправки звонка
- ImmediateGateSendStrategy - Немедленный вызов NovofonClient->requestCheckNumber($phone)
- QueuedGateSendStrategy - Создаёт задачу OpenGateJob, которая будет выполнена через очередь

### Очередь: OpenGateJob
Отправляет звонок только если прошло менее 4 секунд с момента постановки задачи (анти-флуд логика)

## Web маршруты routes/web.php
Используется для поддержки Vue SPA — перенаправляет все маршруты на resources/views/gates.blade.php.

### Blade-шаблон gates.blade.php
Загружает Vue3 SPA


## Контакты:

Сергей

Email: 79093152522@ya.ru

Telegram: https://t.me/vihsergey
