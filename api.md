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
      nip: 123123
      email: xxx@email.com,
      password: xxxx,
      name: xxxxx
      address?: asdjlasd
      dst
    }
    ```
-   headers: -

### Update User

-   url: http://localhost:8000/api/user/store
-   method: POST
-   body:
    ```
    {
      nip: 123123
      email: xxx@email.com,
      password: xxxx,
      name: xxxxx
      address?: asdjlasd
      dst
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

## Meeting

### Create Meeting

-   url: http://localhost:8000/api/meet/store
-   method: POST
-   body:
    ```
    {
      name: 123123
      description: xxx@email.com,
      isOnline: 1 or 0,
      limit: 1 or 0
      room_id: 123123
      user_id: 123123
      date_start[i]: yyyy-mm-dd:hh:ss
      date_end[i]: yyyy-mm-dd:hh:ss
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
      name: 123123
      description : xxx@email.com,
      isOnline: 1 or 0,
      limit: 1 or 0
      room_id: 123123
      user_id: 123123
      date_start[i]: yyyy-mm-dd:hh:ss
      date_end[i]: yyyy-mm-dd:hh:ss
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
      name_room: xxxxxxx
      description: xxx@email.com,
      isOnline: 1 or 0,
      isBooked: 1 or 0
      user_id: 123123
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get All Meeting

-   url: http://localhost:8000/api/room
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get Detail Meeting

-   url: http://localhost:8000/api/room/show?id=13 atau http://localhost:8000/api/room/show?id_user=1
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
      name_room: xxxxxxx
      description: xxx@email.com,
      isOnline: 1 or 0,
      isBooked: 1 or 0
      user_id: 123123
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
