<?php

// use Laravel\Lumen\Testing\DatabaseTransactions;
namespace tests\app\Http\Controllers;

// use Laracasts\Integrated\Extensions\Goutte as IntegrationTest;

use Carbon\Carbon;
// use Illuminate\Foundation\Testing\DatabaseMigrations; ** deprecated
use Illuminate\Support\Facades\Artisan as Artisan;
use JWTAuth;
use TestCase;

class UsersControllerTest extends TestCase
{
  private $yellow = "\e[1;33m";
  private $green  = "\e[0;32m";
  private $white  = "\e[0;37m";
  private $url    = "/v1/users";

  /**
   * Disclaimer:
   * the "right" way to do testing, that gives you the greatest
   * confidence your tests methods don't get subtly interdependent in
   * bug-hiding ways, is to re-seed your db before every test method, so
   * just put seeding code in plain setUp if you can afford the
   * performance penalty
   */

  protected static $dbInitiated = false;

  protected static function initDB()
  {
    echo "\n\r\e[0;31mRefreshing the database...\n\r";
    Artisan::call('migrate:refresh');
    Artisan::call('db:seed');
  }

  public function setUp()
  {
    parent::setUp();

    if (!static::$dbInitiated) {
      static::$dbInitiated = true;
      static::initDB();
    }

    Carbon::setTestNow(Carbon::now('UTC'));
  }

  public function tearDown()
  {
    parent::tearDown();

    Carbon::setTestNow();
  }

  /** @test **/
  public function user_index_status_code_should_be_200()
  {
    echo "\n\r{$this->green}Users Controller Tests:";
    echo "\n\r{$this->yellow}    It should see JSON...";

    $data = $this->jwtAuthTest('get', $this->url);
    $this->seeStatusCode(200);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function user_index_should_return_a_collection_of_records()
  {
    echo "\n\r{$this->yellow}    It should return a collection of records...";

    $users = $this->userFactory(2);

    $content = $this->jwtAuthTest('get', $this->url);

    $this->assertArrayHasKey('data', $content);

    foreach ($users as $user) {
      $this->seeJson([
        'id'      => $user->id,
        'name'    => $user->name,
        'email'   => $user->email,
        'created' => $user->created_at->toIso8601String(),
        'updated' => $user->updated_at->toIso8601String(),
      ]);
    }

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function user_show_should_return_a_valid_user()
  {

    echo "\n\r{$this->yellow}    Show should return a valid user...";

    $user = $this->userFactory();

    $content = $this->jwtAuthTest('get', $this->url . "/{$user->id}");

    $this->seeStatusCode(200);

    // Get the response and assert the data key exists
    $content = json_decode($this->response->getContent(), true);
    $this->assertArrayHasKey('data', $content);
    $data = $content['data'];

    // Assert the User Properties match
    $this->assertEquals($user->id, $data['id']);
    $this->assertEquals($user->name, $data['name']);
    $this->assertEquals($user->email, $data['email']);
    $this->assertEquals($user->created_at->toIso8601String(), $data['created']);
    $this->assertEquals($user->updated_at->toIso8601String(), $data['created']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

/** @test **/
  public function user_show_should_fail_when_the_user_id_does_not_exist()
  {

    echo "\n\r{$this->yellow}    Show should fail when the user id does not exist...";

    $data = $this->jwtAuthTest('get', $this->url . "/99999");

    $this
      ->seeStatusCode(404)
      ->seeJson([
        'message' => 'Not Found',
        'status'  => 404,
      ]);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
  public function user_show_route_should_not_match_an_invalid_route()
  {
    echo "\n\r{$this->yellow}    Show should not match an invalid route...";

    $data = $this->jwtAuthTest('get', $this->url . "/this-is-invalid");

    $this->assertNotRegExp(
      '/User not found/',
      $this->response->getContent(),
      'UsersController@show route matching when it should not.'
    );

    echo " {$this->green}[OK]{$this->white}\n\r";

  }

  /** @test **/
  public function user_store_should_save_new_user_in_the_database()
  {
    echo "\n\r{$this->yellow}    Store should save a new user in the database...";

    $postData = [
      'name'     => 'Donald Trump',
      'email'    => 'donald@trump.com',
      'password' => 'biglysecure',
    ];

    $body = $this->jwtAuthTest('post', $this->url, $postData);

    $this->assertArrayHasKey('data', $body);

    $data = $body['data'];
    $this->assertEquals('Donald Trump', $data['name']);
    $this->assertEquals('donald@trump.com', $data['email']);
    $this->assertTrue($data['id'] > 0, 'Expected a positive integer, but did not see one.');
    $this->assertArrayHasKey('created', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['created']);
    $this->assertArrayHasKey('updated', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['updated']);

    $this->seeInDatabase('users', ['name' => 'Donald Trump']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test */
  public function user_store_should_respond_with_a_201_and_location_header_when_successful()
  {
    echo "\n\r{$this->yellow}    Store should respond with a 201 and location header...";

    $author = factory(\App\Author::class)->create();

    $postData = [
      'name'     => 'The Invisible Man',
      'email'    => 'derp@flerp.com',
      'password' => 'thisrpassword',
    ];

    $body = $this->jwtAuthTest('post', $this->url, $postData);

    $this
      ->seeStatusCode(201)
      ->seeHeaderWithRegExp('Location', '#/users/[\d]+$#');

    echo " {$this->green}[OK]{$this->white}\n\r";

  }

  /** @test **/
  public function user_update_should_only_change_fillable_fields()
  {
    echo "\n\r{$this->yellow}    Update should only change fillable fields...";

    $user = $this->userFactory();

    $this->notSeeInDatabase('users', [
      'name'  => 'The War of the Worlds',
      'email' => 'The book is way better than the movie.',
    ]);

    $postData = [
      'id'       => 5,
      'name'     => 'Steve Stevington',
      'email'    => 'storton@florton.com',
      'password' => 'dontassumemygender',
    ];

    $body = $this->jwtAuthTest('put', $this->url . "/{$user->id}", $postData);

    $this
      ->seeStatusCode(200)
      ->seeJson([
        'id'    => $user->id,
        'name'  => 'Steve Stevington',
        'email' => 'storton@florton.com',
      ])
      ->seeInDatabase('users', [
        'name'  => 'Steve Stevington',
        'email' => 'storton@florton.com',
      ]);

    $this->assertArrayHasKey('data', $body);

    $data = $body['data'];
    $this->assertArrayHasKey('created', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['created']);
    $this->assertArrayHasKey('updated', $data);
    $this->assertEquals(Carbon::now()->toIso8601String(), $data['updated']);

    echo " {$this->green}[OK]{$this->white}\n\r";
  }

  /** @test **/
    public function user_update_should_fail_with_an_invalid_id()
    {
      echo "\n\r{$this->yellow}    Update should fail with an invalid id...";

    $body = $this->jwtAuthTest('put', $this->url . "/999999999");

    $this
        ->seeStatusCode(404)
        ->seeJsonEquals([
          'error' => [
            'message' => 'User not found',
          ],
        ]);

    echo " {$this->green}[OK]{$this->white}\n\r";
    }

  /** @test **/
    public function update_should_not_match_an_invalid_route()
    {
      echo "\n\r{$this->yellow}    Update should not match an invalid route...";

    $body = $this->jwtAuthTest('put', $this->url . "/this-is-invalid");

      $this->seeStatusCode(404);

    echo " {$this->green}[OK]{$this->white}\n\r";
    }

  /** @test **/
    public function user_destroy_should_remove_a_valid_user()
    {
      echo "\n\r{$this->yellow}    Destroy should remove a valid user...";

    $user = $this->userFactory();

    $body = $this->jwtAuthTest('delete', $this->url . "/{$user->id}");

    $this
        ->seeStatusCode(204)
        ->isEmpty();

    $this->notSeeInDatabase('users', ['id' => $user->id]);

    echo " {$this->green}[OK]{$this->white}\n\r";
    }

  /** @test **/
    public function user_destroy_should_return_a_404_with_an_invalid_id()
    {
      echo "\n\r{$this->yellow}    Destroy should return a 404 with an invalid id...";

    $body = $this->jwtAuthTest('delete', $this->url . "/99999");

    $this
        ->seeStatusCode(404)
        ->seeJsonEquals([
          'error' => [
            'message' => 'User not found',
          ],
        ]);
      echo " {$this->green}[OK]{$this->white}\n\r";
    }

  /** @test **/
    public function user_destroy_should_not_match_an_invalid_route()
    {
      echo "\n\r{$this->yellow}    Destroy should not match an invalid route...";

    $body = $this->jwtAuthTest('delete', $this->url . "/this-is-invalid");

    $this->seeStatusCode(404);

    echo " {$this->green}[OK]{$this->white}\n\r";
    }

}
