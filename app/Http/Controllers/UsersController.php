<?php

namespace App\Http\Controllers;

use App\Transformer\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends Controller
{

/**
 * GET /user
 * @return array
 */
  public function index()
  {
    return $this->collection(User::all(), new UserTransformer());
  }

/**
 * GET /users/{id}
 * @param integer $id
 * @return mixed
 */
  public function show($id)
  {
    return $this->item(User::findOrFail($id), new UserTransformer());
  }

  /**
   * POST /users
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'email'       => 'required|email|max:255',
      'password'    => 'required|min:8',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = app('hash')->make($request->password);
    $user->remember_token = str_random(10);
    $user->save();

    $data = $this->item($user, new UserTransformer());

    return response()->json($data, 201, [
      'Location' => route('users.show', ['id' => $user->id]),
    ]);
  }  

  /**
   * PUT /users/{id}
   * @param Request $request
   * @param $id
   * @return mixed
   */
  public function update(Request $request, $id)
  {
    try {
      $user = User::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'error' => [
          'message' => 'User not found',
        ],
      ], 404);
    }

    // todo: validate name?
    $this->validate($request, [
      'email'       => 'required|email|max:255',
      'password'    => 'required|min:8',
    ]);    

    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = app('hash')->make($request->password);
    $user->update();

    return $this->item($user, new UserTransformer());
  }  

  /**
   * DELETE /users/{id}
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    try {
      $user = User::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'error' => [
          'message' => 'User not found',
        ],
      ], 404);
    }

    $user->delete();

    return response(null, 204);
  }  
}
