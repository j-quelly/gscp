<?php namespace Tests\App\Http\Response;

use App\Http\Response\FractalResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\SerializerAbstract;
use Mockery as m;
use TestCase;

class FractalResponseTest extends TestCase
{
  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function it_can_be_initialized()
  {
    echo "\n\r{$this->green}Fractal Response Tests:";
    echo "\n\r{$this->yellow}    It can be initialized...";

    $manager    = m::mock(Manager::class);
    $serializer = m::mock(SerializerAbstract::class);
    $request    = m::mock(Request::class);

    $manager
      ->shouldReceive('setSerializer')
      ->with($serializer)
      ->once()
      ->andReturn($manager);

    $fractal = new FractalResponse($manager, $serializer, $request);
    $this->assertInstanceOf(FractalResponse::class, $fractal);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_can_transform_an_item()
  {
    echo "\n\r{$this->yellow}    It can transform an item...";

    // Request
    $request = m::mock(Request::class);

    // Transformer
    $transformer = m::mock('League\Fractal\TransformerAbstract');

    // Scope
    $scope = m::mock('League\Fractal\Scope');
    $scope
      ->shouldReceive('toArray')
      ->once()
      ->andReturn(['foo' => 'bar']);

    // Serializer
    $serializer = m::mock('League\Fractal\Serializer\SerializerAbstract');

    $manager = m::mock('League\Fractal\Manager');
    $manager
      ->shouldReceive('setSerializer')
      ->with($serializer)
      ->once();

    $manager
      ->shouldReceive('createData')
      ->once()
      ->andReturn($scope);

    $subject = new FractalResponse($manager, $serializer, $request);
    $this->assertInternalType(
      'array',
      $subject->item(['foo' => 'bar'], $transformer)
    );

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_can_transform_a_collection()
  {
    echo "\n\r{$this->yellow}    It can transform a collection...";

    $data = [
      ['foo' => 'bar'],
      ['fizz' => 'buzz'],
    ];

    // Request
    $request = m::mock(Request::class);

    // Transformer
    $transformer = m::mock('League\Fractal\TransformerAbstract');

    // Scope
    $scope = m::mock('League\Fractal\Scope');
    $scope
      ->shouldReceive('toArray')
      ->once()
      ->andReturn($data);

    // Serializer
    $serializer = m::mock('League\Fractal\Serializer\SerializerAbstract');

    $manager = m::mock('League\Fractal\Manager');
    $manager
      ->shouldReceive('setSerializer')
      ->with($serializer)
      ->once();

    $manager
      ->shouldReceive('createData')
      ->once()
      ->andReturn($scope);

    $subject = new FractalResponse($manager, $serializer, $request);
    $this->assertInternalType(
      'array',
      $subject->collection($data, $transformer)
    );

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_should_parse_passed_includes_when_passed()
  {
    echo "\n\r{$this->yellow}    It should parse passed includes when passed...";

    $serializer = m::mock(SerializerAbstract::class);

    $manager = m::mock(Manager::class);
    $manager->shouldReceive('setSerializer')->with($serializer);
    $manager
      ->shouldReceive('parseIncludes')
      ->with('books');

    $request = m::mock(Request::class);
    $request->shouldNotReceive('query');

    $subject = new FractalResponse($manager, $serializer, $request);
    $subject->parseIncludes('books');

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_should_parse_request_query_includes_with_no_arguments()
  {
    echo "\n\r{$this->yellow}    It should parse request query includes with no argumetns...";

    $serializer = m::mock(SerializerAbstract::class);
    $manager = m::mock(Manager::class);
    $manager->shouldReceive('setSerializer')->with($serializer);
    $manager
      ->shouldReceive('parseIncludes')
      ->with('books');

    $request = m::mock(Request::class);
    $request
      ->shouldReceive('query')
      ->with('include', '')
      ->andReturn('books');

    (new FractalResponse($manager, $serializer, $request))->parseIncludes();

    echo " {$this->green}[OK]{$this->white}\n\r";
  }
}
