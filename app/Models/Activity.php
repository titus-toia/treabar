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
class Activity extends Feedable {
  protected $dates = ['started_at', 'created_at', 'updated_at', 'deleted_at'];
  protected $guarded = [];
  const TYPE_ACTIVITY = 'activity';
  const TYPE_COMPLETION = 'completion';

  public function content() {
    if($this->type === self::TYPE_ACTIVITY) {
      return "{$this->user->name} logged {$this->duration()} in task {$this->task->name}.";
    } else if($this->type === self::TYPE_COMPLETION) {
      return "{$this->user->name} completed task {$this->task->name}.";
    } else {
      return $this->description;
    }
  }

  public function icon() {
    if($this->type === self::TYPE_ACTIVITY) {
      return 'clock';
    } else if($this->type === self::TYPE_COMPLETION) {
      return 'check';
    } else {
      try {
        return $this->user->icon();
      } catch(\Exception $e) {
        return 'torso';
      }
    }
  }

  public function timestamp() {
    return $this->started_at->addSeconds($this->duration);
  }

  public function user() {
    return $this->belongsTo('Treabar\Models\User');
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
    return $hours? "{$hours}h {$minutes}m": "{$minutes}m";
  }
}
