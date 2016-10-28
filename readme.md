# lumen gscp api
Building an open source game server control panel API with Lumen 5.x

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
- [x] get routes working on remote
- [x] add logger middleware
- [x] begin writing tests
- [x] authentication middleware (JWT)
	- [x] restrict put post and delete endpoints
	- [ ] finish writing tests for auth
- [ ] add test db
- [ ] make sure remote uses production db
- [ ] ability to seed production db
- [ ] remove or replace
	- [x] hello middleware 
	- [x] hello routes
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
- [x] confirm use of APIController.php (index)