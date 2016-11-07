<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
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
        'email.required' => 'The email field is required.',
        'email.email' => 'The email field must be a valid email.', 
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
}
