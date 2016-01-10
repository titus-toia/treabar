<?php

namespace Treabar\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
  const ROLE_ROOT = 'root';
  const ROLE_MANAGER = 'manager';
  const ROLE_DEV = 'dev';
  const ROLE_CLIENT = 'client';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

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
}
