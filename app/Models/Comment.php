<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
  public function task() {
    return $this->belongsTo('Treabar\Models\Task');
  }

  public function user() {
    return $this->belongsTo('Treabar\Models\User');
  }

}
