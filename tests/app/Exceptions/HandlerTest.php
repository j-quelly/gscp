<?php

namespace Tests\App\Exceptions;

use App\Exceptions\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TestCase;
use \Mockery as m;

class HandlerTest extends TestCase
{

  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";

  /** @test **/
  public function it_responds_with_html_when_json_is_not_accepted()
  {
  	echo "\n\r{$this->yellow}It responds with html when json is not accepted...";

    // Make the mock a partial, we only want to mock the `isDebugMode` method
    $subject = m::mock(Handler::class)->makePartial();
    $subject->shouldNotReceive('isDebugMode');

    // Mock the interaction with the Request
    $request = m::mock(Request::class);
    $request->shouldReceive('wantsJson')->andReturn(false);

    // Mock the interaction with the exception
    $exception = m::mock(\Exception::class, ['Error!']);
    $exception->shouldNotReceive('getStatusCode');
    $exception->shouldNotReceive('getTrace');
    $exception->shouldNotReceive('getMessage');

    // Call the method under test, this is not a mocked method.
    $result = $subject->render($request, $exception);

    // Assert that `render` does not return a JsonResponse
    $this->assertNotInstanceOf(JsonResponse::class, $result);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }
}
