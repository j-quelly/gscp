<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use TestCase;

class BooksControllerTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  // public function setUp()
  // {
  //   parent::setUp();

  //   Carbon::setTestNow(Carbon::now('UTC'));

  // }

  // public function tearDown()
  // {
  //   parent::tearDown();

  //   Carbon::setTestNow();
  // }

  /** @test **/
  public function index_status_code_should_be_200()
  {
    echo "\n\r{$this->green}Books Controller Tests:";
    echo "\n\r{$this->yellow}    It should see JSON...";

    $this->get('/v1/books')->seeStatusCode(200);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function index_should_return_a_collection_of_records()
  {
    echo "\n\r{$this->yellow}    It should return a collection of records...";

    $books = $this->bookFactory(2);

    $this->get('/v1/books');

    $content = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('data', $content);

    foreach ($books as $book) {
      $this->seeJson([
        'id'          => $book->id,
        'title'       => $book->title,
        'description' => $book->description,
        'author'      => $book->author->name, // Check the author's name
        'created'     => $book->created_at->toIso8601String(),
        'updated'     => $book->updated_at->toIso8601String(),
      ]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function show_should_return_a_valid_book()
  {

    echo "\n\r{$this->yellow}    Show should return a valid book...";

    $book = $this->bookFactory();

    $this
      ->get("/v1/books/{$book->id}")
      ->seeStatusCode(200);

    // Get the response and assert the data key exists
    $content = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('data', $content);
    $data = $content['data'];

    // Assert the Book Properties match
    $this->assertEquals($book->id, $data['id']);
    $this->assertEquals($book->title, $data['title']);
    $this->assertEquals($book->description, $data['description']);
    $this->assertEquals($book->author->name, $data['author']);
    $this->assertEquals($book->created_at->toIso8601String(), $data['created']);
    $this->assertEquals($book->updated_at->toIso8601String(), $data['created']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

/** @test **/
  public function show_should_fail_when_the_book_id_does_not_exist()
  {

    echo "\n\r{$this->yellow}    Show should fail when the book id does not exist...";

    $this
      ->get('/v1/books/99999', ['Accept' => 'application/json'])
      ->seeStatusCode(404)
      ->seeJson([
        'message' => 'Not Found',
        'status'  => 404,
      ]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function show_route_should_not_match_an_invalid_route()
  {
    echo "\n\r{$this->yellow}    Show should not match an invalid route...";

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
    echo "\n\r{$this->yellow}    Store should save a new book in the database...";

    $author = factory(\App\Author::class)->create([
      'name' => 'H. G. Wells',
    ]);

    $this->post('/v1/books', [
      'title'       => 'The Invisible Man',
      'description' => 'An invisible man is trapped in the terror of his own creation',
      'author_id'   => $author->id,
    ], ['Accept' => 'application/json']);

    $body = json_decode($this->response->getContent(), true);

    // dump data and exit
    // dd($body);
    // dd($body, $this->response->getStatusCode());

    $this->assertArrayHasKey('data', $body);

    $data = $body['data'];
    $this->assertEquals('The Invisible Man', $data['title']);
    $this->assertEquals(
      'An invisible man is trapped in the terror of his own creation',
      $data['description']
    );
    $this->assertEquals('H. G. Wells', $data['author']);

    $this->assertTrue($data['id'] > 0, 'Expected a positive integer, but did not see one.');

    $this->assertArrayHasKey('created', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['created']);
    $this->assertArrayHasKey('updated', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['updated']);

    $this->seeInDatabase('book', ['title' => 'The Invisible Man']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test */
  public function store_should_respond_with_a_201_and_location_header_when_successful()
  {
    echo "\n\r{$this->yellow}    Store should respond with a 201 and location header...";

    $author = factory(\App\Author::class)->create();

    $this->post('/v1/books', [
      'title'       => 'The Invisible Man',
      'description' => 'An invisible man is trapped in the terror of his own c\
reation',
      'author_id'   => $author->id,
    ]);

    $this
      ->seeStatusCode(201)
      ->seeHeaderWithRegExp('Location', '#/books/[\d]+$#');

    echo " {$this->green}[OK]{$this->white}\n\r";

  }

  /** @test **/
  public function update_should_only_change_fillable_fields()
  {
    echo "\n\r{$this->yellow}    Update should only change fillable fields...";

    $book = $this->bookFactory();

    $this->notSeeInDatabase('book', [
      'title'       => 'The War of the Worlds',
      'description' => 'The book is way better than the movie.',
    ]);

    $this->put("/v1/books/{$book->id}", [
      'id'          => 5,
      'title'       => 'The War of the Worlds',
      'description' => 'The book is way better than the movie.',
    ], ['Accept' => 'application/json']);

    $this
      ->seeStatusCode(200)
      ->seeJson([
        'id'          => 1,
        'title'       => 'The War of the Worlds',
        'description' => 'The book is way better than the movie.',
      ])
      ->seeInDatabase('book', [
        'title' => 'The War of the Worlds',
      ]);

    $body = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('data', $body);

    $data = $body['data'];
    $this->assertArrayHasKey('created', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['created']);
    $this->assertArrayHasKey('updated', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['updated']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function update_should_fail_with_an_invalid_id()
  {
    echo "\n\r{$this->yellow}    Update should fail with an invalid id...";

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
    echo "\n\r{$this->yellow}    Update should not match an invalid route...";

    $this->put('/v1/adbooks/this-is-invalid')
      ->seeStatusCode(404);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function destroy_should_remove_a_valid_book()
  {
    echo "\n\r{$this->yellow}    Destroy should remove a valid book...";

    $book = $this->bookFactory();

    $this
      ->delete("/v1/books/{$book->id}")
      ->seeStatusCode(204)
      ->isEmpty();

    $this->notSeeInDatabase('book', ['id' => $book->id]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function destroy_should_return_a_404_with_an_invalid_id()
  {
    echo "\n\r{$this->yellow}    Destroy should return a 404 with an invalid id...";
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
    echo "\n\r{$this->yellow}    Destroy should not match an invalid route...";
    $this->delete('/v1/books/this-is-invalid')
      ->seeStatusCode(404);
    echo " {$this->green}[OK]{$this->white}\n\r";
  }

}
