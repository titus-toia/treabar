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
    $invoices = \Auth::user()->company->invoices;
    $projects = \Auth::user()->getProjects();
    return view('invoice', [
      'projects' => $projects,
      'invoices' => $invoices
    ]);
  }

  public function create() {
    echo 'create';
  }

  public function edit() {
    echo 'edit';
  }

  public function destroy() {
    echo 'destroy';
  }
}
