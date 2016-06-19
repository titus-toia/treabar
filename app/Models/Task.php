<?php

namespace Treabar\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Builder;

/**
 * Task
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\Comment[] $comments
 * @property-read \Treabar\Models\Company $company
 * @property-read \Treabar\Models\Task $parent
 * @property-read \Baum\Extensions\Eloquent\Collection|\Treabar\Models\Task[] $children
 * @method static \Illuminate\Database\Query\Builder|\Treabar\Models\Task master()
 * @method static \Illuminate\Database\Query\Builder|\Baum\Node withoutNode($node)
 * @method static \Illuminate\Database\Query\Builder|\Baum\Node withoutSelf()
 * @method static \Illuminate\Database\Query\Builder|\Baum\Node withoutRoot()
 * @method static \Illuminate\Database\Query\Builder|\Baum\Node limitDepth($limit)
 */
class Task extends Node {

  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'tasks';

  //////////////////////////////////////////////////////////////////////////////

  //
  // Below come the default values for Baum's own Nested Set implementation
  // column names.
  //
  // You may uncomment and modify the following fields at your own will, provided
  // they match *exactly* those provided in the migration.
  //
  // If you don't plan on modifying any of these you can safely remove them.
  //

  // /**
  //  * Column name which stores reference to parent's node.
  //  *
  //  * @var string
  //  */
  // protected $parentColumn = 'parent_id';

  // /**
  //  * Column name for the left index.
  //  *
  //  * @var string
  //  */
  // protected $leftColumn = 'lft';

  // /**
  //  * Column name for the right index.
  //  *
  //  * @var string
  //  */
  // protected $rightColumn = 'rgt';

  // /**
  //  * Column name for the depth field.
  //  *
  //  * @var string
  //  */
  // protected $depthColumn = 'depth';

  // /**
  //  * Column to perform the default sorting
  //  *
  //  * @var string
  //  */
  // protected $orderColumn = null;

  // /**
  // * With Baum, all NestedSet-related fields are guarded from mass-assignment
  // * by default.
  // *
  // * @var array
  // */
  // protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

  //
  // This is to support "scoping" which may allow to have multiple nested
  // set trees in the same database table.
  //
  // You should provide here the column names which should restrict Nested
  // Set queries. f.ex: company_id, etc.
  //

  // /**
  //  * Columns which restrict what we consider our Nested Set list
  //  *
  //  * @var array
  //  */
  protected $scoped = array('project_id');

  //////////////////////////////////////////////////////////////////////////////

  //
  // Baum makes available two model events to application developers:
  //
  // 1. `moving`: fired *before* the a node movement operation is performed.
  //
  // 2. `moved`: fired *after* a node movement operation has been performed.
  //
  // In the same way as Eloquent's model events, returning false from the
  // `moving` event handler will halt the operation.
  //
  // Please refer the Laravel documentation for further instructions on how
  // to hook your own callbacks/observers into this events:
  // http://laravel.com/docs/5.0/eloquent#model-events
  public function activities() {
    return $this->hasMany('Treabar\Models\Activity');
  }

  public function comments() {
    return $this->hasMany('Treabar\Models\Comment');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

  public function project() {
    return $this->belongsTo('Treabar\Models\Project');
  }

  public function user() {
    return $this->belongsTo('Treabar\Models\User');
  }

  public function scopeMaster(Builder $query) {
    return $query->where('parent_id', null);
  }

  public function logged() {
    return floor($this->activities->sum('duration') / 3600);
  }


  public function loggedTotal($date = null) {
    $activities = $this->activities();
    if($date) {
      $activities = $activities->where('created_at', '>=', new \DateTime($date))->get();
    } else {
      $activities = $activities->get();
    }
    $children = $this->children;
    foreach($children as $child) {
      if($date) {
        $activities_child = $child->activities()->where('created_at', '>=', new \DateTime($date))->get();
      } else {
        $activities_child = $child->activities()->get();
      }
      $activities = $activities->merge($activities_child);
    }
    return $activities->sum('duration') / 3600;
  }

  public function durationReadable() {
    return $this->duration . 'h';
  }

  public function completion() {
    return $this->loggedTotal() / $this->duration * 100;
  }

  public function getLeafCount() {
    return $this->leaves()->count();
  }

  public function getLeafOvertime() {
    $leaves = $this->leaves()->get();
    $overtime = 0;
    foreach($leaves as $leaf) {
      if($leaf->duration && $leaf->logged() > $leaf->duration) {
        $overtime+= $leaf->logged() - $leaf->duration;
      }
    }
  }

  public function getTrunkOvertime() {
    $trunks = $this->trunks()->get();
    $overtime = 0;
    foreach($trunks as $trunk) {
      if($trunk->duration && $trunk->loggedTotal() > $trunk->duration) {
        $overtime+= $trunk->loggedTotal() - $trunk->duration;
      }
    }
  }
}
