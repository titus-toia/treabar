<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Project
 *
 * @property-read \Treabar\Models\Company $company
 * @property-read \Baum\Extensions\Eloquent\Collection|\Treabar\Models\Task[] $tasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\User[] $users
 */
class Project extends Model
{
  public function activities() {
    return $this->hasManyThrough('Treabar\Models\Activity', 'Treabar\Models\Task');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

  public function tasks() {
    return $this->hasMany('Treabar\Models\Task')->master();
  }

  public function users() {
    return $this->belongsToMany('Treabar\Models\User', 'project_users');
  }

  public function logged($mins = false) {
    return floor($this->activities->sum('duration') / 3600);
  }

}
