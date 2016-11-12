<?php

namespace tests\app\Http\Controllers;

use Illuminate\Support\Facades\Artisan as Artisan;
use JWTAuth;
use TestCase;

class AuthControllerTest extends TestCase
{
  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = '/v1/auth';

  /**
   * Disclaimer:
   * the "right" way to do testing, that gives you the greatest
   * confidence your tests methods don't get subtly interdependent in
   * bug-hiding ways, is to re-seed your db before every test method, so
   * just put seeding code in plain setUp if you can afford the
   * performance penalty
   */

  protected static $dbInitiated = false;

  protected static function initDB()
  {
    echo "\n\r\e[0;31mRefreshing the database...\n\r";
    Artisan::call('migrate:refresh');
    Artisan::call('db:seed');
  }

  public function setUp()
  {
    parent::setUp();

    if (!static::$dbInitiated) {
      static::$dbInitiated = true;
      static::initDB();
    }
  }

  /** @test **/
  public function auth_should_error_when_no_token()
  {
    echo "\n\r{$this->green}Auth Controller Tests:";
    echo "\n\r{$this->yellow}    Auth should error when no token...";

    $tests = [
      ['method' => 'get', 'url' => $this->url],
      ['method' => 'patch', 'url' => $this->url . '/refresh'],
      ['method' => 'delete', 'url' => $this->url . '/invalidate'],
      ['method' => 'get', 'url' => $this->url . '/user'],
      ['method' => 'post', 'url' => $this->url . '/role'],
      ['method' => 'post', 'url' => $this->url . '/permission'],
      ['method' => 'post', 'url' => $this->url . '/assign-role'],
      ['method' => 'post', 'url' => $this->url . '/role'],
    ];

    foreach ($tests as $test) {
      $this->assertTokenNotProvided($test['method'], $test['url']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_should_error_when_using_an_invalid_token()
  {
    echo "\n\r{$this->yellow}    Auth should error when using an invalid token...";

    $tests = [
      ['method' => 'get', 'url' => $this->url],
      ['method' => 'patch', 'url' => $this->url . '/refresh'],
      ['method' => 'delete', 'url' => $this->url . '/invalidate'],
      ['method' => 'get', 'url' => $this->url . '/user'],
    ];

    foreach ($tests as $test) {
      $token = '1232123.123213.123123';
      JWTAuth::setToken($token);
      $headers = array(
        "Accept"        => "application/json",
        "Authorization" => "Bearer " . $token,
      );
      $method = $test['method'];
      $this->{$method}($test['url'], [], $headers);
      $body = json_decode($this->response->getContent(), true);
      $this->assertArrayHasKey('error', $body);
      $this->assertEquals('Token invalid', $body['error']['message']);
      $this->seeStatusCode(400);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalid_login_should_return_an_error()
  {
    echo "\n\r{$this->yellow}    Auth invalid login should return an error ...";

    // Test unauthenticated access.
    $this->post($this->url . '/login', [
      'email'    => 'email@domain.com',
      'password' => 'supersecret',
    ], ['Accept' => 'application/json']);

    $body = json_decode($this->response->getContent(), true);

    $this->seeStatusCode(401);
    $this->assertArrayHasKey('error', $body);
    $this->assertArrayHasKey('message', $body['error']);
    $this->assertEquals('Invalid credentials', $body['error']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_valid_login_should_return_a_jwt()
  {
    echo "\n\r{$this->yellow}    Auth valid login should return a token ...";

    $user = $this->userFactory();

    $this->post($this->url . '/login', [
      'email'    => $user->email,
      'password' => 'supersecret',
    ], ['Accept' => 'application/json']);

    $body = json_decode($this->response->getContent(), true);

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('data', $body);
    $this->assertArrayHasKey('message', $body['data']);
    $this->assertArrayHasKey('token', $body['data']);
    $this->assertEquals('Token generated', $body['data']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_index_should_return_version_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth index should return version when using a valid token...";

    $body = $this->jwtAuthTest('get', $this->url);

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('data', $body);
    $this->assertArrayHasKey('message', $body['data']);
    $this->assertEquals('Lumen (5.3.2) (Laravel Components 5.3.*)', $body['data']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_refresh_should_return_jwt_token_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth refresh should return jwt token when using a valid token...";

    $body = $this->jwtAuthTest('patch', $this->url . '/refresh');

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('data', $body);
    $this->assertArrayHasKey('message', $body['data']);
    $this->assertArrayHasKey('token', $body['data']);
    $this->assertEquals('Token refreshed', $body['data']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalidate_should_delete_jwt_token_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth invalidate should delete jwt token when using a valid token...";

    $body = $this->jwtAuthTest('delete', $this->url . '/invalidate');

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('data', $body);
    $this->assertArrayHasKey('message', $body['data']);
    $this->assertEquals('Token invalidated', $body['data']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalid_users_are_restricted_from_private_routes()
  {
    echo "\n\r{$this->yellow}    Invalid users are restricted from private routes...";

    $tests = [
      ['method' => 'get', 'url' => '/v1/users'],
      ['method' => 'get', 'url' => '/v1/users/1'],
      ['method' => 'post', 'url' => '/v1/users'],
      ['method' => 'put', 'url' => '/v1/users/1'],
      ['method' => 'delete', 'url' => '/v1/users/1'],

      ['method' => 'get', 'url' => '/v1/books'],
      ['method' => 'get', 'url' => '/v1/books/1'],
      ['method' => 'post', 'url' => '/v1/books'],
      ['method' => 'put', 'url' => '/v1/books/1'],
      ['method' => 'delete', 'url' => '/v1/books/1'],

      ['method' => 'get', 'url' => '/v1/authors'],
      ['method' => 'get', 'url' => '/v1/authors/1'],
      ['method' => 'post', 'url' => '/v1/authors'],
      ['method' => 'put', 'url' => '/v1/authors/1'],
      ['method' => 'delete', 'url' => '/v1/authors/1'],
    ];

    foreach ($tests as $test) {
      $this->assertTokenNotProvided($test['method'], $test['url']);
      echo "\n\r        {$this->green}{$test['url']}{$this->white}";
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /**
   * Provides boilerplate test instructions for assertions.
   *
   */
  private function assertTokenNotProvided($method, $url)
  {
    switch ($method) {
      case 'get':
        $this->get($url, [], ['Accept' => 'application/json']);
        break;
      case 'post':
        $this->post($url, [], ['Accept' => 'application/json']);
        break;
      case 'put':
        $this->put($url, [], ['Accept' => 'application/json']);
        break;
      case 'patch':
        $this->patch($url, [], ['Accept' => 'application/json']);
        break;
      case 'delete':
        $this->delete($url, [], ['Accept' => 'application/json']);
        break;
    }

    $body = json_decode($this->response->getContent(), true);

    $this->assertArrayHasKey('error', $body);
    $this->assertEquals('Token not provided', $body['error']['message']);
    $this->seeStatusCode(400);
  }

}
