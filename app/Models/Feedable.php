<?php
namespace Treabar\Models;


use Illuminate\Support\Collection;

abstract class Feedable extends Model implements FeedableInterface {
  public function content() {
    throw new \BadMethodCallException("Method not implemented");
  }

  public static function ofProject(Project $project) {
    $activities = $project->activities;
    $comments = $project->comments;
    $feed = (new Collection($activities))->merge($comments);

    $feed = $feed->sort(function($a, $b) {
      return $a->timestamp() < $b->timestamp();
    });

    return $feed;
  }

  public static function ofProjects(\Illuminate\Database\Eloquent\Collection $projects) {
    return static::whereIn('project_id', $projects->pluck('id'))->orderBy('created_at', 'desc')->simplePaginate(30);
  }

  public static function ofCompany(Company $company) {

  }

  public function project() {
    return $this->belongsTo('Treabar\Models\Project');
  }

  public function task() {
    return $this->belongsTo('Treabar\Models\Task');
  }

  public function timestamp() {
    return $this->created_at;
  }
}