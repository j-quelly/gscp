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
  private $path   = '/v1/auth';

  /** @test **/
  public function auth_should_error_when_no_token()
  {
    echo "\n\r{$this->green}Auth Controller Tests:";
    echo "\n\r{$this->yellow}    Auth should error when no token...";

    $this->get($this->path, [], ['Accept' => 'application/json']);

    $this->assertTokenNotProvided();

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_user_should_error_when_no_token()
  {
    echo "\n\r{$this->yellow}    Auth user should error when no token...";

    $this->get($this->path . '/user', [], ['Accept' => 'application/json']);

    $this->assertTokenNotProvided();

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_refresh_should_error_when_no_token()
  {
    echo "\n\r{$this->yellow}    Auth refresh should error when no token...";

    $this->patch($this->path . '/refresh', [], ['Accept' => 'application/json']);

    $this->assertTokenNotProvided();

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalidate_should_error_when_no_token()
  {
    echo "\n\r{$this->yellow}    Auth invalidate should error when no token...";

    $this->delete($this->path . '/invalidate', [], ['Accept' => 'application/json']);

    $this->assertTokenNotProvided();

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalid_login_should_return_an_error()
  {
    echo "\n\r{$this->yellow}    Auth invalid login should return an error ...";

    // Test unauthenticated access.
    $this->post($this->path . '/login', [
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
    echo "\n\r{$this->yellow}    Auth valid login should return a jwt ...";

    $user = $this->userFactory();

    $this->post($this->path . '/login', [
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
  public function auth_index_should_return_version_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth index should return version when using a valid token...";

    $user = $this->userFactory();

    $token = JWTAuth::fromUser($user);
    JWTAuth::setToken($token);
    $headers = array(
      "Accept"        => "application/json",
      "Authorization" => "Bearer " . $token,
    );

    $this->get($this->path, $headers);

    $body = json_decode($this->response->getContent(), true);

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('message', $body);
    $this->assertEquals('Lumen (5.3.1) (Laravel Components 5.3.*)', $body['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_refresh_should_return_jwt_token_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth refresh should return jwt token when using a valid token...";

    $user = $this->userFactory();

    $token = JWTAuth::fromUser($user);
    JWTAuth::setToken($token);
    $headers = array(
      "Accept"        => "application/json",
      "Authorization" => "Bearer " . $token,
    );

    $this->patch($this->path . '/refresh', [], $headers);

    $body = json_decode($this->response->getContent(), true);

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('message', $body);
    $this->assertArrayHasKey('token', $body);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_invalidate_should_delete_jwt_token_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth invalidate should delete jwt token when using a valid token...";

    $user = $this->userFactory();

    $token = JWTAuth::fromUser($user);
    JWTAuth::setToken($token);
    $headers = array(
      "Accept"        => "application/json",
      "Authorization" => "Bearer " . $token,
    );

    $this->delete($this->path . '/invalidate', [], $headers);

    $body = json_decode($this->response->getContent(), true);

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('message', $body);
    $this->assertEquals('token_invalidated', $body['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }  

  /**
   * Provides boilerplate test instructions for assertions.
   *
   */
  private function assertTokenNotProvided()
  {
    $body = json_decode($this->response->getContent(), true);

    $this->assertArrayHasKey('error', $body);
    $this->assertEquals('token_not_provided', $body['error']);
    $this->seeStatusCode(400);
  }



}
