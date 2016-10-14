<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
/**
 * Run the database seeds.
 *
 * @return void
 */
  public function run()
  {
    factory(App\Author::class, 10)->create()->each(function ($author) {
      $booksCount = rand(1, 5);

      while ($booksCount > 0) {
        $author->books()->save(factory(App\Book::class)->make());
        $booksCount--;
      }
    });
  }
}
