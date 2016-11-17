<?php

namespace Tests\App\Http\Controllers;
use Illuminate\Support\Facades\Artisan as Artisan;

use TestCase;

class AuthorsControllerValidationTest extends TestCase
{
  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = "/v1/authors";

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
  public function ac_validation_validates_required_fields()
  {
    echo "\n\r{$this->green}Authors Controller Validation Tests:";
    echo "\n\r{$this->yellow}    Validation validates required fields...";

    $author = factory(\App\Author::class)->create();
    $tests  = [
      ['method' => 'post', 'url' => $this->url],
      ['method' => 'put', 'url' => $this->url . "/{$author->id}"],
    ];

    $fields = ['name', 'gender', 'biography'];

    foreach ($tests as $test) {
      $method = $test['method'];
      $data   = $this->jwtAuthTest($method, $test['url'], [], 'admin');

      $this->seeStatusCode(422);

      foreach ($fields as $field) {
        $this->assertArrayHasKey($field, $data);
        $this->assertEquals(["The {$field} field is required."], $data[$field]);
      }
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function ac_validation_is_valid_when_name_is_just_long_enough()
  {
    echo "\n\r{$this->yellow}    Validation is valid when name is just long enough...";

    foreach ($this->getValidationTestData() as $test) {
      $method               = $test['method'];
      $test['data']['name'] = str_repeat('a', 255);
      $data                 = $this->jwtAuthTest($method, $test['url'], $test['data'], 'admin');
      $this->seeStatusCode($test['status']);
      $this->seeInDatabase('authors', $test['data']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function ac_store_returns_a_valid_location_header()
  {
    echo "\n\r{$this->yellow}    Store returns a valid location header...";

    $postData = [
      'name'      => 'H. G. Wells',
      'gender'    => 'male',
      'biography' => 'Prolific Science-Fiction Writer',
    ];

    $data = $this->jwtAuthTest('post', $this->url, $postData, 'admin');

    $this->seeStatusCode(201);
    $this->assertArrayHasKey('data', $data);
    $this->assertArrayHasKey('id', $data['data']);

    // Check the Location header
    $id = $data['data']['id'];
    $this->seeHeaderWithRegExp('Location', "#/authors/{$id}$#");

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function ac_validation_invalidates_incorrect_gender_data()
  {
    echo "\n\r{$this->yellow}    Validation invalidates incorrect gender data...";

    foreach ($this->getValidationTestData() as $test) {
      $method                 = $test['method'];
      $test['data']['gender'] = 'unknown';

      $data = $this->jwtAuthTest($method, $test['url'], $test['data'], 'admin');

      $this->seeStatusCode(422);

      $this->assertCount(1, $data);
      $this->assertArrayHasKey('gender', $data);
      $this->assertEquals(["Gender format is invalid: must equal 'male' or 'female'"], $data['gender']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function ac_validation_invalidates_name_when_name_is_just_too_long()
  {
    echo "\n\r{$this->yellow}    Validation invalidates name when name is just too long...";

    foreach ($this->getValidationTestData() as $test) {
      $method               = $test['method'];
      $test['data']['name'] = str_repeat('a', 256);

      $data = $this->jwtAuthTest($method, $test['url'], $test['data'], 'admin');

      $this->seeStatusCode(422);
      $this->assertCount(1, $data);
      $this->assertArrayHasKey('name', $data);
      $this->assertEquals(['The name field must be less than 256 characters.'], $data['name']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /**
   * Provides boilerplate test instructions for validation.
   * @return array
   */
  private function getValidationTestData()
  {
    $author = factory(\App\Author::class)->create();
    return [
      // Create
      [
        'method' => 'post',
        'url'    => $this->url,
        'status' => 201,
        'data'   => [
          'name'      => 'John Doe',
          'gender'    => 'male',
          'biography' => 'An anonymous author',
        ],
      ],

      // Update
      [
        'method' => 'put',
        'url'    => $this->url . "/{$author->id}",
        'status' => 200,
        'data'   => [
          'name'      => $author->name,
          'gender'    => $author->gender,
          'biography' => $author->biography,
        ],
      ],
    ];
  }

}
