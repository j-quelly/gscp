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

    $fields = ["email", "password"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field is required."], $body[$field]);
    }

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

    $fields = ["password"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field is required."], $body[$field]);
    }

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

    $fields = ["email"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field must be a valid {$field}."], $body[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  // TODO: check this test is working correctly..
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

    $fields = ["email"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field must be a valid {$field}."], $body[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  // TODO: pull this out into validation tests
  /** @test **/
  public function auth_attach_permission_should_not_attach_invalid_permission_to_role()
  {
    echo "\n\r{$this->yellow}    Auth attach permissions should not attach invalid permission to role when using a valid token...";

    // try to attach non-existent permissions
    $attachPermissionData = ["name" => "sports", "role" => "not-a-role"];

    $body = $this->jwtAuthTest('post', $this->url . '/attach-permission', $attachPermissionData, 'admin');

    $this->seeStatusCode(422);
    $this->assertEquals('validation.exists', $body['role'][0]);
    $this->assertEquals('validation.exists', $body['name'][0]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  // TODO: pull this out into validation tests...
  /** @test **/
  public function auth_assign_role_should_not_assign_invalid_role_to_user_when_using_a_valid_token()
  {
    echo "\n\r{$this->yellow}    Auth assign role should assign an invalid role to a user when using a valid token...";

    // try to assign non-existent role
    $assignRoleData = ["email" => "johndoe@example.com", "role" => "not-a-role"];

    $body = $this->jwtAuthTest('post', $this->url . '/assign-role', $assignRoleData, 'admin');

    $this->seeStatusCode(422);
    $this->assertEquals('validation.exists', $body['role'][0]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_validation_validates_required_role_fields()
  {
    echo "\n\r{$this->yellow}    Auth validation validates fields when creating a role...";

    $body = $this->jwtAuthTest('post', $this->url . '/role', [], 'admin');

    $fields = ["name", "display_name", "description"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field is required."], $body[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_validation_validates_required_permission_fields()
  {
    echo "\n\r{$this->yellow}    Auth validation validates fields when creating permissions...";

    $body = $this->jwtAuthTest('post', $this->url . '/permission', [], 'admin');

    $fields = ["name", "display_name", "description"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field is required."], $body[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_assign_role_invalid_when_email_is_invalid()
  {
    echo "\n\r{$this->yellow}    Auth assign role is invalid when email is invalid...";

    $postData = [
      "email" => "jerpaderp",
      "role" => "admin"
    ];

   $body = $this->jwtAuthTest('post', $this->url . '/assign-role', $postData, 'admin');

    $fields = ["email"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field must be a valid {$field}."], $body[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_assign_role_is_invalid_when_email_is_too_long()
  {
    echo "\n\r{$this->yellow}    Auth assign role is invalid when email is too long...";

    $postData = [
      "email" => "jamie@" . $this->generateRandomString(64) . ".com",
      "role" => "admin"
    ];

   $body = $this->jwtAuthTest('post', $this->url . '/assign-role', $postData, 'admin');

    $fields = ["email"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field must be a valid {$field}."], $body[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function auth_attach_permission_validates_required_fields()
  {
    echo "\n\r{$this->yellow}    Auth attach permission validates required fields...";

    $body = $this->jwtAuthTest('post', $this->url . '/attach-permission', [], 'admin');

    $fields = ["name", "role"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $body);
      $this->assertEquals(["The {$field} field is required."], $body[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  private function generateRandomString($length = 10)
  {
    $characters       = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

}
