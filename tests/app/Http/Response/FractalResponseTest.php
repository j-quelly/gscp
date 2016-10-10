<?php namespace Tests\App\Http\Response;

use App\Http\Response\FractalResponse;
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
    echo "\n\r{$this->yellow}It can be initialized...";

    $manager    = m::mock(Manager::class);
    $serializer = m::mock(SerializerAbstract::class);

    $manager
      ->shouldReceive('setSerializer')
      ->with($serializer)
      ->once()
      ->andReturn($manager);

    $fractal = new FractalResponse($manager, $serializer);
    $this->assertInstanceOf(FractalResponse::class, $fractal);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_can_transform_an_item()
  {
    echo "\n\r{$this->yellow}It can transform an item...";

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

    $subject = new FractalResponse($manager, $serializer);
    $this->assertInternalType(
      'array',
      $subject->item(['foo' => 'bar'], $transformer)
    );

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function it_can_transform_a_collection()
  {
  	echo "\n\r{$this->yellow}It can transform a collection...";

    $data = [
      ['foo' => 'bar'],
      ['fizz' => 'buzz'],
    ];

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

    $subject = new FractalResponse($manager, $serializer);
    $this->assertInternalType(
      'array',
      $subject->collection($data, $transformer)
    );

    echo " {$this->green}[OK]{$this->white}\n\r";
  }
}
