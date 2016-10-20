<?php

namespace App\Http\Response;

use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

class FractalResponse
{
  /**
   * @var Manager
   */
  private $manager;

  /**
   * @var SerializerAbstract
   */
  private $serializer;

  /**
   * @var Request
   */
  private $request;

  public function __construct(
    Manager $manager,
    SerializerAbstract $serializer,
    Request $request
  ) {
    $this->manager    = $manager;
    $this->serializer = $serializer;
    $this->manager->setSerializer($serializer);
    $this->request = $request;
  }

  public function item($data, TransformerAbstract $transformer, $resourceKey = null)
  {
    return $this->createDataArray(
      new Item($data, $transformer, $resourceKey)
    );
  }

  public function collection($data, TransformerAbstract $transformer, $resourceKey = null)
  {
    return $this->createDataArray(
      new Collection($data, $transformer, $resourceKey)
    );
  }

  private function createDataArray(ResourceInterface $resource)
  {
    return $this->manager->createData($resource)->toArray();
  }

  /**
   * Get the includes from the request if none are passed.
   *
   * @param null $includes
   */
  public function parseIncludes($includes = null)
  {
    if (empty($includes)) {
      $includes = $this->request->query('include', '');
    }

    $this->manager->parseIncludes($includes);
  }
}
