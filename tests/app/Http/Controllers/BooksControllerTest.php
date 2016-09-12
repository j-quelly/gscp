<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

use TestCase;

class BooksControllerTest extends TestCase
{
  /** @test **/
  public function index_status_code_should_be_200()
  {
    $this
      ->get('/v1/books')
      ->seeJson([
        'title' => 'War of the Worlds',
      ])
      ->seeJson([
        'title' => 'A Wrinkle in Time',
      ]);
  }
}
