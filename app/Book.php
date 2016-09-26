<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

  public $table = 'book';

/**
 * The attributes that are mass assignable
 *
 * @var array 
 */
  protected $fillable = ['title', 'description', 'author'];

}
