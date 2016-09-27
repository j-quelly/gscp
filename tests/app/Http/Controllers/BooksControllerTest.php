<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

use TestCase;
// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use Laravel\Lumen\Testing\DatabaseMigrations;

class BooksControllerTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function index_status_code_should_be_200()
  {
    echo "\n\r{$this->yellow}It should see JSON...";

    $this->get('/v1/books')->seeStatusCode(200);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function index_should_return_a_collection_of_records()
  {
    echo "\n\r{$this->yellow}It should return a collection of records...";

    $books = factory('App\Book', 2)->create();

    $this->get('/v1/books');

    foreach ($books as $book) {
      $this->seeJson(['title' => $book->title]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function show_should_return_a_valid_book()
  {

    echo "\n\r{$this->yellow}Show should return a valid book...";

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

    echo "\n\r{$this->yellow}Show should fail when the book id does not exist...";

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
    echo "\n\r{$this->yellow}Show should not match an invalid route...";

    $this->get('/v1/books/this-is-invalid');

    $this->assertNotRegExp(
      '/Book not found/',
      $this->response->getContent(),
      'BooksController@show route matching when it should not.'
    );

    echo " {$this->green}[OK]{$this->white}\n\r";

  }

  /** @test **/
  public function store_should_save_new_book_in_the_database()
  {
    echo "\n\r{$this->yellow}Store should save a new book in the database...";

    $this->post('/v1/books', [
      'title'       => 'The Invisible Man',
      'description' => 'An invisible man is trapped in the terror of his own creation',
      'author'      => 'H. G. Wells',
    ]);

    $this
      ->seeJson(['created' => true])
      ->seeInDatabase('book', ['title' => 'The Invisible Man']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test */
  public function store_should_respond_with_a_201_and_location_header_when_successful()
  {
    echo "\n\r{$this->yellow}Store should respond with a 201 and location header...";

    $this->post('/v1/books', [
      'title'       => 'The Invisible Man',
      'description' => 'An invisible man is trapped in the terror of his own c\
reation',
      'author'      => 'H. G. Wells',
    ]);

    $this
      ->seeStatusCode(201)
      ->seeHeaderWithRegExp('Location', '#/books/[\d]+$#');

    echo " {$this->green}[OK]{$this->white}\n\r";

  }

  /** @test **/
  public function update_should_only_change_fillable_fields()
  {
    echo "\n\r{$this->yellow}Update should only change fillable fields...";

    $this->notSeeInDatabase('book', [
      'title' => 'The War of the Worlds',
    ]);

    $this->put('/v1/books/1', [
      'id'          => 5,
      'title'       => 'The War of the Worlds',
      'description' => 'The book is way better than the movie.',
      'author'      => 'Wells, H. G.',
    ]);

    $this
      ->seeStatusCode(200)
      ->seeJson([
        'id'          => 1,
        'title'       => 'The War of the Worlds',
        'description' => 'The book is way better than the movie.',
        'author'      => 'Wells, H. G.'])
      ->seeInDatabase('book', ['title' => 'The War of the Worlds']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function update_should_fail_with_an_invalid_id()
  {
    echo "\n\r{$this->yellow}Update should fail with an invalid id...";

    $this
      ->put('/v1/books/999999999999999')
      ->seeStatusCode(404)
      ->seeJsonEquals([
        'error' => [
          'message' => 'Book not found',
        ],
      ]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function update_should_not_match_an_invalid_route()
  {
    echo "\n\r{$this->yellow}Update should not match an invalid route...";

    $this->put('/v1/adbooks/this-is-invalid')
      ->seeStatusCode(404);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function destroy_should_remove_a_valid_book()
  {
    echo "\n\r{$this->yellow}Destroy should remove a valid book...";
    $this
      ->delete('/v1/books/1')
      ->seeStatusCode(204)
      ->isEmpty();

    $this->notSeeInDatabase('book', ['id' => 1]);
    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function destroy_should_return_a_404_with_an_invalid_id()
  {
    echo "\n\r{$this->yellow}Destroy should return a 404 with an invalid id...";
    $this
      ->delete('/v1/books/99999')
      ->seeStatusCode(404)
      ->seeJsonEquals([
        'error' => [
          'message' => 'Book not found',
        ],
      ]);
    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function destroy_should_not_match_an_invalid_route()
  {
    echo "\n\r{$this->yellow}Destroy should not match an invalid route...";
    $this->delete('/v1/books/this-is-invalid')
      ->seeStatusCode(404);
    echo " {$this->green}[OK]{$this->white}\n\r";
  }

}
