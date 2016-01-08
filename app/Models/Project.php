<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  public function company() {
    return $this->belongsTo('Models\Company');
  }

  public function tasks() {
    return $this->hasMany('Models\Task');
  }

  public function users() {
    return $this->belongsToMany('Models\User');
  }
}
