<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{

/**
 * GET /user
 * @return array
 */
  public function index()
  {
    return $this->collection(Book::all(), new BookTransformer());
  }

  /**
   * Retrieve the user for the given ID.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    return User::findOrFail($id);
  }
}
