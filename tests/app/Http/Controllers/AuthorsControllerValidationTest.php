<?php

namespace Tests\App\Http\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthorsControllerValidationTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function validation_validates_required_fields()
  {
    echo "\n\r{$this->green}Authors Controller Validation Tests:";
    echo "\n\r{$this->yellow}    Validation validates required fields...";

    $author = factory(\App\Author::class)->create();
    $tests  = [
      ['method' => 'post', 'url' => '/v1/authors'],
      ['method' => 'put', 'url' => "/v1/authors/{$author->id}"],
    ];

    foreach ($tests as $test) {
      $method = $test['method'];
      $this->{$method}($test['url'], [], ['Accept' => 'application/json']);
      $this->seeStatusCode(400);
      $data = $this->response->getData(true);
      $body = $data['error']['debug']['trace'][1]['args'][1];

      $fields = ['biography'];

      foreach ($fields as $field) {
        $this->assertArrayHasKey($field, $body);
        $this->assertEquals("required", $body[$field]);
      }

      // test name field
      $name = $data['error']['debug']['trace'][1]['args'][1];
      $this->assertArrayHasKey('name', $name);
      $this->assertEquals("required|max:255", $name['name']);

      // test gender field
      $gender       = $data['error']['debug']['trace'][1]['args'][1];
      $genderErrMsg = $data['error']['debug']['trace'][1]['args'][2];
      $this->assertArrayHasKey('gender', $gender);
      $this->assertEquals("required", $gender['gender'][0]);
      $this->assertEquals("Gender format is invalid: must equal 'male' or 'female'", $genderErrMsg['gender.regex']);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function validation_is_valid_when_name_is_just_long_enough()
  {
    echo "\n\r{$this->yellow}    Store is valid when name is just long enough...";

    foreach ($this->getValidationTestData() as $test) {
      $method               = $test['method'];
      $test['data']['name'] = str_repeat('a', 255);

      $this->{$method}($test['url'], $test['data'], ['Accept' => 'application/json']);

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

    $this
      ->post('/v1/authors', $postData,
        ['Accept' => 'application/json'])
      ->seeStatusCode(201);

    $data = $this->response->getData(true);
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
      $this->{$method}($test['url'], $test['data'], ['Accept' => 'application/json']);

      $this->seeStatusCode(400);

      $data = $this->response->getData(true);
      $data = $data['error']['debug']['trace'][1]['args'][2];

      $this->assertCount(1, $data);
      $this->assertArrayHasKey('gender.regex', $data);
      $this->assertEquals("Gender format is invalid: must equal 'male' or 'female'", $data['gender.regex']);
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

      $this->{$method}($test['url'], $test['data'], ['Accept' => 'application/json']);

      $this->seeStatusCode(400);

      $data = $this->response->getData(true);
      $data = $data['error']['debug']['trace'][1]['args'][1];

      $this->assertCount(3, $data);
      $this->assertArrayHasKey('name', $data);
      $this->assertEquals("required|max:255", $data['name']);
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
        'url'    => '/v1/authors',
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
        'url'    => "/v1/authors/{$author->id}",
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
