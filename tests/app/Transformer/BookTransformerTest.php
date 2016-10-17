<?php
namespace Tests\App\Transformer;

use App\Transformer\BookTransformer;
// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use Laravel\Lumen\Testing\DatabaseMigrations;
use League\Fractal\TransformerAbstract;
use TestCase;

class BookTransformerTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function it_can_be_initialized()
  {
    echo "\n\r{$this->yellow}It can be initialized...";

    $subject = new BookTransformer();
    $this->assertInstanceOf(TransformerAbstract::class, $subject);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_transforms_a_book_model()
  {
    echo "\n\r{$this->yellow}It transforms a book model...";

    $book = $this->bookFactory();
    $subject = new BookTransformer();

    $transform = $subject->transform($book);

    $this->assertArrayHasKey('id', $transform);
    $this->assertArrayHasKey('title', $transform);
    $this->assertArrayHasKey('description', $transform);
    $this->assertArrayHasKey('author', $transform);
    $this->assertArrayHasKey('created', $transform);
    $this->assertArrayHasKey('updated', $transform);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

}
