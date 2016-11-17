<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\Transformer\PermissionTransformer;
use App\Transformer\RoleTransformer;
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
      $this->validateUser($request);
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

    $this->validateRoles($request);

    $role               = new Role();
    $role->name         = $request->input('name');
    $role->display_name = $request->input('display_name');
    $role->description  = $request->input('description');
    $role->save();

    $data = $this->item($role, new RoleTransformer());

    return $data;

  }

  /**
   * Create user permission.
   *
   * @return \Illuminate\Http\Response
   */
  public function createPermission(Request $request)
  {

    $this->validateRoles($request);

    $viewUsers               = new Permission();
    $viewUsers->name         = $request->input('name');
    $viewUsers->display_name = $request->input('display_name');
    $viewUsers->description  = $request->input('description');
    $viewUsers->save();

    $data = $this->item($viewUsers, new PermissionTransformer());

    return $data;

  }

  /**
   * Assign user role.
   *
   * @return \Illuminate\Http\Response
   */
  public function assignRole(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|max:255|email|exists:users,email',
      'role'  => 'required|exists:roles,name',
    ], [
      'email.required' => 'The email field is required.',
      'email.email'    => 'The email field must be a valid email.',
      'email.max'      => 'The email field must be less than 256 characters.',
      'role.required'  => 'The role field is required.',
    ]);

    $user = User::where('email', '=', $request->input('email'))->first();
    $role = Role::where('name', '=', $request->input('role'))->first();
    $user->roles()->attach($role->id);

    return new JsonResponse(['data' => [
      'message' => 'Created',
    ]]);
  }

  /**
   * Attach permission to user.
   *
   * @return \Illuminate\Http\Response
   */
  public function attachPermission(Request $request)
  {
    $this->validate($request, [
      'role' => 'required|exists:roles,name',
      'name' => 'required|exists:permissions,name',
    ], [
      'role.required' => 'The role field is required.',
      'name.required' => 'The name field is required.',
    ]);

    $role       = Role::where('name', '=', $request->input('role'))->first();
    $permission = Permission::where('name', '=', $request->input('name'))->first();
    $role->attachPermission($permission);

    return new JsonResponse(['data' => [
      'message' => 'Created',
    ]]);
  }

  /**
   * Validate auth posts from the request.
   *
   * @param Request $request
   */
  private function validateRoles(Request $request)
  {
    $this->validate($request, [
      'name'         => 'required',
      'display_name' => 'required',
      'description'  => 'required',
    ], [
      'name.required'         => 'The name field is required.',
      'display_name.required' => 'The display_name field is required.',
      'description.required'  => 'The description field is required.',
    ]);
  }

}
