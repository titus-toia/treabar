<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Model
 *
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
  public function createdAt() {
    return $this->created_at->format('Y-m-d');
  }

  public function updatedAt() {
    return $this->updated_at->format('Y-m-d');
  }
}
