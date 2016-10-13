<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class BooksControllerValidationTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function it_validates_required_fields_when_creating_a_new_book()
  {
    echo "\n\r{$this->yellow}It validates required fields when creating a new book...";

    $this->post('/v1/books', [], ['Accept' => 'application/json']);

    $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->response->getStatusCode());

    $body = json_decode($this->response->getContent(), true);

    // todo: this should be improved
    $desc = $body['error']['debug']['trace'][1]['args'][2];
    $body = $body['error']['debug']['trace'][1]['args'][1];

    $this->assertArrayHasKey('title', $body);
    $this->assertArrayHasKey('description', $body);
    $this->assertArrayHasKey('author', $body);

    $this->assertEquals("required|max:255", $body['title']);
    $this->assertEquals("Please fill out the description.", $desc['description.required']);
    $this->assertEquals("required", $body['author']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_validates_requied_fields_when_updating_a_book()
  {
    echo "\n\r{$this->yellow}It validates required fields when updating a new book...";

    $book = factory(\App\Book::class)->create();

    $this->put("/v1/books/{$book->id}", [], ['Accept' => 'application/json']);

    $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->response->getStatusCode());

    $body = json_decode($this->response->getContent(), true);

    // todo: this should be improved
    $desc = $body['error']['debug']['trace'][1]['args'][2];
    $body = $body['error']['debug']['trace'][1]['args'][1];

    $this->assertArrayHasKey('title', $body);
    $this->assertArrayHasKey('description', $body);
    $this->assertArrayHasKey('author', $body);

    $this->assertEquals("required|max:255", $body['title']);
    $this->assertEquals("Please fill out the description.", $desc['description.required']);
    $this->assertEquals("required", $body['author']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function title_fails_create_validation_when_just_too_long()
  {
    echo "\n\r{$this->yellow}Title fails create validation when just too long...";

    // Creating a book
    $book        = factory(\App\Book::class)->make();
    $book->title = str_repeat('a', 256);

    $this->post("/v1/books", [
      'title'       => $book->title,
      'description' => $book->description,
      'author'      => $book->author,
    ], ['Accept' => 'application/json']); 

    $this
      ->seeStatusCode(Response::HTTP_BAD_REQUEST)
      ->notSeeInDatabase('book', ['title' => $book->title]);

    $body = json_decode($this->response->getContent(), true);

    $body = $body['error']['debug']['trace'][1]['args'][1];

    $this->assertArrayHasKey('title', $body);

    $this->assertEquals("required|max:255", $body['title']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function title_fails_update_validation_when_just_too_long()
  {
    echo "\n\r{$this->yellow}Title fails update validation when just too long...";

    // Updating a book
    $book        = factory(\App\Book::class)->create();
    $book->title = str_repeat('a', 256);

    $this->put("/v1/books/{$book->id}", [
      'title'       => $book->title,
      'description' => $book->description,
      'author'      => $book->author,
    ], ['Accept' => 'application/json']);

    $this
      ->seeStatusCode(Response::HTTP_BAD_REQUEST)
      ->notSeeInDatabase('book', ['title' => $book->title]);

    $body = json_decode($this->response->getContent(), true);

    $body = $body['error']['debug']['trace'][1]['args'][1];

    $this->assertArrayHasKey('title', $body);

    $this->assertEquals("required|max:255", $body['title']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

/** @test **/
  public function title_passes_create_validation_when_exactly_max()
  {
    echo "\n\r{$this->yellow}Title passes create validation when exactly max...";

    // Creating a new Book
    $book        = factory(\App\Book::class)->make();
    $book->title = str_repeat('a', 255);

    $this->post("/v1/books", [
      'title'       => $book->title,
      'description' => $book->description,
      'author'      => $book->author,
    ], ['Accept' => 'application/json']);

    $this
      ->seeStatusCode(Response::HTTP_CREATED)
      ->seeInDatabase('book', ['title' => $book->title]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function title_passes_update_validation_when_exactly_max()
  {
    echo "\n\r{$this->yellow}Title passes update validation when exactly max...";

    // Updating a book
    $book        = factory(\App\Book::class)->create();
    $book->title = str_repeat('a', 255);

    $this->put("/v1/books/{$book->id}", [
      'title'       => $book->title,
      'description' => $book->description,
      'author'      => $book->author,
    ], ['Accept' => 'application/json']);

    $this
      ->seeStatusCode(Response::HTTP_OK)
      ->seeInDatabase('book', ['title' => $book->title]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

}
