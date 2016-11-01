<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use JWTAuth;
use TestCase;

class AuthControllerValidationTest extends TestCase
{
  // use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $path   = '/v1/auth';

  // /** @test **/
  // public function auth_index_should_error_when_no_token()
  // {
  //   echo "\n\r{$this->green}Auth Controller Tests:";
  //   echo "\n\r{$this->yellow}    Auth index should error when no token...";

  //   $this->assertTokenNotProvided('get', $this->path);

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // }

  // /** @test **/
  // public function auth_user_should_error_when_no_token()
  // {
  //   echo "\n\r{$this->yellow}    Auth user should error when no token...";

  //   $this->assertTokenNotProvided('get', $this->path . '/user');

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // }

  // /** @test **/
  // public function auth_refresh_should_error_when_no_token()
  // {
  //   echo "\n\r{$this->yellow}    Auth refresh should error when no token...";

  //   $this->assertTokenNotProvided('patch', $this->path . '/refresh');

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // }

  // /** @test **/
  // public function auth_invalidate_should_error_when_no_token()
  // {
  //   echo "\n\r{$this->yellow}    Auth invalidate should error when no token...";

  //   $this->assertTokenNotProvided('delete', $this->path . '/invalidate');

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // }

  // /** @test **/
  // public function auth_invalid_login_should_return_an_error()
  // {
  //   echo "\n\r{$this->yellow}    Auth invalid login should return an error ...";

  //   // Test unauthenticated access.
  //   $this->post($this->path . '/login', [
  //     'email'    => 'email@domain.com',
  //     'password' => 'supersecret',
  //   ], ['Accept' => 'application/json']);

  //   $body = json_decode($this->response->getContent(), true);

  //   $this->seeStatusCode(401);
  //   $this->assertArrayHasKey('error', $body);
  //   $this->assertArrayHasKey('message', $body['error']);
  //   $this->assertEquals('invalid_credentials', $body['error']['message']);

  //   echo " {$this->green}[OK]{$this->white}\n\r"; 
  // }

  // /** @test **/
  // public function auth_valid_login_should_return_a_jwt()
  // {
  //   echo "\n\r{$this->yellow}    Auth valid login should return a token ...";

  //   $user = $this->userFactory();

  //   $this->post($this->path . '/login', [
  //     'email'    => $user->email,
  //     'password' => 'supersecret',
  //   ], ['Accept' => 'application/json']);

  //   $body = json_decode($this->response->getContent(), true);

  //   $this->seeStatusCode(200);
  //   $this->assertArrayHasKey('success', $body);
  //   $this->assertArrayHasKey('message', $body['success']);
  //   $this->assertArrayHasKey('token', $body['success']);
  //   $this->assertEquals('token_generated', $body['success']['message']);

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // } 

  // /** @test **/
  // public function auth_index_should_return_version_when_using_a_valid_token()
  // {
  //   echo "\n\r{$this->yellow}    Auth index should return version when using a valid token...";

  //   $body = $this->jwtAuthTest('get', $this->path);

  //   $this->seeStatusCode(200);
  //   $this->assertArrayHasKey('message', $body);
  //   $this->assertEquals('Lumen (5.3.1) (Laravel Components 5.3.*)', $body['message']);

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // }

  // /** @test **/
  // public function auth_refresh_should_return_jwt_token_when_using_a_valid_token()
  // {
  //   echo "\n\r{$this->yellow}    Auth refresh should return jwt token when using a valid token...";

  //   $body = $this->jwtAuthTest('patch', $this->path . '/refresh');

  //   $this->seeStatusCode(200);
  //   $this->assertArrayHasKey('message', $body);
  //   $this->assertArrayHasKey('token', $body);

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // }

  // /** @test **/
  // public function auth_invalidate_should_delete_jwt_token_when_using_a_valid_token()
  // {
  //   echo "\n\r{$this->yellow}    Auth invalidate should delete jwt token when using a valid token...";

  //   $body = $this->jwtAuthTest('delete', $this->path . '/invalidate');

  //   $this->seeStatusCode(200);
  //   $this->assertArrayHasKey('message', $body);
  //   $this->assertEquals('token_invalidated', $body['message']);

  //   echo " {$this->green}[OK]{$this->white}\n\r";
  // }

  // /**
  //  * Provides boilerplate test instructions for assertions.
  //  *
  //  */
  // private function assertTokenNotProvided($verb, $path)
  // {
  //   switch ($verb) {
  //     case 'get':
  //       $this->get($path, [], ['Accept' => 'application/json']);
  //       break;
  //     case 'post':
  //       $this->post($path, [], ['Accept' => 'application/json']);
  //       break;
  //     case 'put':
  //       $this->put($path, [], ['Accept' => 'application/json']);
  //       break;
  //     case 'patch':
  //       $this->patch($path, [], ['Accept' => 'application/json']);
  //       break;
  //     case 'delete':
  //       $this->delete($path, [], ['Accept' => 'application/json']);
  //       break;
  //   }

  //   $body = json_decode($this->response->getContent(), true);

  //   $this->assertArrayHasKey('error', $body);
  //   $this->assertEquals('token_not_provided', $body['error']['message']);
  //   $this->seeStatusCode(400);
  // }

  private function jwtAuthTest($verb, $path)
  {
    $user = $this->userFactory();

    $token = JWTAuth::fromUser($user);
    JWTAuth::setToken($token);
    $headers = array(
      "Accept"        => "application/json",
      "Authorization" => "Bearer " . $token,
    );

    switch ($verb) {
      case 'get':
        $this->get($path, [], $headers);
        break;
      case 'post':
        $this->post($path, [], $headers);
        break;
      case 'put':
        $this->put($path, [], $headers);
        break;
      case 'patch': 
        $this->patch($path, [], $headers);
        break;
      case 'delete':
        $this->delete($path, [], $headers);
        break;
    }

    $body = json_decode($this->response->getContent(), true);

    return $body;
  }

}
