<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

use JWTAuth;
// use Illuminate\Support\Facades\Artisan as Artisan;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthControllerTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = '/v1/auth';

  // public function setUp()
  // {
  //   parent::setUp();
  //   // Artisan::call('migrate');

  // }

  // public function tearDown()
  // {
  //   // Artisan::call('migrate:reset');
  //   parent::tearDown();
  // }

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
      // ['method' => 'get', 'url' => $this->url . '/user'],
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
    $this->assertEquals('Lumen (5.3.1) (Laravel Components 5.3.*)', $body['data']['message']);

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
