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
  public function store_method_validates_required_fields()
  {
    echo "\n\r{$this->green}Authors Controller Validation Tests:";
    echo "\n\r{$this->yellow}    Store method validates required fields...";  	

    $this->post('/v1/authors', [],
      ['Accept' => 'application/json']);

    $data = $this->response->getData(true);

    $fields = ['name', 'gender', 'biography'];

    $data = $data['error']['debug']['trace'][1]['args'][1];

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $data);
      $this->assertEquals("required", $data[$field]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

}
