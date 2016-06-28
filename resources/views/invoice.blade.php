@extends('main')
@section('content')
  <div id="invoice" class="row wrapper">
    <div id="invoice-page" class="columns large-12">
      <div id="invoice-controls">
        <div class="vertical-button-control filter">
          <span><i class="fi-filter"></i>&nbsp;&nbsp;Filter</span>
        </div>
        <div class="project-picker hide">
          @foreach($projects as $project)
            <span class="project-label color-{{ $project->color }}" data-id="{{ $project->id }}">{{ $project->name }}</span>
          @endforeach
        </div>
      </div>
      <ul id="invoice-list">
      @foreach($invoices as $invoice)
        <div class="invoice" data-project-id="{{ $invoice->project_id }}">
          <div class="banner color-{{ $invoice->project->color }}" data-color="color-{{ $invoice->project->color }}"></div>
          <div class="preview">
            <span class="date">{{ $invoice->issued_at  }}</span>
            <dl>
              <dt>Client</dt>
              <dd>{{ $invoice->client_name }}</dd>
              <dt>Hours</dt>
              <dd class="hours">{{ $invoice->total()['hours'] }}h</dd>
              <dt>Amount billed</dt>
              <dd class="total">${{ $invoice->total()['total'] }}</dd>
            </dl>
            <div class="actions">
              <a class="edit" href="#" data-ajax-interact data-display="blank"
                 data-url="{{ route('invoice.edit', ['invoice' => $invoice->id]) }}">
                <i class="fi-page-edit"></i>
              </a><br>
              <a class="delete" href="#" data-ajax-interact data-method="delete"
                 data-display="reload"
                 data-url="{{ route('invoice.delete', ['invoice' => $invoice->id]) }}"
                 data-confirm="Are you sure you want to delete this invoice?">
                <i class="fi-trash"></i>
              </a>
            </div>
          </div>
          <span class="name caption">{{ $invoice->name }}</span>
        </div>
      @endforeach
      </ul>
    </div>
  </div>
@endsection