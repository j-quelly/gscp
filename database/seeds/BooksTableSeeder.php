<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BooksTableSeeder extends Seeder
{
/**
 * Run the database seeds.
 *
 * @return void
 */
  public function run()
  {
    DB::table('book')->insert([
      'title'       => 'War of the Worlds',
      'description' => 'A science fiction masterpiece about Martians invading London',
      'author'      => 'H. G. Wells',
      'created_at'  => Carbon::now(),
      'updated_at'  => Carbon::now(),
    ]);

    DB::table('book')->insert([
      'title'       => 'A Wrinkle in Time',
      'description' => 'A young girl goes on a mission to save her father \
 who has gone missing after working on a mysterious project called a tesseract.',
      'author'      => 'Madeleine L\'Engle',
      'created_at'  => Carbon::now(),
      'updated_at'  => Carbon::now(),
    ]);
  }
}
