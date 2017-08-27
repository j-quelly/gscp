<?php

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require_once __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}

/*
|--------------------------------------------------------------------------
| Load your environment file
|--------------------------------------------------------------------------
|
| You know, to load your environment file.
*/

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
 */

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->withFacades();

class_exists(JWTAuth::class) or class_alias(Tymon\JWTAuth\Facades\JWTAuth::class, JWTAuth::class);
class_exists(JWTFactory::class) or class_alias(Tymon\JWTAuth\Facades\JWTFactory::class, JWTFactory::class);

// role-based auth w/ entrust
class_exists(EntrustFacade::class) or class_alias(Zizaco\Entrust\EntrustFacade::class, EntrustFacade::class);

$app->withEloquent();


/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
 */

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Routing\ResponseFactory::class,
    Illuminate\Routing\ResponseFactory::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
 */

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->middleware([
    App\Http\Middleware\RequestLogMiddleware::class,
    // \Barryvdh\Cors\HandleCors::class,
]);

$app->routeMiddleware([
    // 'hello' => App\Http\Middleware\HelloMiddleware::class,
    // 'auth' => App\Http\Middleware\Authenticate::class,
    'jwt.auth'    => App\Http\Middleware\GetUserFromToken::class,
    'jwt.refresh' => Tymon\JWTAuth\Middleware\RefreshToken::class,    
    'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,
    'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class 
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
 */

// JWTAuth Dependency
$app->configure('session');
$app->register(Illuminate\Session\SessionServiceProvider::class);
$app->register(Illuminate\Cookie\CookieServiceProvider::class);
$app->register(Illuminate\Cache\CacheServiceProvider::class);

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class); 
// $app->register(App\Providers\GuardServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(\App\Providers\FractalServiceProvider::class);

// JWTAuth
$app->configure('jwt');
$app->register(Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class);

$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);

// role-based auth w/ entrust
$app->configure('auth');
$app->register(Zizaco\Entrust\EntrustServiceProvider::class);

// redis cache
$app->configure('database');
$app->register(Illuminate\Redis\RedisServiceProvider::class);

// enable CORS
// $app->configure('cors');
// $app->register(Barryvdh\Cors\ServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
 */

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__ . '/../app/Http/routes.php';
});

return $app;
