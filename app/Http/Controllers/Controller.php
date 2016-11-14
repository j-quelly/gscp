<?php

namespace App\Http\Controllers;

use App\Http\Response\FractalResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;

class Controller extends BaseController
{
  /**
   * @var FractalResponse
   */
  private $fractal;

  public function __construct(FractalResponse $fractal)
  {
    $this->fractal = $fractal;
    $this->fractal->parseIncludes();
  }

  /**
   * @param $data
   * @param TransformerAbstract $transformer
   * @param null $resourceKey
   * @return array
   */
  public function item($data, TransformerAbstract $transformer, $resourceKey = null) {
    return $this->fractal->item($data, $transformer, $resourceKey);
  } 

  /**
   * @param $data
   * @param TransformerAbstract $transformer
   * @param null $resourceKey
   * @return array
   */
  public function collection($data, TransformerAbstract $transformer, $resourceKey = null) {
    return $this->fractal->collection($data, $transformer, $resourceKey);
  }

  /**
   * Validate user updates from the request.
   *
   * @param Request $request
   */
  protected function validateUser(Request $request)
  {
    $this->validate($request, [
      'email'    => 'required|email|max:255',
      'password' => 'required|min:8',
    ], [
      'email.required'    => 'The email field is required.',
      'email.email'       => 'The email field must be a valid email.',
      'email.max'         => 'The email field must be less than 256 characters.',
      'password.required' => 'The password field is required.',
      'password.min'      => 'The password field must be more than 8 characters.',
    ]);
  }
}
