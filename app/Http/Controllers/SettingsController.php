<?php

namespace Treabar\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Treabar\Http\Requests;
use Treabar\Models\Activity;
use Treabar\Models\Comment;
use Treabar\Models\Feedable;

class SettingsController extends Controller
{
  public function __construct() {
    view()->share('page', 'settings');
  }

  public function userSettings() {

  }

  public function companySettings() {
    $company = \Auth::user()->company;

    return view()->make('settings.company', [
      'company' => $company,
      'devs' => $company->devs,
      'managers' => $company->managers,
      'clients' => $company->clients
    ]);

  }

  public function updateCompany() {

  }
  public function updateUser() {

  }


}