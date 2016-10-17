<?php
namespace App\Http\Controllers;

use App\Author;
use App\Transformer\AuthorTransformer;

class AuthorsController extends Controller
{
  public function index()
  {
    return $this->collection(
      Author::all(),
      new AuthorTransformer()
    );
  }
}
