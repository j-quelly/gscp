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
	- [ ] refactor auth tests again (remove repeatitive code)
	- [x] test invalid token	
	- [ ] test auth login validation
	- [ ] auth controller should return data in the same format as other controllers
	- [ ] work on status codes
		- 200 - OK
		- 201 - Created
		- 304 - Not modified
		- 400 - Bad Request
		- 401 - Unauthorized
		- 403 - Forbidden
		- 404 - Not found		
		- 405 - Method not allowed
		- 500 - Internal Server Error
	- [ ] auth tests may be creating too many users in DB, find a solution to this		
	- [x] cleanup tests (remove repeatitive code)
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