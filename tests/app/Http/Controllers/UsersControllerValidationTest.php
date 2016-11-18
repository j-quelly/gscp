<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Support\Facades\Artisan as Artisan;
use TestCase;

class UsersControllerValidationTest extends TestCase
{
  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = "/v1/users";

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

  public function tearDown()
  {
    parent::tearDown();
  }

  /** @test **/
  public function it_validates_users_required_fields()
  {
    echo "\n\r{$this->green}Users Controller Validation Tests:";
    echo "\n\r{$this->yellow}    It validates required fields...";

    $tests = [
      ["method" => "post", "url" => $this->url],
      ["method" => "put", "url" => $this->url . "/1"],
    ];

    foreach ($tests as $test) {
      $this->assertInvalidData($test['method'], $test['url']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_validates_users_email_fields()
  {
    echo "\n\r{$this->yellow}    It validates users email...";

    $tests = [
      ["method" => "post", "url" => $this->url],
      ["method" => "put", "url" => $this->url . "/1"],
    ];

    $postData = [
      "email"    => "john",
      "password" => "12345678",
    ];

    foreach ($tests as $test) {
      $field = 'email';

      $data = $this->jwtAuthTest($test['method'], $test['url'], $postData, 'admin');

      $this->assertArrayHasKey($field, $data);
      $this->assertEquals(["The {$field} field must be a valid email."], $data[$field]);

    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_validates_users_email_length_when_too_long()
  {
    echo "\n\r{$this->yellow}    It validates users email length when too long...";

    $tests = [
      ["method" => "post", "url" => $this->url],
      ["method" => "put", "url" => $this->url . "/1"],
    ];

    $postData = [
      "email"    => str_random(256) . "@example.com",
      "password" => "12345678",
    ];

    foreach ($tests as $test) {
      $field = 'email';

      $data = $this->jwtAuthTest($test['method'], $test['url'], $postData, 'admin');

      $this->seeStatusCode(422);
      $this->assertArrayHasKey($field, $data);
      $this->assertEquals("The {$field} field must be less than 256 characters.", $data[$field][1]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_validates_users_email_length_when_long_enough()
  {
    echo "\n\r{$this->yellow}    It validates users email length when too long...";

    $tests = [
      ["method" => "post", "url" => $this->url],
      ["method" => "put", "url" => $this->url . "/1"],
    ];

    $postData = [
      "email"    => str_random(243) . "@example.com",
      "password" => "12345678",
    ];

    foreach ($tests as $test) {
      $field = 'email';

      $data = $this->jwtAuthTest($test['method'], $test['url'], $postData, 'admin');

      $this->seeStatusCode(422);
      $this->assertArrayHasKey($field, $data);
      $this->assertEquals(["The {$field} field must be a valid email."], $data[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

    /** @test **/
  public function user_validates_password_is_too_short()
  {
    echo "\n\r{$this->yellow}    It validates users password is too short...";

    $tests = [
      ["method" => "post", "url" => $this->url],
      ["method" => "put", "url" => $this->url . "/1"],
    ];

    $postData = [
      "email"    => str_random(243) . "@example.com",
      "password" => "1234567",
    ];

    foreach ($tests as $test) {
      $field = 'password';

      $data = $this->jwtAuthTest($test['method'], $test['url'], $postData, 'admin');

      $this->seeStatusCode(422); 
      $this->assertArrayHasKey($field, $data);
      $this->assertEquals(["The {$field} field must be more than 8 characters."], $data[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }  

  private function assertInvalidData($method, $url, $body = [])
  {

    $data = $this->jwtAuthTest($method, $url, $body, 'admin');

    $fields = ["email", "password"];

    foreach ($fields as $field) {
      $this->seeStatusCode(422);
      $this->assertArrayHasKey($field, $data);
      $this->assertEquals(["The {$field} field is required."], $data[$field]);
    }
  }

}
