<?php

namespace App\Http\Controllers;

use App\Book;
use App\Transformer\BookTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Class BooksController
 * @package App\Http\Controllers
 */
class BooksController extends Controller
{
  
/**
 * GET /books
 * @return array
 */
  public function index()
  {
    return $this->collection(Book::all(), new BookTransformer());
  }

/**
 * GET /books/{id}
 * @param integer $id
 * @return mixed
 */
  public function show($id)
  {
    return $this->item(Book::findOrFail($id), new BookTransformer());
  }

  /**
   * POST /books
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function store(Request $request)
  {
    $this->validateBook($request);

    $book = Book::create($request->all());
    $data = $this->item($book, new BookTransformer());

    return response()->json($data, 201, [
      'Location' => route('books.show', ['id' => $book->id]),
    ]);
  }

  /**
   * PUT /books/{id}
   * @param Request $request
   * @param $id
   * @return mixed
   */
  public function update(Request $request, $id)
  {
    try {
      $book = Book::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'error' => [
          'message' => 'Book not found',
        ],
      ], 404);
    }

    $this->validateBook($request);

    $book->fill($request->all());
    $book->save();

    return $this->item($book, new BookTransformer());
  }

  /**
   * DELETE /books/{id}
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    try {
      $book = Book::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'error' => [
          'message' => 'Book not found',
        ],
      ], 404);
    }

    $book->delete();

    return response(null, 204);
  }

  /**
   * Validate book updates from the request.
   *
   * @param Request $request
   */
  private function validateBook(Request $request)
  {
    $this->validate($request, [
      'title'       => 'required|max:255',
      'description' => 'required',
      'author_id'   => 'required|exists:authors,id',
    ], [
      'description.required' => 'Please fill out the description.',
    ]);
  }  

}
