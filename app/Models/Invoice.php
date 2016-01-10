<?php

namespace Treabar\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  public function activities() {
    return $this->hasMany('Treabar\Models\Activity');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

}
