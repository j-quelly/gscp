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

  	// var_dump($body['error']['debug']['trace'][1]['args'][1]);

  	$body = $body['error']['debug']['trace'][1]['args'][1];

    $this->assertArrayHasKey('title', $body);
    $this->assertArrayHasKey('description', $body);
    $this->assertArrayHasKey('author', $body);

    $this->assertEquals("required", $body['title']);
    $this->assertEquals("required", $body['description']);
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

    $this->assertArrayHasKey('title', $body);
    $this->assertArrayHasKey('description', $body);
    $this->assertArrayHasKey('author', $body); 

    $this->assertEquals(["The title field is required."], $body['title']);
    $this->assertEquals(["The description field is required."], $body['description']);
    $this->assertEquals(["The author field is required."], $body['author']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }
}
