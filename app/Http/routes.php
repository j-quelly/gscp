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

$app->get('/', function () use ($app) {
  return "Lumen RESTful API";
});

$app->group(['prefix' => $version, 'namespace' => 'App\Http\Controllers'], function ($app) {

  /*
   * Books
   */
  $app->get('/books', 'BooksController@index');
  $app->get('/books/{id:[\d]+}', [
    'as'   => 'books.show',
    'uses' => 'BooksController@show',
  ]);
  $app->put('/books/{id:[\d]+}', 'BooksController@update');
  $app->post('/books', 'BooksController@store');
  $app->delete('/books/{id:[\d]+}', 'BooksController@destroy');

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
   * Authors
   */
  $app->group(['prefix' => $version.'/authors', 'namespace' => 'App\Http\Controllers'], function ($app) {
    $app->get('/', 'AuthorsController@index');
    $app->post('/', 'AuthorsController@store');
    $app->get('/{id:[\d]+}', 'AuthorsController@show');
    $app->put('/{id:[\d]+}', 'AuthorsController@update');
    $app->delete('/{id:[\d]+}', 'AuthorsController@destroy');
  });


