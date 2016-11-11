# lumen gscp api 0.3.0
Building an open source game server control panel API with Lumen 5.3

### getting started
$ php -S localhost:8888 -t public

### mirgrating db
- $ php artisan migrate
- $ php artisan migrate -database=mysql-prod

### seeding db
1. $ composer dump-autoload
2. $ php artisan migrate:refresh
3. $ php artisan db:seed

### testing
$ phpunit --no-globals-backup

### testing alternative
$ php vendor/phpunit/phpunit/phpunit

## Changelog

### Authentication
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
- [x] test restricted routes [11/6/2016]
- [x] validation messages are still not verbose enough for front-end devs [11/6/2016]
- [x] improve validation error responses [11/7/2016]
- [ ] update tests to include roles & permissions

### Authors
- [x] run tests not in debug mode to see what responses are [11/5/2016]
- [x] make sure tests are passing for this as well	[11/5/2016]
- [x] validation messages are still not verbose enough for front-end devs 
[11/6/2016]
- [x] improve validation error responses [11/7/2016]
- [ ] come up with needed roles, permissions and apply to route middleware
- [ ] update tests to include test crud roles & permissions

### Books
- [x] run tests not in debug mode to see what responses are [11/5/2016]
- [x] make sure tests are passing for this as well	[11/5/2016]
- [x] validation messages are still not verbose enough for front-end devs [11/6/2016]
- [x] improve validation error responses [11/7/2016]
- [ ] come up with needed roles, permissions and apply to route middleware
- [ ] update tests to include roles & permissions

### Users
- [x] crud user
- [x] user roles (will have to create own middleware) [11/10/2016]
	- https://scotch.io/tutorials/role-based-authentication-in-laravel-with-jwt
	- https://github.com/Zizaco/entrust
	- https://lumen.laravel.com/docs/5.3/middleware
	- [ ] fork entrust and publish a package for lumen
	- [ ] possibly publish a boilerplate too
	- [ ] couple this with a blog post and share in related github issues/comments
- [ ] come up with needed roles, permissions and apply to route middleware
- [x] write tests [11/9/2016]
- [ ] update tests to include roles & permissions

### Servers
- [ ] crud server
- [ ] come up with needed roles
- [ ] come up with needed permissions
- [ ] ensure these are correctly applied to the routes
- [ ] write tests

### To Do
- [ ] remove or replace:
	- [ ] book migration
	- [ ] book seed
	- [ ] book model
	- [ ] book controller
	- [ ] book transformer
	- [ ] book factory
	- [ ] everything related to authors
- [x] add role & permission db seeds [11/11/2016]
- [ ] make sure I'm following API best practices refer to APIGEE manual (http://api.derp.com/v1/noun/verb/?params)

### Production/Remote
- [x] add test db
- [x] make sure remote uses production db
- [x] ability to migrate and seed the production db
- [x] test remote is working
	- [x] memcache removed temporarily, set to file
- [ ] look into security concerns with using JWT on client side
- [ ] setup cache
	- [ ] confirm there is no issue with memcached 
	- [ ] may need php_memcache.dll and memcached service		
	- [ ] othewise switch to redis?	
- [ ] check that remote is still working
- [ ] put api in a subdomain	

### Issues
- [x] TestCase.php jwtAuthTest() method invalid headers [11/5/2016]
- [x] remove namespace from routes.php [11/8/2016]
- [x] debug issues with entrust [11/11/2016]