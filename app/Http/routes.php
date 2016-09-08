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

$app->get('/', function() use ($app) {
    return "Lumen RESTful API By CoderExample (https://coderexample.com)";
});
 
$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function($app)
{
    $app->get('book','BookController@index');
  
    $app->get('book/{id}','BookController@getbook');
      
    $app->post('book','BookController@createBook');
      
    $app->put('book/{id}','BookController@updateBook');
      
    $app->delete('book/{id}','BookController@deleteBook');
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