<?php

namespace Tests\App\Transformer;

use App\Transformer\AuthorTransformer;
// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthorTransformerTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  public function setUp()
  {
    parent::setUp();

    $this->subject = new AuthorTransformer();
  }
  /** @test **/
  public function it_can_be_initialized()
  {
    echo "\n\r{$this->yellow}It can be initialized...";

    $this->assertInstanceOf(AuthorTransformer::class, $this->subject);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_can_transform_an_author()
  {
    echo "\n\r{$this->yellow}It can transform an author...";

    $author = factory(\App\Author::class)->create();

    $actual = $this->subject->transform($author);

    $this->assertEquals($author->id, $actual['id']);
    $this->assertEquals($author->name, $actual['name']);
    $this->assertEquals($author->gender, $actual['gender']);
    $this->assertEquals($author->biography, $actual['biography']);
    $this->assertEquals(
      $author->created_at->toIso8601String(),
      $actual['created']
    );
    $this->assertEquals(
      $author->updated_at->toIso8601String(),
      $actual['created']
    );

    echo " {$this->green}[OK]{$this->white}\n\r";
  }
}