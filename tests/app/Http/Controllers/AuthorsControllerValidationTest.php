<?php

namespace Tests\App\Http\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthorsControllerValidationTest extends TestCase
{
  // use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = "/v1/authors";

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

    foreach ($tests as $test) {
      $method = $test['method'];
      $data   = $this->jwtAuthTest($method, $test['url']);
      $this->seeStatusCode(400);
      $this->assertArrayHasKey('error', $data);
      $this->assertArrayHasKey('message', $data['error']);
      $this->assertArrayHasKey('status', $data['error']);
      $this->assertEquals('The given data failed to pass validation.', $data['error']['message']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function validation_is_valid_when_name_is_just_long_enough()
  {
    echo "\n\r{$this->yellow}    Validation is valid when name is just long enough...";

    foreach ($this->getValidationTestData() as $test) {
      $method               = $test['method'];
      $test['data']['name'] = str_repeat('a', 255);
      $data                 = $this->jwtAuthTest($method, $test['url'], $test['data']);
      $this->seeStatusCode($test['status']);
      $this->seeInDatabase('authors', $test['data']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function store_returns_a_valid_location_header()
  {
    echo "\n\r{$this->yellow}    Store returns a valid location header...";

    $postData = [
      'name'      => 'H. G. Wells',
      'gender'    => 'male',
      'biography' => 'Prolific Science-Fiction Writer',
    ];

    $data = $this->jwtAuthTest('post', $this->url, $postData);

    $this->seeStatusCode(201);
    $this->assertArrayHasKey('data', $data);
    $this->assertArrayHasKey('id', $data['data']);

    // Check the Location header
    $id = $data['data']['id'];
    $this->seeHeaderWithRegExp('Location', "#/authors/{$id}$#");

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function validation_invalidates_incorrect_gender_data()
  {
    echo "\n\r{$this->yellow}    Validation invalidates incorrect gender data...";

    foreach ($this->getValidationTestData() as $test) {
      $method                 = $test['method'];
      $test['data']['gender'] = 'unknown';

      $data = $this->jwtAuthTest($method, $test['url'], $test['data']);

      $this->seeStatusCode(400);
      $this->assertCount(1, $data);
      $this->assertArrayHasKey('error', $data);
      $this->assertArrayHasKey('message', $data['error']);
      $this->assertArrayHasKey('status', $data['error']);
      $this->assertEquals('The given data failed to pass validation.', $data['error']['message']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function validation_invalidates_name_when_name_is_just_too_long()
  {
    echo "\n\r{$this->yellow}    Validation invalidates name when name is just too long...";

    foreach ($this->getValidationTestData() as $test) {
      $method               = $test['method'];
      $test['data']['name'] = str_repeat('a', 256);

      $data = $this->jwtAuthTest($method, $test['url'], $test['data']);

      $this->seeStatusCode(400);
      $this->assertCount(1, $data);
      $this->assertArrayHasKey('error', $data);
      $this->assertArrayHasKey('message', $data['error']);
      $this->assertArrayHasKey('status', $data['error']);
      $this->assertEquals('The given data failed to pass validation.', $data['error']['message']);}

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
