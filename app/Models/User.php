<?php

namespace Treabar\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Treabar\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\Activity[] $activities
 * @property-read \Treabar\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\Project[] $projects
 */
class User extends Authenticatable {
  protected $guarded = [];
  const ROLE_ROOT = 'root';
  const ROLE_MANAGER = 'manager';
  const ROLE_DEV = 'dev';
  const ROLE_CLIENT = 'client';

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function activities() {
    return $this->hasMany('Treabar\Models\Activity');
  }

  public function comments() {
    return $this->hasMany('Treabar\Models\Comment');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

  public function projects() {
    return $this->belongsToMany('Treabar\Models\Project', 'project_users');
  }

  public static function roles() {
    return [
      self::ROLE_ROOT,
      self::ROLE_MANAGER,
      self::ROLE_DEV,
      self::ROLE_CLIENT
    ];
  }

  public function getProjects() {
    if($this->role === self::ROLE_MANAGER || $this->role === self::ROLE_ROOT)
      $projects = $this->company->projects();
    else
      $projects = $this->projects();
    $projects = $projects->orderBy('created_at', 'desc')->get();

    return $projects;
  }

  public function icon() {
    return url('img/users/' . $this->icon);
  }
}
