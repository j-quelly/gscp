<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{

  /**
   * Transform an author model
   *
   * @param Author $author
   * @return array
   */
  public function transform(Author $author)
  {
    return [
      'id'        => $author->id,
      'name'      => $author->name,
      'gender'    => $author->gender,
      'biography' => $author->biography,
      'created'   => $author->created_at->toIso8601String(),
      'updated'   => $author->created_at->toIso8601String(),
    ];
  }
}
