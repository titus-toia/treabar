<?php
namespace Treabar\Models;

use Illuminate\Database\Eloquent\Collection;

abstract class Feedable extends Model implements FeedableInterface {
  public function content() {
    throw new \BadMethodCallException("Method not implemented");
  }

  public static function ofProject(Project $project) {
    $activities = $project->activities;
    $comments = $project->comments;
    $feed = (new Collection())->merge($activities)->merge($comments);

    return $feed;
  }

  public static function ofCompany(Company $company) {

  }

  public function project() {
    return $this->belongsTo('Treabar\Models\Project');
  }

  public function task() {
    return $this->belongsTo('Treabar\Models\Task');
  }
}