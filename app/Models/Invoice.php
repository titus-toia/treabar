<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  public function activities() {
    return $this->hasMany('Models\Activity');
  }

  public function company() {
    return $this->belongsTo('Models\Company');
  }

}
