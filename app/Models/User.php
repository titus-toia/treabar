<?php

namespace Treabar\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
  const ROLE_ROOT = 'root';
  const ROLE_ADMIN = 'admin';
  const ROLE_DEV = 'dev';
  const ROLE_CLIENT = 'client';
  const ROLE_MASTER_CLIENT = 'master_client';

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

  public function company() {
    return $this->belongsTo('Models/Company');
  }

  public function projects() {
    return $this->belongsToMany('Models\Project');
  }

  public static function roles() {
    return [
      self::ROLE_ROOT,
      self::ROLE_ADMIN,
      self::ROLE_DEV,
      self::ROLE_CLIENT,
      self::ROLE_MASTER_CLIENT
    ];
  }
}
