<?php
namespace Treabar\Models;


use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Symfony\Component\Debug\Exception\FatalErrorException;

abstract class Feedable extends Model implements FeedableInterface {
  const AFTER = 'after';
  const BEFORE = 'before';
  public function content() {
    throw new \BadMethodCallException("Method not implemented");
  }

  public static function ofProject(Project $project, $time = null, $direction = self::BEFORE) {
    $activities = self::feed($project->activities(), $time, $direction, 8);
    $comments = self::feed($project->comments(), $time, $direction, 8);

    if($activities->count() && $comments->count()) {
      $last_activity = $activities->last()->created_at;
      $last_comment = $comments->last()->created_at;

      $condition = $direction == self::BEFORE? ($last_activity > $last_comment): ($last_activity < $last_comment);
      $interval = [$last_comment, $last_activity];
      if($direction != self::BEFORE) $interval = array_reverse($interval);

      if($condition) {
        $activities = $activities->merge(
          $project->activities()->whereBetween('created_at', $interval)->get()
        );
      } else {
        $comments = $comments->merge(
          $project->comments()->whereBetween('created_at', array_reverse($interval))->get()
        );
      }
    }

    $feed = (new Collection($activities))->merge($comments);
    $feed = $feed->sort(function($a, $b) {
      return $a->created_at < $b->created_at;
    });

    return $feed;
  }

  public static function ofProjects(\Illuminate\Database\Eloquent\Collection $projects) {
    return static::whereIn('project_id', $projects->pluck('id'))->orderBy('created_at', 'desc');
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

  public static function feed($eloquent = null, $time = null, $direction = self::BEFORE, $pageSize = 15) {
    if(!$eloquent) $eloquent = static::query();
    $eloquent = $eloquent->orderBy('created_at', 'desc');

    $ineq = $direction == self::BEFORE? '<': '>';
    $query = self::cloneEloquent($eloquent);

    if($time) $query = $query->where('created_at', $ineq, $time);
    $result = $query->take($pageSize)->get();

    if($result->count()) { //Take all siblings in the last time instance, if any.
      $query = self::cloneEloquent($eloquent);
      $last = $result->last();
      $query = $query->where('created_at', '=', $last->created_at)->where('id', '!=', $last->id);
      $siblings = $query->get();
      $result = $result->merge($siblings);
    }

    return $result;
  }

  private static function cloneEloquent($eloquent) {
    if($eloquent instanceof Relation) {
      $query = clone $eloquent->getQuery();
    } else {
      $query = clone $eloquent;
    }

    return $query;
  }
}