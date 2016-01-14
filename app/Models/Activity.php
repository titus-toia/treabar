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
