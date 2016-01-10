<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  public function task() {
    return $this->belongsTo('Models/Task');
  }

  public function user() {
    return $this->belongsTo('Models/User');
  }

  public function project() {
    return $this->belongsTo('Models/Project');
  }

  public function invoice() {
    return $this->belongsTo('Models\Invoice');
  }

}
