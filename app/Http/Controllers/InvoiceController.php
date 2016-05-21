<?php

namespace Treabar\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use Treabar\Http\Requests;
use Treabar\Http\Controllers\Controller;

class InvoiceController extends Controller {
  public function __construct() {
    view()->share('page', 'invoices');
  }

  public function index() {
    return view('manage')->with('invoice', []);
  }
}
