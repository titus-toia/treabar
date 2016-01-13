<?php

namespace Treabar\Models;

class Project extends Model
{
  public function activities() {
    return $this->hasManyThrough('Treabar\Models\Activity', 'Treabar\Models\Task');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

  public function tasks() {
    return $this->hasMany('Treabar\Models\Task');
  }

  public function users() {
    return $this->belongsToMany('Treabar\Models\User', 'project_users');
  }

  public function logged() {
    return floor($this->activities->sum('duration') / 3600);
  }

}
