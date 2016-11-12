<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$version = 'v1';

/**
 * Auth Public
 */

$app->group([
  'prefix' => $version . '/auth',
], function ($app) {
// Authentication route
  $app->post('/login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'api.auth.login']);
});

/**
 * Auth Restricted
 */
$app->group([
  'prefix'     => $version . '/auth',
  'middleware' => ['jwt.auth'],
], function ($app) {
  $app->get('/user', ['uses' => 'Auth\AuthController@getUser', 'as' => 'api.auth.user']);
  $app->patch('/refresh', ['uses' => 'Auth\AuthController@patchRefresh', 'as' => 'api.auth.refresh']);
  $app->delete('/invalidate', ['uses' => 'Auth\AuthController@deleteInvalidate', 'as' => 'api.auth.invalidate']);
});

/**
 * Roles/Permissions w/ Entrust
 */
$app->group([
  'prefix'     => $version . '/auth',
  'middleware' => ['jwt.auth', 'role:admin'],
], function ($app) {
// Route to create a new role
  $app->post('/role', 'Auth\AuthController@createRole');
// Route to create a new permission
  $app->post('/permission', 'Auth\AuthController@createPermission');
// Route to assign role to user
  $app->post('/assign-role', 'Auth\AuthController@assignRole');
// Route to attach permission to a role
  $app->post('/attach-permission', 'Auth\AuthController@attachPermission');
});

/**
 * Users Restricted
 */
$app->group([
  'prefix'     => $version . '/users',
  'middleware' => ['jwt.auth', 'role:admin'],
], function ($app) {
  $app->get('/', 'UsersController@index');
  $app->get('/{id:[\d]+}', ['as' => 'users.show', 'uses' => 'UsersController@show']);
  $app->post('/', 'UsersController@store');
  $app->put('/{id:[\d]+}', 'UsersController@update');
  $app->delete('/{id:[\d]+}', 'UsersController@destroy');
});

/**
 * Books Restricted
 */
$app->group([
  'prefix'     => $version . '/books',
  'middleware' => ['jwt.auth', 'role:admin'],
], function ($app) {
  $app->get('/', 'BooksController@index');
  $app->get('/{id:[\d]+}', ['as' => 'books.show', 'uses' => 'BooksController@show']);
  $app->put('/{id:[\d]+}', 'BooksController@update');
  $app->post('/', 'BooksController@store');
  $app->delete('/{id:[\d]+}', 'BooksController@destroy');
});

/**
 * Authors Restricted
 */
$app->group([
  'prefix'     => $version . '/authors',
  'middleware' => ['jwt.auth', 'role:admin'],
], function ($app) {
  $app->get('/', 'AuthorsController@index');
  $app->get('/{id:[\d]+}', ['as' => 'authors.show', 'uses' => 'AuthorsController@show']);
  $app->post('/', 'AuthorsController@store');
  $app->put('/{id:[\d]+}', 'AuthorsController@update');
  $app->delete('/{id:[\d]+}', 'AuthorsController@destroy');
});
