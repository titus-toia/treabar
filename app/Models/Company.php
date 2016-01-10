<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

  public function projects() {
    return $this->hasMany('Treabar\Models\User');
  }

  public function users() {
    return $this->hasMany('Treabar\Models\User');
  }

  public function invoices() {
    return $this->hasMany('Treabar\Models\Invoice');
  }

}
