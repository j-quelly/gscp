<?php

namespace App\Transformer;

use App\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
  /**
   * Transform a Role model into an array
   *
   * @param Role $role
   * @return array
   */
  public function transform(Role $role)
  {
    return [
      'id'           => $role->id,
      'name'         => $role->name,
      'display_name' => $role->display_name,
      'description'  => $role->description,
      'created'      => $role->created_at->toIso8601String(),
      'updated'      => $role->updated_at->toIso8601String(),
    ];
  }
}
