<?php
namespace Tests\App\Http\Controllers;

// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
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
    echo "\n\r{$this->yellow}Index responsds with 200 status code...";

    $this->get('/v1/authors')->seeStatusCode(Response::HTTP_OK);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function index_should_return_a_collection_of_records()
  {
  	echo "\n\r{$this->yellow}Index responsds with 200 status code...";

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
}
