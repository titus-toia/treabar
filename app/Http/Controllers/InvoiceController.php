<?php

namespace Treabar\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use Treabar\Http\Requests;
use Treabar\Http\Controllers\Controller;
use Treabar\Models\Invoice;

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
    return view('invoice.editor');
  }

  public function store() {
    echo 'create';
  }

  public function edit(Invoice $invoice) {
    return view('invoice.editor');
  }

  public function update(Invoice $invoice) {
    echo 'create';
  }

  public function destroy(Invoice $invoice) {
    echo 'destroy';
  }
}
