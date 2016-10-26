<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use TestCase;

class AuthControllerTest extends TestCase
{
  use DatabaseMigrations;

  private $yellow  = "\e[1;33m";
  private $green   = "\e[0;32m";
  private $white   = "\e[0;37m";
  private $version = '/v1';

  /** @test **/
  public function it_should_generate_a_jwt()
  {
    echo "\n\r{$this->green}Auth Controller Tests:";
    echo "\n\r{$this->yellow}    It should generate a jwt...";

    // $user        = User::find(1);
    $this->token = JWTAuth::fromUser($user);

    JWTAuth::setToken($this->token);

    Auth::login($user);    

    // $this->post($this->version.'/auth/login', [
    //   'email'       => 'johndoe@example.com',
    //   'password' => 'johndoe', // secure this
    // ], ['Accept' => 'application/json']);

    // $body = json_decode($this->response->getContent(), true);

    // // dump data and exit
    // dd($body);
    // // dd($body, $this->response->getStatusCode());

    // $this->assertArrayHasKey('success', $body);

    // $data = $body['data'];
    // $this->assertEquals('The Invisible Man', $data['title']);
    // $this->assertEquals(
    //   'An invisible man is trapped in the terror of his own creation',
    //   $data['description']
    // );
    // $this->assertEquals('H. G. Wells', $data['author']);

    // $this->assertTrue($data['id'] > 0, 'Expected a positive integer, but did not see one.');

    // $this->assertArrayHasKey('created', $data);
    // $this->assertEquals(Carbon::now()->toIso8601String(), $data['created']);
    // $this->assertArrayHasKey('updated', $data);
    // $this->assertEquals(Carbon::now()->toIso8601String(), $data['updated']);

    // $this->seeInDatabase('book', ['title' => 'The Invisible Man']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

}
