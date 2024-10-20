<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.



## How To Install

Clone
<br>
    ```
    clone https:github.com/chairilptmgahama/room_booking
    ```
<br>
<br>

Install
<br>
    ```
    php composer install
    ```
<br>
<br>

Copy
<br>
    copy .env.example to .env
<br>

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_DB_Name
DB_USERNAME=your_db_username
DB_PASSWORD=your_DB_password
```

###Run
<br>
```
php artisan serv
```
<br>    
<br>

###Login API
<br>
```
curl --location --request POST 'http:localhost:3000/api/v1/data/login' \
    --header 'accept: application/json'  \
    --header 'key: room_schedule' \
    --header 'Content-Type: application/json' \
    --data '{"username": "myuser", "password":"user_2024"}'
```
```
{
    "status": 1,
    "message": null,
    "data": {
        "object_id": "bzRWT28vZ3BUM0E9",
        "username": "myuser"
    }
}
```

###Booking Schedule
<br>
```
    curl --location --request POST 'http:localhost:3000/api/v1/booking/room' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \
    --data '{"date": "2024-10-20", "from":"12:00", "to":"14:00", "participant":"6"}'
```
```
{
    "status": 1,
    "message": null,
    "data": {
        "schedule_id": "VHMZM1V79IA38C", 
        "date": "2024-10-20",
        "from": "12:00",
        "to": "14:00",
        "participant": "6"
    }
}
```

###Update Participant
```
    curl --location --request POST 'http:localhost:3000/api/v1/booking/participant' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \
    --data '{"schedule_id": "VHMZM1V79IA38C", "participant":"6"}'
```
```
        {
            "status": 1,
            "message": null,
            "data": {
                "schedule_id": "VHMZM1V79IA38C",
                "date": "2024-10-20 00:00:00",
                "from": "11:40",
                "to": "14:00",
                "participant": "20"
            }
        }
```

###Update Memo
```
    curl --location --request POST 'http:localhost:3000/api/v1/booking/memo' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \
    --data '{"schedule_id": "VHMZM1V79IA38C", "memo":"https:www.scribd.com/document/427141813/Example-of-Memo"}'
```
```
    {
        "status": 1,
        "message": null,
        "data": {
            "schedule_id": "VHMZM1V79IA38C",
            "date": "2024-10-20 00:00:00",
            "from": "11:40",
            "to": "14:00",
            "participant": 15,
            "memo": "https:www.scribd.com/document/427141813/Example-of-Memo"
        }
    }
```

###List Schedule
```
    curl --location --request POST 'http:localhost:3000/api/v1/mybooking' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \
```
```
    {
        "status": 1,
        "message": null,
        "data": [
            {
                "schedule_id": "CPM0M1JZJK2KNW",
                "date": "2024-10-20 00:00:00",
                "from": "11:40",
                "to": "14:00",
                "participant": 15,
                "memo": "https:www.scribd.com/document/427141813/Example-of-Memo"
            },
            {
                "schedule_id": "9GXZY2WTOEPXRZ",
                "date": "2024-10-20 00:00:00",
                "from": "15:00",
                "to": "17:00",
                "participant": 6,
                "memo": null
            }
        ]
    }
```