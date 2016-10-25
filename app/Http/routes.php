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

$app->group(['prefix' => $version, 'namespace' => 'App\Http\Controllers'], function ($app) {

// /*
  // * User
  // */

// // get all users
  // $app->get('user', function () {
  //     return 'get users from DB in JSON';
  // });

// // get single user
  // $app->get('user/{id}', function ($id) {
  //     return 'get single user {'.$id.'} from DB in JSON';
  // });

});

/*
 * Books
 */
$app->group(['prefix' => $version . '/books', 'namespace' => 'App\Http\Controllers'], function ($app) {
  $app->get('/', 'BooksController@index');
  $app->get('/{id:[\d]+}', [
    'as'   => 'books.show',
    'uses' => 'BooksController@show',
  ]);
  $app->put('/{id:[\d]+}', 'BooksController@update');
  $app->post('/', 'BooksController@store');
  $app->delete('/{id:[\d]+}', 'BooksController@destroy');
});

/*
 * Authors
 */
$app->group(['prefix' => $version . '/authors', 'namespace' => 'App\Http\Controllers'], function ($app) {
  $app->get('/', 'AuthorsController@index');
  $app->post('/', 'AuthorsController@store');
  $app->get('/{id:[\d]+}', [
    'as'   => 'authors.show',
    'uses' => 'AuthorsController@show',
  ]);
  $app->put('/{id:[\d]+}', 'AuthorsController@update');
  $app->delete('/{id:[\d]+}', 'AuthorsController@destroy');
});