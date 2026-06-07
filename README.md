# RateDaMonster

RateDaMonster is a PHP web application that allows users to browse, rate, and review Monster Energy drinks. Users can create accounts, submit ratings for different Monster flavors, and view ratings from other users. Administrators can manage both users and Monster entries through a dedicated admin panel.

---

## Features

### User Features

* User registration and login
* Secure password hashing with bcrypt
* Password strength validation
* Session-based authentication
* Browse Monster Energy drinks
* View detailed information about each Monster flavor
* Submit ratings based on:
  * Overall rating
  * Sourness
  * Sweetness
  * Carbonation
  * Energy kick
* View ratings submitted by other users

### Admin Features

* User management dashboard
* User list
* Delete users
* Monster management dashboard
* Add new Monster drinks
* Edit existing Monster drinks
* Delete Monster drinks

---

# Screenshots

## Authentication Pages
**Login Page**    
![Login Page](screenshots/monster-login.png)

**Register Page**   
![Register Page](screenshots/monster-register.png)

---

## User Pages
**Monsters List Page**  
![Monsters Page](screenshots/monsters-page.png)

**Monster Details Page**  
![Monster Page](screenshots/monster-details1.png)

**Monster Details Page**  
![Monster Page](screenshots/monster-details2.png)

---

## Admin Panel

**Admin Users Page**    
![Admin Users Page](screenshots/admin-users.png)

**Admin Monsters Page**
![Admin Monsters Page](screenshots/admin-monsters.png)

---

## Database Diagram

### ERD (Entity Relationship Diagram)
![ERD Diagram](screenshots/erd.png)

---

## Technology Stack

### Backend

* PHP 8+
* PostgreSQL
* PDO

### Frontend

* HTML5
* CSS3
* Vanilla JavaScript

### Infrastructure

* Docker
* Nginx
* PostgreSQL

---

## Project Structure

```text
RateDaMonster/
|
├── certs/
|
├── docker/
│   ├── db/
│   ├── nginx/
│   └── php/
|
├── public/
│   ├── views/
│   ├── scripts/
│   ├── styles/
│   └── img/
│
├── src/
│   ├── controllers/
│   └── repositories/
│
├── docker-compose.yaml
├── config.php
├── Database.php
├── Routing.php
└── index.php

## Authentication

Passwords are:

* Validated on both client and server side
* Hashed using `password_hash()` with `PASSWORD_BCRYPT`
* Verified using `password_verify()`

Password requirements:

* Minimum 8 characters
* At least one uppercase letter
* At least one lowercase letter
* At least one number
* At least one special character

## Installation

### Clone Repository

```bash
git clone <repository-url>
cd RateDaMonster
```

### Configure Database

Update database settings inside:

```php
config.php
```

### Start Containers

```bash
docker compose up --build
```

### Access Application

Open:

```text
http://localhost
```

## Admin Access

Administrator accounts use:

```text
account_type_id = 2
```

Admin users have access to:

```text
/admin/users
/admin/monsters
```
