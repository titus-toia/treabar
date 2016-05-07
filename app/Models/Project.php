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
  const COLOR_COUNT = 5;
  public function activities() {
    return $this->hasMany('Treabar\Models\Activity')->orderBy('id', 'desc');
  }

  public function comments() {
    return $this->hasMany('Treabar\Models\Comment');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

  public function tasks($topLevel = false) {
    $relation = $this->hasMany('Treabar\Models\Task');
    return $topLevel? $relation->master(): $relation;
  }

  public function users() {
    return $this->belongsToMany('Treabar\Models\User', 'project_users');
  }

  public function getTaskHierarchies() {
    $tasks = $this->tasks(true)->get()->map(function($task) {
      return $task->getDescendantsAndSelf()->toHierarchy()->first();
    });
    return $tasks;
  }

  public function logged($mins = false) {
    return floor($this->activities->sum('duration') / 3600);
  }

}
