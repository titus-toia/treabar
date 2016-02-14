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
    return $this->content;
  }

  public function user() {
    return $this->belongsTo('Treabar\Models\User');
  }
}
