<?php

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class TestCase extends Laravel\Lumen\Testing\TestCase
{
  use MockeryPHPUnitIntegration;
  /**
   * Creates the application.
   *
   * @return \Laravel\Lumen\Application
   */
  public function createApplication()
  {
    $app = require __DIR__ . '/../bootstrap/app.php';

    // $app->loadEnvironmentFrom('.env.testing');

    return $app;

    // return require __DIR__ . '/../bootstrap/app.php';
  }

  // public function setUp()
  // {
  //   parent::setUp();

  //   // $this->refreshApplication();

  //   $this->artisan('migrate');
  // }

  // public function tearDown()
  // {
  //   $this->artisan('migrate:reset');

  //   parent::tearDown();
  // }

  // todo: maybe add a method for seeding the database

/**
 * See if the response has a header.
 *
 * @param $header
 * @return $this
 */
  public function seeHasHeader($header)
  {
    $this->assertTrue(
      $this->response->headers->has($header),
      "Response should have the header '{$header}' but does not."
    );
    return $this;
  }

/**
 * Asserts that the response header matches a given regular expression
 *
 * @param $header
 * @param $regexp
 * @return $this
 */
  public function seeHeaderWithRegExp($header, $regexp)
  {
    $this
      ->seeHasHeader($header)
      ->assertRegExp($regexp, $this->response->headers->get($header));
    return $this;
  }

  /**
   * Convenience method for creating a book with an author
   *
   * @param int $count
   * @return mixed
   */
  protected function bookFactory($count = 1)
  {
    $author = factory(\App\Author::class)->create();
    $books  = factory(\App\Book::class, $count)->make();

    if ($count === 1) {
      $books->author()->associate($author);
      $books->save();
    } else {
      foreach ($books as $book) {
        $book->author()->associate($author);
        $book->save();
      }
    }

    return $books;
  }

/**
 * Convenience method for creating a user
 *
 * @return $user
 */
  protected function userFactory()
  {

    $user = factory(\App\User::class, 1)->create(['password' => app('hash')->make('supersecret')]);

    return $user;
  }

/**
 * Convenience method for getting jwt and authenticating
 *
 * @return $body
 */
  protected function jwtAuthTest($method, $url, $body = [])
  {
    $user = $this->userFactory();

    $token = JWTAuth::fromUser($user);
    JWTAuth::setToken($token);
    $headers = array('Accept' => 'application/json', 'Authentication' => 'Bearer ' . $token);

    switch ($method) {
      case 'get':
        $this->get($url, $headers);
        break;
      case 'post':
        $this->post($url, $body, $headers);
        break;
      case 'put':
        $this->put($url, $body, $headers);
        break;
      case 'patch':
        $this->patch($url, $body, $headers);
        break;
      case 'delete':
        $this->delete($url, $body, $headers);
        break;
    }

    $data = json_decode($this->response->getContent(), true);

    return $data;
  }

}
