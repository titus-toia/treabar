<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Company
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\Invoice[] $invoices
 */
class Company extends Model {
  protected $guarded = [];
  public function projects() {
    return $this->hasMany('Treabar\Models\Project');
  }

  public function users() {
    return $this->hasMany('Treabar\Models\User');
  }

  public function clients() {
    return $this->users()->where('role', User::ROLE_CLIENT);
  }

  public function devs() {
    return $this->users()->where('role', User::ROLE_DEV);
  }

  public function managers() {
    return $this->users()->where('role', User::ROLE_MANAGER);
  }

  public function invoices() {
    return $this->hasMany('Treabar\Models\Invoice')->with('project');
  }

}
