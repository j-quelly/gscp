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
- [ ] add test db?
	- [x] using model factory atm
- [ ] authentication middleware
	- [ ] APPID
	- [ ] token
- [ ] remove/replace
	- [ ] hello middleware & additional routes
	- [ ] book migration
	- [ ] book seed
	- [ ] book model
	- [ ] book controller
- [ ] crud user
	- [ ] write tests
- [ ] crud server
	- [ ] write tests
- [x] map to remote