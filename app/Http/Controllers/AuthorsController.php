<?php
namespace App\Http\Controllers;

use App\Author;
use App\Transformer\AuthorTransformer;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
  public function index()
  {
    return $this->collection(
      Author::all(),
      new AuthorTransformer()
    );
  }

  public function show($id)
  {
    return $this->item(
      Author::findorFail($id),
      new AuthorTransformer()
    );
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name'      => 'required',
      'gender'    => 'required',
      'biography' => 'required',
    ]);

    $author = Author::create($request->all());
    $data   = $this->item($author, new AuthorTransformer());

    return response()->json($data, 201);
  }

}
