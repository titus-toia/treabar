<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

  public function tasks() {
    return $this->hasMany('Treabar\Models\Task');
  }

  public function users() {
    return $this->belongsToMany('Treabar\Models\User', 'project_users');
  }

}
