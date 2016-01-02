<?php

namespace Treabar\Http\Controllers;

use Illuminate\Http\Request;

use Treabar\Http\Requests;
use Treabar\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index() {
    return view('dashboard');
  }
}
