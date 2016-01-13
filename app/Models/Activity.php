<?php

namespace Treabar\Models;

class Activity extends Model
{
  public function task() {
    return $this->belongsTo('Treabar\Models\Task');
  }

  public function user() {
    return $this->belongsTo('Treabar\Models\User');
  }

  public function project() {
    return $this->belongsTo('Treabar\Models\Project');
  }

  public function invoice() {
    return $this->belongsTo('Treabar\Models\Invoice');
  }

}
