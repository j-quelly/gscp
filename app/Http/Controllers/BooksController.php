<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class BooksController
 * @package App\Http\Controllers
 */
class BooksController
{
/**
 * GET /books
 * @return array
 */
  public function index()
  {
    return Book::all();
  }

/**
 * GET /books/{id}
 * @param integer $id
 * @return mixed
 */
  public function show($id)
  {
    try {
      return Book::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'error' => [
          'message' => 'Book not found',
        ],
      ], 404);
    }
  }

/**
 * POST /books
 * @param Request $request
 * @return \Symfony\Component\HttpFoundation\Response
 */
  public function store(Request $request)
  {
    $book = Book::create($request->all());
    return response()->json(['created' => true], 201);
  }

}
