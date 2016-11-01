<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use JWTAuth;
use TestCase;

class AuthControllerTest extends TestCase
{
  // use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = '/v1/auth';

  /** @test **/
  public function auth_index_should_error_when_no_token()
  {
    echo "\n\r{$this->green}Auth Controller Tests:";
    echo "\n\r{$this->yellow}    Auth index should error when no token...";

    $this->assertTokenNotProvided('get', $this->url);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_user_should_error_when_no_token()
  {
    echo "\n\r{$this->yellow}    Auth user should error when no token...";

    $this->assertTokenNotProvided('get', $this->url . '/user');

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_refresh_should_error_when_no_token()
  {
    echo "\n\r{$this->yellow}    Auth refresh should error when no token...";

    $this->assertTokenNotProvided('patch', $this->url . '/refresh');

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalidate_should_error_when_no_token()
  {
    echo "\n\r{$this->yellow}    Auth invalidate should error when no token...";

    $this->assertTokenNotProvided('delete', $this->url . '/invalidate');

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
    $this->assertEquals('invalid_credentials', $body['error']['message']);

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
    $this->assertArrayHasKey('success', $body);
    $this->assertArrayHasKey('message', $body['success']);
    $this->assertArrayHasKey('token', $body['success']);
    $this->assertEquals('token_generated', $body['success']['message']);

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
      $this->assertEquals('token_invalid', $body['error']['message']);
      $this->seeStatusCode(400);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_index_should_return_version_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth index should return version when using a valid token...";

    $body = $this->jwtAuthTest('get', $this->url);

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('message', $body);
    $this->assertEquals('Lumen (5.3.1) (Laravel Components 5.3.*)', $body['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_refresh_should_return_jwt_token_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth refresh should return jwt token when using a valid token...";

    $body = $this->jwtAuthTest('patch', $this->url . '/refresh');

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('message', $body);
    $this->assertArrayHasKey('token', $body);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalidate_should_delete_jwt_token_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth invalidate should delete jwt token when using a valid token...";

    $body = $this->jwtAuthTest('delete', $this->url . '/invalidate');

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('message', $body);
    $this->assertEquals('token_invalidated', $body['message']);

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
    $this->assertEquals('token_not_provided', $body['error']['message']);
    $this->seeStatusCode(400);
  }

  private function jwtAuthTest($method, $url)
  {
    $user = $this->userFactory();

    $token = JWTAuth::fromUser($user);
    JWTAuth::setToken($token);
    $headers = array(
      "Accept"        => "application/json",
      "Authorization" => "Bearer " . $token,
    );

    switch ($method) {
      case 'get':
        $this->get($url, [], $headers);
        break;
      case 'post':
        $this->post($url, [], $headers);
        break;
      case 'put':
        $this->put($url, [], $headers);
        break;
      case 'patch':
        $this->patch($url, [], $headers);
        break;
      case 'delete':
        $this->delete($url, [], $headers);
        break;
    }

    $body = json_decode($this->response->getContent(), true);

    return $body;
  }

}
