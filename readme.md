# lumen gscp api
Building an open source game server control panel API with Lumen 5.3

## getting started
$ php -S localhost:8888 -t public

## mirgrating db
$ php artisan migrate

## seeding db
1. $ composer dump-autoload
2. $ php artisan migrate:refresh
3. $ php artisan db:seed

## testing
$ phpunit --no-globals-backup

## testing alternative
$ php vendor/phpunit/phpunit/phpunit

#### To Do
- [x] authentication middleware (JWT)
	- [x] restrict put post and delete endpoints
	- [x] finish writing tests for auth controller
	- [ ] auth tests may be creating too many users in DB, find a solution to this
	- [ ] cleanup tests (remove repeatitive code)
			- [ ] auth controller should return data like all other controllers
- [x] add test db
- [ ] make sure remote uses production db
- [ ] ability to seed production db
- [ ] remove or replace
	- [ ] book migration
	- [ ] book seed
	- [ ] book model
	- [ ] book controller
	- [ ] book transformer
	- [ ] book factory
	- [ ] everything related to authors
- [ ] improve book controler validation and custom messages
	- [ ] run tests not in debug mode to see what responses are 
	- [ ] make sure tests are passing for this as well	
- [ ] improve author controler validation and custom messages
	- [ ] run tests not in debug mode to see what responses are 
	- [ ] make sure tests are passing for this as well	
- [x] crud user
	- [ ] user roles
	- [ ] write tests
- [ ] crud server
	- [ ] write tests
- [ ] test remote is working
	- [ ] may need php_memcache.dll and memcached service
- [ ] confirm there is no issue with memcached othewise switch to redis
		- [ ] memcache removed temporarily, set to file
- [ ] look into security concerns with using JWT