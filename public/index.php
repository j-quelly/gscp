<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

// TODO: these paths need to be set dynamically depending on the environment
// $app = require __DIR__.'/../../gscp-api-v1/bootstrap/app.php';
// $app = require __DIR__.'/../../gscp-api-staging/bootstrap/app.php';

// for local development
$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

// this causes a bug when the app lives in a sub-folder as the path will be incorrect
// $app->run();

$request = Illuminate\Http\Request::capture();
$app->run($request);
