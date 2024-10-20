## How To Install

###Clone
    ```bash
    clone https://github.com/chairilptmgahama/room_booking
    ```

###Install
    ```bash
    php composer install
    ```
    - copy .env.example to .env
    ```bash
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_DB_Name
        DB_USERNAME=your_db_username
        DB_PASSWORD=your_DB_password
    ```

###Run
    ```bash
    php artisan serv
    ```bash
    

###Login API
    ```bash
    curl --location --request POST 'http://localhost:3000/api/v1/data/login' --header 'accept: application/json' --header 'key: room_schedule' --header 'Content-Type: application/json' --data '{"username": "myuser", "password":"user_2024"}'
    ``
        {
            "status": 1,
            "message": null,
            "data": {
                "object_id": "bzRWT28vZ3BUM0E9",
                "username": "myuser"
            }
        }


Booking Schedule
    curl --location --request POST 'http://localhost:3000/api/v1/booking/room' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \
    --data '{"date": "2024-10-20", "from":"12:00", "to":"14:00", "participant":"6"}'

    //    {
    //        "status": 1,
    //        "message": null,
    //        "data": {
    //            "schedule_id": "VHMZM1V79IA38C", 
    //            "date": "2024-10-20",
    //            "from": "12:00",
    //            "to": "14:00",
    //            "participant": "6"
    //        }
    //    }


Update Participant
    curl --location --request POST 'http://localhost:3000/api/v1/booking/participant' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \
    --data '{"schedule_id": "VHMZM1V79IA38C", "participant":"6"}'

    //    {
    //        "status": 1,
    //        "message": null,
    //        "data": {
    //            "schedule_id": "VHMZM1V79IA38C",
    //            "date": "2024-10-20 00:00:00",
    //            "from": "11:40",
    //            "to": "14:00",
    //            "participant": "20"
    //        }
    //    }


Update Memo
    curl --location --request POST 'http://localhost:3000/api/v1/booking/memo' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \
    --data '{"schedule_id": "VHMZM1V79IA38C", "memo":"https://www.scribd.com/document/427141813/Example-of-Memo"}'

    //{
    //    "status": 1,
    //    "message": null,
    //    "data": {
    //        "schedule_id": "VHMZM1V79IA38C",
    //        "date": "2024-10-20 00:00:00",
    //        "from": "11:40",
    //        "to": "14:00",
    //        "participant": 15,
    //        "memo": "https://www.scribd.com/document/427141813/Example-of-Memo"
    //    }
    //}

List Schedule
    curl --location --request POST 'http://localhost:3000/api/v1/mybooking' \
    --header 'accept: application/json' \
    --header 'key: room_schedule_test' \
    --header 'Content-Type: application/json' \
    --header 'object_id: UTJqb2RjZkNiZEE9' \

    //{
    //    "status": 1,
    //    "message": null,
    //    "data": [
    //        {
    //            "schedule_id": "CPM0M1JZJK2KNW",
    //            "date": "2024-10-20 00:00:00",
    //            "from": "11:40",
    //            "to": "14:00",
    //            "participant": 15,
    //            "memo": "https://www.scribd.com/document/427141813/Example-of-Memo"
    //        },
    //        {
    //            "schedule_id": "9GXZY2WTOEPXRZ",
    //            "date": "2024-10-20 00:00:00",
    //            "from": "15:00",
    //            "to": "17:00",
    //            "participant": 6,
    //            "memo": null
    //        }
    //    ]
    //}