<?php

namespace Treabar\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Treabar\Http\Requests;
use Treabar\Models\Invoice;
use Treabar\Models\Task;

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

  public function create(Task $task) {
    if($task->invoice_id) {
      return redirect()->route('invoice.edit', $task->invoice_id);
    }
    $client = $task->project->client? $task->project->client->name: '';
    $invoice = new Invoice([
      'name' => ($client?: 'Invoice') . ' ' . date('Y-m-d'),
      'issued_at' => date('Y-m-d'),
      'invoiceno' => $task->project->company->invoiceno + 1,
      'client_name' => $client?: '',
      'company_name' => $task->project->company->name,
      'items' => [[
        'name' => $task->name,
        'description' => $task->description,
        'rate' => 10,
        'hours' => round($task->loggedTotal()),
        'total' => 0
      ]],
      'company_id' => $task->project->company_id,
      'client_id' => $task->project->client_id,
      'project_id' => $task->project_id
    ]);
    $task->project->company->update([
      'invoiceno' => $task->project->company->invoiceno + 1
    ]);
    $invoice->save();
    $task->invoice_id = $invoice->id;
    $task->save();

    return view('invoice.editor', ['invoice' => $invoice]);
  }

  public function edit(Invoice $invoice) {
    return view('invoice.editor', ['invoice' => $invoice]);
  }

  public function update(Invoice $invoice) {
    $invoice->update(Input::get('invoice'));
  }

  public function destroy(Invoice $invoice) {
    $invoice->delete();
  }
}
