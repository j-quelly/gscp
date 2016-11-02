<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Application;

class APIController extends Controller
{
  /**
   * Get root url.
   *
   * @return \Illuminate\Http\Response
   */
  public function getIndex(Application $app)
  {
    return new JsonResponse(['data' => ['message' => $app->version()]]);
  }
}
