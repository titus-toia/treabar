<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

  public function projects() {
    return $this->hasMany('Models\User');
  }

  public function users() {
    return $this->hasMany('Models\User');
  }

  public function invoices() {
    return $this->hasMany('Models\Invoice');
  }

}
