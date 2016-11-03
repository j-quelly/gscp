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
	- [x] refactor auth tests again (remove repeatitive code)
	- [x] test invalid token	
	- [x] test validation
	- [x] auth controller should return data in the same format as other controllers
	- [x] work on status codes
		- 200 - OK
		- 201 - Created
		- 304 - Not modified
		- 400 - Bad Request
		- 401 - Unauthorized
		- 403 - Forbidden
		- 404 - Not found		
		- 405 - Method not allowed
		- 500 - Internal Server Error
	- [x] cleanup tests (remove repeatitive code)
	- [ ] find a way to mock user authentication 
- [x] add test db
- [x] make sure remote uses production db
- [x] ability to migrate and seed the production db
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
- [x] test remote is working
	- [x] memcache removed temporarily, set to file
- [ ] look into security concerns with using JWT on client side
- [ ] setup cache
	- [ ] confirm there is no issue with memcached 
			- [ ] may need php_memcache.dll and memcached service		
	- [ ] othewise switch to redis?
- [ ] remove or replace
	- [ ] book migration
	- [ ] book seed
	- [ ] book model
	- [ ] book controller
	- [ ] book transformer
	- [ ] book factory
	- [ ] everything related to authors