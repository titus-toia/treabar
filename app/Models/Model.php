<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Model
 *
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
  protected $dates = ['created_at', 'updated_at', 'deleted_at', 'from', 'to'];

  public function createdAt() {
    return $this->created_at->format('Y-m-d');
  }

  public function updatedAt() {
    return $this->updated_at->format('Y-m-d');
  }
}
