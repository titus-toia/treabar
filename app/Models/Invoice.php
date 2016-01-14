<?php

namespace Treabar\Models;

/**
 * Treabar\Models\Invoice
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Treabar\Models\Activity[] $activities
 * @property-read \Treabar\Models\Company $company
 */
class Invoice extends Model
{
  public function activities() {
    return $this->hasMany('Treabar\Models\Activity');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

}
