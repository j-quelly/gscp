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
 * Return request headers needed to interact with the API.
 *
 * @return Array array of headers.
 */
  protected function headers($user = null)
  {
    $headers = ['Accept' => 'application/json'];

    if (!is_null($user)) {
      $token = JWTAuth::fromUser($user);
      JWTAuth::setToken($token);
      $headers['Authorization'] = 'Bearer ' . $token;
    }

    return $headers;
  }

}
