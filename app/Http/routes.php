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

$app->get('/', function () use ($app) {
  return "Lumen RESTful API";
});

$app->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function ($app) {

  /*
   * Learning Lumen
   */
  $app->get('/books', 'BooksController@index');
  $app->get('/books/{id:[\d]+}', [
    'as'   => 'books.show',
    'uses' => 'BooksController@show',
  ]);
  $app->put('/books/{id:[\d]+}', 'BooksController@update');
  $app->post('/books', 'BooksController@store');
  $app->delete('/books/{id:[\d]+}', 'BooksController@destroy');

  /*
   * Old tutorial
   * - still better patterns IMO
   */
  $app->get('book', 'BookController@index');

  $app->get('book/{id}', 'BookController@getbook');

  $app->post('book', 'BookController@createBook');

  $app->put('book/{id}', 'BookController@updateBook');

  $app->delete('book/{id}', 'BookController@deleteBook');

  /*
   * Learning Lumen
   */
  $app->get('/hello/world', function () use ($app) {
    return "Hello world!";
  });

  $app->get('/hello/{name}', function ($name) use ($app) {
    return "Hello {$name}";
  });

  $app->get('/hello/{name}', ['middleware' => 'hello', function ($name) {
    return "Hello {$name}";
  }]);

});

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
