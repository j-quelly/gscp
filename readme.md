# lumen gscp api
Building an open source game server control panel API with Lumen 5.x

## getting started
$ php -S localhost:8888 -t public

## mirgrating db
$ php artisan migrate

## testing
$ php vendor/phpunit/phpunit/phpunit

#### To Do
- [x] get routes working on remote
- [x] add logger middleware
- [x] begin writing tests
- [ ] authentication middleware
	- [ ] APPID
	- [ ] token
- [ ] remove/replace
	- [ ] hello middleware & additional routes
	- [ ] book migration
	- [ ] book model
	- [ ] book controller
- [ ] crud user
	- [ ] write tests
- [ ] crud server
	- [ ] write tests
- [x] map to remote