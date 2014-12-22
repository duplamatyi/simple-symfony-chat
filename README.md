Simple Chat Application
========================

1) Installing the project
----------------------------------

First clone this repository to your local machine.

Install the dependencies with composer:

```
composer install
```

Make sure that the app/logs, app/cache and db/ directories are writable for both the command line user and the web server user.

Create the sqlite database by running the migrations:

```
app/console doctrine:migrations:migrate
```

2) Running the tests
---------------------------
You can run the tests with PHPUnit:

```
bin/phpunit -c app/
```

3) Managing users
---------------------------
You can create new users and list exising users with the following commands:

```
app/console chat:user:create user1
app/console chat:user:create user2
app/console chat:user:list
+----+----------+
| id | username |
+----+----------+
| 1  | user1    |
| 2  | user2    |
+----+----------+
```

4) Trying out the API
-----------------------------
Start PHP's built-in web server:

```
app/console server:start
```

Go to the API documentation at http://127.0.0.1:8000/api/doc/ and try out the sandboxes:

![Alt screenshot](https://raw.githubusercontent.com/duplamatyi/simple-symfony-chat/master/web/example/simple_chat.png)

Or use curl from a terminal:

```
curl -H "Content-Type: application/json" -d '{"author_id":"1","recipient_id":"2","content":"Hello World!"}' http://127.0.0.1:8000/message/send
curl -H "Content-Type: application/json" http://127.0.0.1:8000/message/get-messages?recipient_id=2
```
