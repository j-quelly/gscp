# lumen gscp api
Building an open source game server control panel API with Lumen 5.x

## getting started
$ php -S localhost:8080 -t public

## mirgrating db
$ php artisan migrate

## testing
Use postman or cURL, eventually add phpunit tests
$ curl -I http://localhost:8080/api/v1/book

#### To Do
- remove/replace
	- book migration
	- book model
	- book controller
- authentication middleware
	- APPID
	- token
- crud user
	- write tests
- crud server
	- write tests
- put online
