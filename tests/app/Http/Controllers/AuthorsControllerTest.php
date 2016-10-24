<?php
namespace Tests\App\Http\Controllers;

// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthorsControllerTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function index_responds_with_200_status_code()
  {
    echo "\n\r{$this->green}Authors Controller Tests:";
    echo "\n\r{$this->yellow}    Index responds with 200 status code...";

    $this->get('/v1/authors')->seeStatusCode(Response::HTTP_OK);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function index_should_return_a_collection_of_records()
  {
    echo "\n\r{$this->yellow}    Index responds with 200 status code...";

    $authors = factory(\App\Author::class, 2)->create();

    $this->get('/v1/authors', ['Accept' => 'application/json']);

    $body = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('data', $body);
    $this->assertCount(2, $body['data']);

    foreach ($authors as $author) {
      $this->seeJson([
        'id'        => $author->id,
        'name'      => $author->name,
        'gender'    => $author->gender,
        'biography' => $author->biography,
        'created'   => $author->created_at->toIso8601String(),
        'updated'   => $author->updated_at->toIso8601String(),
      ]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

/** @test **/
  public function show_should_return_a_valid_author()
  {
    echo "\n\r{$this->yellow}    Show should return a valid author...";

    $book   = $this->bookFactory();
    $author = $book->author;
    $this->get("/v1/authors/{$author->id}", ['Accept' => 'application/json']);
    $body = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('data', $body);
    $this->seeJson([
      'id'        => $author->id,
      'name'      => $author->name,
      'gender'    => $author->gender,
      'biography' => $author->biography,

      'created'   => $author->created_at->toIso8601String(),
      'updated'   => $author->updated_at->toIso8601String(),
    ]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

/** @test **/
  public function show_should_fail_on_an_invalid_author()
  {
    echo "\n\r{$this->yellow}    Show should fail on an invalid author...";

    $this->get('/v1/authors/1234', ['Accept' => 'application/json']);
    $this->seeStatusCode(Response::HTTP_NOT_FOUND);
    $this->seeJson([
      'message' => 'Not Found',
      'status'  => Response::HTTP_NOT_FOUND,
    ]);
    $body = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('error', $body);
    $error = $body['error'];
    $this->assertEquals('Not Found', $error['message']);
    $this->assertEquals(Response::HTTP_NOT_FOUND, $error['status']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function show_optionally_includes_books()
  {
    echo "\n\r{$this->yellow}    Show optionally includes books...";

    $book   = $this->bookFactory();
    $author = $book->author;

    $this->get(
      "/v1/authors/{$author->id}?include=books",
      ['Accept' => 'application/json']
    );

    $body = json_decode($this->response->getContent(), true);

    $this->assertArrayHasKey('data', $body);
    $data = $body['data'];
    $this->assertArrayHasKey('books', $data);
    $this->assertArrayHasKey('data', $data['books']);
    $this->assertCount(1, $data['books']['data']);

    // See Author Data
    $this->seeJson([
      'id'   => $author->id,
      'name' => $author->name,
    ]);

    // Test included book Data (the first record)
    $actual = $data['books']['data'][0];
    $this->assertEquals($book->id, $actual['id']);
    $this->assertEquals($book->title, $actual['title']);
    $this->assertEquals($book->description, $actual['description']);
    $this->assertEquals(
      $book->created_at->toIso8601String(),
      $actual['created']
    );
    $this->assertEquals(
      $book->updated_at->toIso8601String(),
      $actual['updated']
    );

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function store_can_create_a_new_author()
  {
    echo "\n\r{$this->yellow}    Store can create a new author...";

    $postData = [
      'name'      => 'H. G. Wells',
      'gender'    => 'male',
      'biography' => 'Prolific Science-Fiction Writer',
    ];

    $this->post('/v1/authors', $postData, ['Accept' => 'application/json']);

    $this->seeStatusCode(201);
    $data = $this->response->getData(true);
    $this->assertArrayHasKey('data', $data);
    $this->seeJson($postData);

    $this->seeInDatabase('authors', $postData);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function update_can_update_an_existing_author()
  {
    echo "\n\r{$this->yellow}    Update can update an existing author...";

    $author = factory(\App\Author::class)->create();

    $requestData = [
      'name'      => 'New Author Name',
      'gender'    => $author->gender === 'male' ? 'female' : 'male',
      'biography' => 'An updated biography',
    ];

    $this
      ->put(
        "/v1/authors/{$author->id}",
        $requestData,
        ['Accept' => 'application/json']
      )
      ->seeStatusCode(200)
      ->seeJson($requestData)
      ->seeInDatabase('authors', [
        'name' => 'New Author Name',
      ])
      ->notSeeInDatabase('authors', [
        'name' => $author->name,
      ]);

    $this->assertArrayHasKey('data', $this->response->getData(true));

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function delete_can_remove_an_author_and_his_or_her_books()
  {
    echo "\n\r{$this->yellow}    Delete can remove an author and his or her books...";

    $author = factory(\App\Author::class)->create();

    $this
      ->delete("/v1/authors/{$author->id}")
      ->seeStatusCode(204)
      ->notSeeInDatabase('authors', ['id' => $author->id])
      ->notSeeInDatabase('book', ['author_id' => $author->id]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function deleting_an_invalid_author_should_return_a_404()
  {
    echo "\n\r{$this->yellow}    Deleting an invalid author should return a 404...";

    $this
      ->delete('/v1/authors/99999', [],
        ['Accept' => 'application/json'])
      ->seeStatusCode(404);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }
}
