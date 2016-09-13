<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

use TestCase;

class BooksControllerTest extends TestCase
{

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function index_status_code_should_be_200()
  {

    echo "\n\r{$this->yellow}It should see JSON...";

    $this
      ->get('/v1/books')
      ->seeJson([
        'title' => 'War of the Worlds',
      ])
      ->seeJson([
        'title' => 'A Wrinkle in Time',
      ]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function show_should_return_a_valid_book()
  {
    $this->markTestIncomplete('Pending test');
  }

  /** @test **/
  public function show_should_fail_when_the_book_id_does_not_exist()
  {
    $this->markTestIncomplete('Pending test');
  }

  public function show_route_should_not_match_an_invalid_route()
  {
    $this->markTestIncomplete('Pending test');
  }
}
