# GSCP
game server control panel API with Lumen 5.3

## server version 0.14.0

### getting started
$ php -S localhost:8888 -t public

### mirgrating db
- $ php artisan migrate
- $ php artisan migrate --database=mysql-staging
- $ php artisan migrate --database=mysql-prod

### seeding db
1. $ composer dump-autoload
2. $ php artisan migrate:refresh
3. $ php artisan db:seed or $ php artisan db:seed --database=mysql-prod

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
	- 422 - Unprocessable Entity
	- 500 - Internal Server Error
- [x] cleanup tests (remove repeatitive code)
- [x] test restricted routes [11/6/2016]
- [x] validation messages are still not verbose enough for front-end devs [11/6/2016]
- [x] improve validation error responses [11/7/2016]
- [x] remove GET /auth endpoint [11/12/2016]
- [x] update tests to include roles & permissions [11/13/2016]
- [x] improve new end point respones [11/13/2016]
- [x] add validation [11/13/2016]
	- [x] improved validation messages [11/14/2016]
- [x] add transformers for each new method [11/13/2016]
- [x] finish tests [11/16/2016]
- [x] adds better invalidate tests [11/21/2016]
- [x] adds more assertions [11/23/2016]
- [ ] will the role & permisison models need to be updated? - read more about models

### Users
- [x] crud user
- [x] user roles (will have to create own middleware) [11/10/2016]
	- https://scotch.io/tutorials/role-based-authentication-in-laravel-with-jwt
	- https://github.com/Zizaco/entrust
	- https://lumen.laravel.com/docs/5.3/middleware
	- [ ] fork entrust and publish a package for lumen
	- [ ] possibly publish a boilerplate too
	- [ ] couple this with a blog post and share in related github issues/comments
- [x] write tests [11/9/2016]
- [x] update tests to include roles & permissions [11/17/2016]
- [x] finish users validation tests [11/18/2016]
- [x] adds more assertions [11/23/2016]
- [ ] come up with needed roles, permissions and apply to route or controller middleware. 

### Servers
- [ ] crud server
- [ ] come up with needed roles
- [ ] come up with needed permissions
- [ ] ensure these are correctly applied to the routes
- [ ] write tests

### To Do
- [x] add role & permission db seeds [11/11/2016]
- [x] enable CORS with new middleware [8/26/2017]
- [x] disable CORS [8/27/2017]
- [ ] setup a local db to improve dev performance
- [ ] API should accept JSON & URI
- [ ] start documenting the API
- [ ] read the APIGEE manual and more API resources
	- [ ] Make responses more consistent & follow standard practice.  read more on this...
- [ ] remove or replace:
	- [ ] book migration
	- [ ] book seed
	- [ ] book model
	- [ ] book controller
	- [ ] book transformer
	- [ ] book factory
	- [ ] everything related to authors
- [x] generate new jwt token [11/22/2016]
- [ ] need a proper release cycle to stage and prod

### Remote
- [x] add test db
- [x] make sure remote uses production db
- [x] ability to migrate and seed the production db
- [x] test remote is working
	- [x] memcache removed temporarily, set to file
- [x] put api in a subdomain [11/18/2016]	
	- [x] check that remote is still working [11/18/2016]	
- [x] setup staging env [11/22/2016]	

### Issues
- [x] TestCase.php jwtAuthTest() method invalid headers [11/5/2016]
- [x] remove namespace from routes.php [11/8/2016]
- [x] debug issues with entrust [11/11/2016]
- [x] assigning roles has somehow broken... [11/15/2016]
- [x] there is an issue validating email length with all controllers [11/18/2016]
- [x] production is not parsing headers JWT token [11/21/2016]
- [x] token invalidate seems to not be working - https://github.com/tymondesigns/jwt-auth/issues/267 [11/22/2016]
- [x] some responses do not match the headers ie: 400 error saying 401 [11/23/2016]
- [x] set CACHE_DRIVER to array instead of redis until I learn how to setup redis caching [8/19/2017]

### Production 1.x.x
- [ ] setup cache w/ redis (may not need this for a long time)