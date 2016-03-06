<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Comment
 *
 * @property-read \Treabar\Models\Task $task
 * @property-read \Treabar\Models\User $user
 */
class Comment extends Feedable {
  public function content() {
    return "{$this->user->name} commented on task {$this->task->name}.";
  }

  public function icon() {
    return 'comment';
  }

  public function user() {
    return $this->belongsTo('Treabar\Models\User');
  }
}
