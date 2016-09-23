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

    echo "\n\r{$this->yellow}It should return a valid book...";

    $this
      ->get('/v1/books/1')
      ->seeStatusCode(200)
      ->seeJson([
        'id'          => 1,
        'title'       => 'War of the Worlds',
        'description' => 'A science fiction masterpiece about Martians invading London',
        'author'      => 'H. G. Wells',
      ]);

    $data = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('created_at', $data);
    $this->assertArrayHasKey('updated_at', $data);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

/** @test **/
  public function show_should_fail_when_the_book_id_does_not_exist()
  {
    
    echo "\n\r{$this->yellow}It should fail when the book id does not exist...";

    $this
      ->get('/v1/books/99999')
      ->seeStatusCode(404)
      ->seeJson([
        'error' => [
          'message' => 'Book not found',
        ],
      ]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function show_route_should_not_match_an_invalid_route()
  {
    echo "\n\r{$this->yellow}It should not match an invalid route...";

    $this->get('/v1/books/this-is-invalid');

    $this->assertNotRegExp(
      '/Book not found/',
      $this->response->getContent(),
      'BooksController@show route matching when it should not.'
    );

    echo " {$this->green}[OK]{$this->white}\n\r"; 

  }
}
