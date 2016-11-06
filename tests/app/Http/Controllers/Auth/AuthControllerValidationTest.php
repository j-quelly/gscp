<?php

namespace tests\app\Http\Controllers;

use TestCase;

class AuthControllerValidationTest extends TestCase
{
  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = '/v1/auth';

  /** @test **/
  public function auth_validation_validates_required_fields()
  {
    echo "\n\r{$this->green}Auth Controller Validation Tests:";
    echo "\n\r{$this->yellow}    Auth validation validates required fields...";

    $this->post($this->url . '/login', [], ['Accept' => 'application/json']);

    $body = $this->response->getData(true);

    $this->seeStatusCode(400);
    $this->assertArrayHasKey('error', $body);
    $this->assertArrayHasKey('message', $body['error']);
    $this->assertEquals('The given data failed to pass validation.', $body['error']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_login_is_invalid_when_no_password()
  {
    echo "\n\r{$this->yellow}    Auth login is invalid when no password...";

    // create user
    $user = $this->userFactory();

    $this->post($this->url . '/login', [
      'email'    => $user->email,
      'password' => '',
    ], ['Accept' => 'application/json']);

    $body = $this->response->getData(true);

    $this->seeStatusCode(400);
    $this->assertArrayHasKey('error', $body);
    $this->assertArrayHasKey('message', $body['error']);
    $this->assertEquals('The given data failed to pass validation.', $body['error']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_login_is_valid_when_email_is_just_long_enough()
  {
    echo "\n\r{$this->yellow}    Auth login is valid when email is just long enough...";

    // create user
    $user = factory(\App\User::class, 1)->create(['email' => 'jamie@' . $this->generateRandomString(63) . '.com', 'password' => app('hash')->make('supersecret')]);

    $this->post($this->url . '/login', [
      'email'    => $user->email,
      'password' => 'supersecret',
    ], ['Accept' => 'application/json']);

    $body = $this->response->getData(true);

    $this->seeStatusCode(200);
    $this->assertArrayHasKey('data', $body);
    $this->assertArrayHasKey('message', $body['data']);
    $this->assertArrayHasKey('token', $body['data']);
    $this->assertEquals('Token generated', $body['data']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_login_is_invalid_when_email_is_invalid()
  {
    echo "\n\r{$this->yellow}    Auth login is invalid when email is invalid...";

    $this->post($this->url . '/login', [
      'email'    => 'jerpaderp',
      'password' => 'supersecret',
    ], ['Accept' => 'application/json']);

    $body = $this->response->getData(true);

    $this->seeStatusCode(400);
    $this->assertArrayHasKey('error', $body);
    $this->assertArrayHasKey('message', $body['error']);
    $this->assertEquals('The given data failed to pass validation.', $body['error']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_login_is_invalid_when_email_is_too_long()
  {
    echo "\n\r{$this->yellow}    Auth login is invalid when email is too long...";

    // create user
    $user = factory(\App\User::class, 1)->create(['email' => 'jamie@' . $this->generateRandomString(64) . '.com', 'password' => app('hash')->make('supersecret')]);

    $this->post($this->url . '/login', [
      'email'    => $user->email,
      'password' => 'supersecret',
    ], ['Accept' => 'application/json']);

    $body = $this->response->getData(true);

    $this->seeStatusCode(400);
    $this->assertArrayHasKey('error', $body);
    $this->assertArrayHasKey('message', $body['error']);
    $this->assertEquals('The given data failed to pass validation.', $body['error']['message']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  private function generateRandomString($length = 10)
  {
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

}
