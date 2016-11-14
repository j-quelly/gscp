<?php

namespace App\Transformer;

use App\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
  /**
   * Transform a permission model into an array
   *
   * @param Permission $permission
   * @return array
   */
  public function transform(Permission $permission)
  {
    return [
      'id'           => $permission->id,
      'name'         => $permission->name,
      'display_name' => $permission->display_name,
      'description'  => $permission->description,
      'created'      => $permission->created_at->toIso8601String(),
      'updated'      => $permission->updated_at->toIso8601String(),
    ];
  }
}
