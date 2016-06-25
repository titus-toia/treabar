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

  public function projects() {
    return $this->hasMany('Treabar\Models\Project');
  }

  public function users() {
    return $this->hasMany('Treabar\Models\User');
  }

  public function invoices() {
    return $this->hasMany('Treabar\Models\Invoice')->with('project');
  }

}
