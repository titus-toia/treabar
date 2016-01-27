<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Activity
 *
 * @property-read \Treabar\Models\Task $task
 * @property-read \Treabar\Models\User $user
 * @property-read \Treabar\Models\Project $project
 * @property-read \Treabar\Models\Invoice $invoice
 */
class Activity extends Model
{
  protected $dates = ['started_at', 'created_at', 'updated_at', 'deleted_at'];

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

  public function startedAt() {
    return $this->started_at->format('H:i');
  }

  public function finishedAt() {
    return $this->started_at->addSeconds($this->duration)->format('H:i');
  }

  public function duration() {
    $hours = floor($this->duration / 3600);
    $minutes = floor(($this->duration % 3600) / 60);
    return "{$hours}h {$minutes}m";
  }
}
