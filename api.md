## Auth

### Login

-   url: http://localhost:8000/api/login
-   method: POST
-   body:
    ```
    {
      email: xxx@email.com,
      password: xxxx,
    }
    ```
-   headers: -

### Register User

-   url: http://localhost:8000/api/user/store
-   method: POST
-   body:
    ```
    {
      "nip": 123123
      "name": "asdasd asdasd"
      "role_id": 1 or 2,
      "email": "xxx@email.com",
      "password": "xxxx",
      "avatarUrl?": "asdasd/asdasd/asdasd.asd",
      "address?": "asdjlasd",
      "gender?" : "pria" or "wanita,
      "dateofbirth?": "yyyy-mm-dd"
    }
    ```
-   headers: -

### Update User

-   url: http://localhost:8000/api/user/update/{nip}
-   method: PUT
-   body:
    ```
    {
      "nip": 123123
      "name": "asdasd asdasd"
      "role_id": 1 or 2,
      "email": "xxx@email.com",
      "password": "xxxx",
      "avatarUrl?": "asdasd/asdasd/asdasd.asd",
      "address?": "asdjlasd",
      "gender?" : "pria" or "wanita,
      "dateofbirth?": "yyyy-mm-dd"
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get All User

-   url: http://localhost:8000/api/user
-   method: Get
-   body:
-   headers: -

---

## Meeting

### Create Meeting

-   url: http://localhost:8000/api/meet/store
-   method: POST
-   body:
    ```
    {
        "name": "asdasdad asdasd",
        "description": asdasd asdasdas",
        "isOnline": 1 or 2,
        "limit": 123,
        "room_id": 123123,
        "user_id": 123123,
        "date_start": [
            "yyyy-mm-dd:hh:ss",
            "yyyy-mm-dd:hh:ss"
        ],
        "date_end": [
            "yyyy-mm-dd:hh:ss",
            "yyyy-mm-dd:hh:ss"
        ]
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get All Meeting

-   url: http://localhost:8000/api/meet
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get Detail Meeting

-   url: http://localhost:8000/api/meet/show?id=13 atau http://localhost:8000/api/meet/show?id_user=1
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Update Meeting

-   url: http://localhost:8000/api/meet/update
-   method: PUT
-   body:
    ```
    {
       "name": "asdasdad asdasd",
        "description": "asdasd asdasdas",
        "isOnline": 1 or 2,
        "limit": 123,
        "room_id": 123123,
        "user_id": 123123,
        "date_start": [
            "yyyy-mm-dd:hh:ss",
            "yyyy-mm-dd:hh:ss"
        ],
        "date_end": [
            "yyyy-mm-dd:hh:ss",
            "yyyy-mm-dd:hh:ss"
        ]
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Delete Meeting

-   url: http://localhost:8000/api/meet/delete/{id}
-   method: DELETE
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

## Room

### Create Room

-   url: http://localhost:8000/api/room/store
-   method: POST
-   body:
    ```
    {
        "name_room": "asdasdad asdasd",
        "description": "asdasd asdasdas",
        "isOnline": 0 or 1,
        "isBOoked": 0 or 1,
        "user_id": 123123,
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get All Room

-   url: http://localhost:8000/api/room
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get Detail Room

-   url: http://localhost:8000/api/room/show?id=13 atau http://localhost:8000/api/room/show?id_user=1
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Update Room

-   url: http://localhost:8000/api/meet/update
-   method: PUT
-   body:
    ```
    {
        "name_room": "asdasdad asdasd",
        "description": "asdasd asdasdas",
        "isOnline": 0 or 1,
        "isBOoked": 0 or 1,
        "user_id": 123123,
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Delete Meeting

-   url: http://localhost:8000/api/room/delete/{id}
-   method: DELETE
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

-   note:
    -   (?) berarti optional
    -   (i) berarti index
