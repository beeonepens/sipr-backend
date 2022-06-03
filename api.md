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
      "password?": "xxxx",
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

### Get Detail User

-   url: http://localhost:8000/api/meet/show?nip=13 atau http://localhost:8000/api/meet/show?is_active=1 or 0
-   method: Get
-   body:
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
        "name": "Webinar C++",
        "description": "Webinar By PENS",
        "isOnline": 0,
        "limit": 2,
        "room_id": 120,
        "user_id": 3120500xxx,
        "date_start": [
            "yyyy-mm-dd:hh:ss",
            "yyyy-mm-dd:hh:ss"
        ],
        "date_end": [
            "yyyy-mm-dd:hh:ss",
            "yyyy-mm-dd:hh:ss"
        ],
        "participants":[
            "3120500xxx",
            "3120500xxx"
        ],
        "teams": []
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

### Delete Room

-   url: http://localhost:8000/api/room/delete/{id}
-   method: DELETE
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

## Team

### Create Team

-   url: http://127.0.0.1:8000/api/team/store
-   method: POST
-   body:
    ```
    {
        "name_teams" : "D4 ITA",
        "description" : null,
        "user_id" : "3120500046"
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get Detail Team

-   url: http://127.0.0.1:8000/api/team/show?id=1 atau ?idCreator=3120500044 atau ?nameTeam=D3 ITB
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Update Team

-   url: http://127.0.0.1:8000/api/team/update/{id_team}
-   method: PUT
-   body:
    ```
    {
        "name" : "D3 ITB",
        "description" : asdadasd"
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Delete Meeting

-   url: http://127.0.0.1:8000/api/team/delete/{id}
-   method: DELETE
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

## Team Member

### Join Team

-   url: http://127.0.0.1:8000/api/team/join?id_team=2&id_member=3120500033
-   method: POST
-   body:
    ```
    {
        "kode" : "21f270c0ce"
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get Show Member Team

-   url: http://127.0.0.1:8000/api/team/member/{id_team}
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Delete Team Member

-   url: http://127.0.0.1:8000/api/team/delete/member/{id_team}/{id_member}
-   method: DELETE
-   body:
    ```
    {
        "id_pembuat": "3120500046"  - Untuk Verifikasi id user
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

## Invitation

### Create Invite

-   url: http://127.0.0.1:8000/api/invite/store
-   method: POST
-   body:
    ```
    {
        "id_invitee": "3120500046",
        "id_receiver": "3120500033",
        "id_meet": "1"
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get All Invite

### Belum Jadi

-   url: http://localhost:8000/api/room
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get Detail Invite

-   url: http://127.0.0.1:8000/api/invite/show?id=1 atau ?idInvitee=3120500044
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Update Room

### Belum Jadi

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

### Delete Room

### Belum Jadi

-   url: http://localhost:8000/api/room/delete/{id}
-   method: DELETE
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

## Notification

### Create Notification

-   url: http://127.0.0.1:8000/api/notif/store
-   method: POST
-   body:
    ```
    {
        "title" : "Meeting Sebentar Lagi",
        "description?" : "asdadasd",
        "notificationType" : "notification",
        "publicationDate": "2022-28-5:08:00",
        "meet_id": 2,
        "user_id": "3120500046"
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get All Notification

-   url: http://127.0.0.1:8000/api/notif
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Get Notification

-   url: http://127.0.0.1:8000/api/notif/show?id=1 atau ?idMeet=41 atau ?notificationType=notification or invitation atau ?isRead=0 or 1
-   method: Get
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Update Notification

-   url: http://127.0.0.1:8000/api/notif/update/{id}
-   method: PUT
-   body:
    ```
    {
        "isRead" : 1 or 0
    }
    ```
-   headers:
    -   Authorization : Bearer |1xxxxxxx

### Delete Notification

-   url: http://127.0.0.1:8000/api/notif/delete/{id}
-   method: DELETE
-   body:
-   headers:
    -   Authorization : Bearer |1xxxxxxx

---

-   note:

    -   (?) berarti optional
    -   (i) berarti index

-   note:
    -   (?) berarti optional
    -   (i) berarti index
