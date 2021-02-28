# Flyer REST API

#### author: Samuel Oliva
This project is an REST API that allows to create and maintain flyers through HTTP methods such as POST, GET, PUT and DELETE. The available endpoints are Flyer, Page, and User and the project was built over the stack Nginx, PHP, and MySQL.

### Basic Instructions
The first thing to do is to create the enviroment by running the following commands:
```
docker-compose -f docker/docker-compose.yml --env-file docker/.env up --build
```

After that, install the dependencies:
```
cd src && composer install
composer require guzzlehttp/guzzle:^6.1 phpunit/phpunit:^5.0
```

Finally, the API endpoints are ready and available on the host:
```
http://localhost:8080
```

### USAGE

Before running the HTTP methods, one must create a user and use basic authentication.

#### User

##### POST

This creates a new user.

`POST http://localhost:8080/user`

Header:
```
Token: 4a9a6162a1c2db905dffa47dede319c4
```

Example:

```
curl -X POST http://localhost:8080/user \
-H "Content-Type: application/json" \
-H "Token: 4a9a6162a1c2db905dffa47dede319c4" \
-d ' 
  {
    "name": "Samuel Oliva", 
    "username": "samuel.oliva", 
    "password": "abcdef"
  }
'
```

#### Flyer

##### POST 

This creates a new flyer.

`POST http://localhost:8080/flyer`

Header:
```
Basic Authentication: user and password created
Token: 4a9a6162a1c2db905dffa47dede319c4
```

Example:

```
curl --user samuel.oliva:abcdef -X POST http://localhost:8080/flyer \
-H "Content-Type: application/json" \
-H "Token: 4a9a6162a1c2db905dffa47dede319c4" \
-d ' 
  {
    "name": "Flyer X",
    "storeName": "Store X",
    "dateValid": "2021-03-20",
    "dateExpired": "2021-03-23",
    "pageCount": 1
  }
'
```

##### GET 

This can return by flyer or all of them.

All flyers:

`POST http://localhost:8080/flyer`

By flyer:

`POST http://localhost:8080/flyer/id`

Examples:

```
curl http://localhost:8080/flyer
```

```
curl http://localhost:8080/flyer/2
```

##### PUT

This can update a flyer.

`POST http://localhost:8080/flyer/id`

Header:
```
Basic Authentication: user and password created
Token: 4a9a6162a1c2db905dffa47dede319c4
```

Example:

```
curl --user samuel.oliva:abcdef -X PUT http://localhost:8080/flyer/1 \
-H "Content-Type: application/json" \
-H "Token: 4a9a6162a1c2db905dffa47dede319c4" \
-d ' 
  {
    "name": "Flyer 1",
    "storeName": "Super Store 1",
    "dateValid": "2021-05-20",
    "dateExpired": "2021-05-20",
    "pageCount": 2
  }
'
```

#### DELETE 

This can delete a flyer.

`POST http://localhost:8080/flyer/id`

Header:
```
Basic Authentication: user and password created
Token: 4a9a6162a1c2db905dffa47dede319c4
```

Example: 

```
curl --user samuel.oliva:abcdef -X DELETE http://localhost:8080/flyer/1 \
-H "Content-Type: application/json" \
-H "Token: 4a9a6162a1c2db905dffa47dede319c4"
```

#### Page

##### POST 

This can create a flyer.

`POST http://localhost:8080/page`

Header:
```
Basic Authentication: user and password created
Token: 4a9a6162a1c2db905dffa47dede319c4
```

```
curl --user samuel.oliva:abcdef -X POST http://localhost:8080/page \
-H "Content-Type: application/json" \
-H "Token: 4a9a6162a1c2db905dffa47dede319c4" \
-d ' 
  {
    "dateValid": "2021-02-10",
    "dateExpired": "2021-02-14",
    "pageNumber": 1,
    "flyerId": 1
  }
'
```

##### GET 

This can return by page or pages by flyer.

All flyers:

`POST http://localhost:8080/page/id`

By flyer:

`POST http://localhost:8080/page/flyer/id`

Examples:

```
curl http://localhost:8080/page/1
```

```
curl http://localhost:8080/page/flyer/1
```

##### PUT

This can update a flyer.

`POST http://localhost:8080/page/id`

Header:
```
Basic Authentication: user and password created
Token: 4a9a6162a1c2db905dffa47dede319c4
```

Example:

```
curl --user samuel.oliva:abcdef -X PUT http://localhost:8080/page/1 \
-H "Content-Type: application/json" \
-H "Token: 4a9a6162a1c2db905dffa47dede319c4" \
-d ' 
  {
    "dateValid": "2022-12-20",
    "dateExpired": "2022-02-14",
    "pageNumber": 1,
    "flyerId": 1
  }
'
```

##### DELETE 

This can delete a page.

`POST http://localhost:8080/page/id`

Header:
```
Basic Authentication: user and password created
Token: 4a9a6162a1c2db905dffa47dede319c4
```

```
curl --user samuel.oliva:abcdef -X DELETE http://localhost:8080/page/1 \
-H "Content-Type: application/json" \
-H "Token: 4a9a6162a1c2db905dffa47dede319c4"
```

