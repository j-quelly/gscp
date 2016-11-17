<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Http\Response;
use TestCase;

class BooksControllerValidationTest extends TestCase
{
  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = "/v1/books";

  /** @test **/
  public function it_validates_required_fields_when_creating_a_new_book()
  {
    echo "\n\r{$this->green}Books Controller Validation Tests:";
    echo "\n\r{$this->yellow}    It validates required fields when creating a new book...";

    $this->assertInvalidData('post', $this->url);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_validates_requied_fields_when_updating_a_book()
  {
    echo "\n\r{$this->yellow}    It validates required fields when updating a new book...";

    $book = $this->bookFactory();
    $this->assertInvalidData('put', $this->url . "/{$book->id}");

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function title_fails_create_validation_when_just_too_long()
  {
    echo "\n\r{$this->yellow}    Title fails create validation when just too long...";

    // Creating a book
    $book        = $this->bookFactory();
    $book->title = str_repeat('a', 256);

    $postData = [
      'title'       => $book->title,
      'description' => $book->description,
      'author_id'   => $book->author->id,
    ];

    $data = $this->jwtAuthTest('post', $this->url, $postData, 'admin');

    $this
      ->seeStatusCode(422)
      ->notSeeInDatabase('book', ['title' => $book->title]);
    $this->assertArrayHasKey('title', $data);
    $this->assertEquals(['The title field must be less than 256 characters.'], $data['title']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function title_fails_update_validation_when_just_too_long()
  {
    echo "\n\r{$this->yellow}    Title fails update validation when just too long...";

    // Updating a book
    $book        = $this->bookFactory();
    $book->title = str_repeat('a', 256);

    $postData = [
      'title'       => $book->title,
      'description' => $book->description,
      'author_id'   => $book->author->id,
    ];

    $data = $this->jwtAuthTest('put', $this->url . "/{$book->id}", $postData, 'admin');

    $this
      ->seeStatusCode(422)
      ->notSeeInDatabase('book', ['title' => $book->title]);
    $this->assertArrayHasKey('title', $data);
    $this->assertEquals(['The title field must be less than 256 characters.'], $data['title']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

/** @test **/
  public function title_passes_create_validation_when_exactly_max()
  {
    echo "\n\r{$this->yellow}    Title passes create validation when exactly max...";

    // Creating a new Book
    $book        = $this->bookFactory();
    $book->title = str_repeat('a', 255);

    $postData = [
      'title'       => $book->title,
      'description' => $book->description,
      'author_id'   => $book->author->id,
    ];

    $data = $this->jwtAuthTest('post', $this->url, $postData, 'admin');

    $this
      ->seeStatusCode(Response::HTTP_CREATED)
      ->seeInDatabase('book', ['title' => $book->title]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function title_passes_update_validation_when_exactly_max()
  {
    echo "\n\r{$this->yellow}    Title passes update validation when exactly max...";

    // Updating a book
    $book        = $this->bookFactory();
    $book->title = str_repeat('a', 255);

    $postData = [
      'title'       => $book->title,
      'description' => $book->description,
      'author_id'   => $book->author->id,
    ];

    $data = $this->jwtAuthTest('put', $this->url . "/{$book->id}", $postData, 'admin');

    $this
      ->seeStatusCode(Response::HTTP_OK)
      ->seeInDatabase('book', ['title' => $book->title]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  private function assertInvalidData($method, $url, $body = [])
  {

    $data = $this->jwtAuthTest($method, $url, $body, 'admin');

    $fields = ["title", "description", "author_id"];

    $this->seeStatusCode(422);

    foreach ($fields as $field) {
      $this->assertArrayHasKey($field, $data);
      $this->assertEquals(["The {$field} field is required."], $data[$field]);
    }
  }
}
