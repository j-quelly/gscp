<?php
namespace App\Http\Controllers;

use App\Author;
use App\Transformer\AuthorTransformer;
use Illuminate\Http\Request;

/**
 * Class AuthorsController
 * @package App\Http\Controllers
 */
class AuthorsController extends Controller
{

  /**
   * GET /authors
   * @return array
   */  
  public function index()
  {
    return $this->collection(
      Author::all(),
      new AuthorTransformer()
    );
  }

  /**
   * GET /authors/{id}
   * @param integer $id
   * @return mixed
   */
  public function show($id)
  {
    return $this->item(Author::findOrFail($id), new AuthorTransformer());
  }

  /**
   * POST /authors
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function store(Request $request)
  {
    $this->validateAuthor($request);

    $author = Author::create($request->all());
    $data   = $this->item($author, new AuthorTransformer());

    return response()->json($data, 201, [
      'Location' => route('authors.show', ['id' => $author->id]),
    ]);
  }

  /**
   * PUT /authors/{id}
   * @param Request $request
   * @param $id
   * @return mixed
   */
  public function update(Request $request, $id)
  {
    $this->validateAuthor($request);
    $author = Author::findOrFail($id);

    $author->fill($request->all());
    $author->save();

    $data = $this->item($author, new AuthorTransformer());

    return response()->json($data, 200);
  }

  /**
   * DELETE /authors/{id}
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    Author::findOrFail($id)->delete();

    return response(null, 204);
  }

  /**
   * Validate author updates from the request.
   *
   * @param Request $request
   */
  private function validateAuthor(Request $request)
  {
    $this->validate($request, [
      'name'      => 'required|max:255',
      'gender'    => [
        'required',
        'regex:/^(male|female)$/i',
      ],
      'biography' => 'required',
    ], [
      'name.required'      => 'The name field is required.',
      'name.max'           => 'The name field must be less than 256 characters.',
      'gender.required'    => 'The gender field is required.',
      'gender.regex'       => "Gender format is invalid: must equal 'male' or 'female'",
      'biography.required' => 'The biography field is required.',

    ]);
  }

}
