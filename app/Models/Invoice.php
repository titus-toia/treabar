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
  protected $casts = [
    'items' => 'object'
  ];

  public function project() {
    return $this->belongsTo('Treabar\Models\Project');
  }

  public function activities() {
    return $this->hasMany('Treabar\Models\Activity');
  }

  public function company() {
    return $this->belongsTo('Treabar\Models\Company');
  }

  public function total() {
    $hours = 0;
    $total = 0;
    foreach($this->items as $item) {
      $hours += $item->hours;
      $total += $item->total;
    }

    return [
      'hours' => $hours,
      'total' => $total
    ];
  }
}
