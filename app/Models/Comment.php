<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Comment
 *
 * @property-read \Treabar\Models\Task $task
 * @property-read \Treabar\Models\User $user
 */
class Comment extends Model {
  public function task() {
    return $this->belongsTo('Treabar\Models\Task');
  }

  public function user() {
    return $this->belongsTo('Treabar\Models\User');
  }

}
