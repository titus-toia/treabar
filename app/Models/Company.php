<?php

namespace Treabar\Models;

class Company extends Model {

  public function projects() {
    return $this->hasMany('Treabar\Models\Project');
  }

  public function users() {
    return $this->hasMany('Treabar\Models\User');
  }

  public function invoices() {
    return $this->hasMany('Treabar\Models\Invoice');
  }

}
