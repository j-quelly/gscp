<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
  /**
   * Handle a login request to the application.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function postLogin(Request $request)
  {
    try {
      $this->validate($request, [
        'email'    => 'required|email|max:255',
        'password' => 'required',
      ], [
        'email.required'    => 'The email field is required.',
        'email.email'       => 'The email field must be a valid email.',
        'password.required' => 'The password field is required.',
      ]);
    } catch (HttpResponseException $e) {
      return new JsonResponse([
        'error' => [
          'message' => 'Invalid auth',
          'status'  => Response::HTTP_BAD_REQUEST,
        ],
      ], Response::HTTP_BAD_REQUEST);
    }

    $credentials = $this->getCredentials($request);

    try {
      // Attempt to verify the credentials and create a token for the user
      if (!$token = JWTAuth::attempt($credentials)) {
        return new JsonResponse([
          'error' => [
            'message' => 'Invalid credentials',
            'status'  => Response::HTTP_UNAUTHORIZED,
          ],
        ], Response::HTTP_UNAUTHORIZED);
      }
    } catch (JWTException $e) {
      // Something went wrong whilst attempting to encode the token
      return new JsonResponse([
        'error' => [
          'message' => 'Could not create token',
          'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
        ],
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    // All good so return the token
    return new JsonResponse(['data' => [
      'message' => 'Token generated',
      'token'   => $token,
    ]]);
  }

  /**
   * Get the needed authorization credentials from the request.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return array
   */
  protected function getCredentials(Request $request)
  {
    return $request->only('email', 'password');
  }

  /**
   * Invalidate a token.
   *
   * @return \Illuminate\Http\Response
   */
  public function deleteInvalidate()
  {
    $token = JWTAuth::parseToken();

    $token->invalidate();

    return new JsonResponse(['data' => ['message' => 'Token invalidated']]);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\Response
   */
  public function patchRefresh()
  {
    $token = JWTAuth::parseToken();

    $newToken = $token->refresh();

    return new JsonResponse(['data' => [
      'message' => 'Token refreshed',
      'token'   => $newToken,
    ]]);
  }

  /**
   * Get authenticated user.
   *
   * @return \Illuminate\Http\Response
   */
  public function getUser()
  {
    return new JsonResponse([
      'data' => JWTAuth::parseToken()->authenticate(),
    ]);
  }

  /**
   * Create user role.
   *
   * @return \Illuminate\Http\Response
   */
  public function createRole(Request $request)
  {

    $role       = new Role();
    $role->name = $request->input('name');
    $role->save();

    // todo: improve this response
    return response()->json("created");

  }

  /**
   * Create user permission.
   *
   * @return \Illuminate\Http\Response
   */
  public function createPermission(Request $request)
  {

    $viewUsers       = new Permission();
    $viewUsers->name = $request->input('name');
    $viewUsers->save();

    // todo: improve this response
    return response()->json("created");

  }

  /**
   * Assign user role.
   *
   * @return \Illuminate\Http\Response
   */
  public function assignRole(Request $request)
  {
    $user = User::where('email', '=', $request->input('email'))->first();

    $role = Role::where('name', '=', $request->input('role'))->first();
    //$user->attachRole($request->input('role'));
    $user->roles()->attach($role->id);

    // todo: improve this response
    return response()->json("created");
  }

  /**
   * Attach permission to user.
   *
   * @return \Illuminate\Http\Response
   */
  public function attachPermission(Request $request)
  {
    $role       = Role::where('name', '=', $request->input('role'))->first();
    $permission = Permission::where('name', '=', $request->input('name'))->first();
    $role->attachPermission($permission);

    // todo: improve this response
    return response()->json("created");
  }

}
