<?php

namespace Treabar\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Treabar\Http\Requests;
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
  public function store() {
    echo 'creating';
  }

  public function edit(Invoice $invoice) {
    return view('invoice.editor', ['invoice' => $invoice]);
  }

  public function update(Invoice $invoice) {
    $invoice->update(Input::get('invoice'));
  }

  public function destroy(Invoice $invoice) {
    echo 'destroy';
  }
}
