@extends('main')
@section('content')
  <style>
    #invoice-page {
      padding-top: 15px;
      padding-right: 15px;
    }
    #invoice-list {
      padding-left: 45px;
      list-style-type: none;
      margin: 0;
    }
    #invoice-list .invoice {
      float: left;
      display: inline-block;
      height: 150px;
      width: 150px;
      margin-right: 20px;
      margin-bottom: 10px;
      border: 2px solid whitesmoke;
      border-left-width: 0;
      background-color: whitesmoke;
      cursor: pointer;
    }
    #invoice-list .invoice .banner {
      width: 10px;
      height: calc(100% - 15px);
      float: left;
    }
    #invoice-list .invoice .preview {
      padding: 3px;
      overflow: hidden;
      height: calc(100% - 15px);
      width: calc(100% - 10px);
      white-space: nowrap;
    }
    #invoice-list .invoice .date {
      float: right;
      display: inline-block;
      font-size: 10px;
      text-align: right;
    }
    #invoice-list .invoice dl {
      font-size: 11px;
    }

    #invoice-list .invoice dt {
      margin-bottom: 3px;
    }
    #invoice-list .invoice dd {
      margin-bottom: 6px;
    }
  </style>
  <div id="invoice" class="row wrapper">
    <div id="invoice-page" class="columns large-12">
      <ul id="invoice-list">
      @foreach($invoices as $invoice)
        <div class="invoice">
          <div class="banner color-{{ $invoice->project->color }}" data-color="color-{{ $invoice->project->color }}"></div>
          <div class="preview">
            <span class="date">{{ $invoice->issued_at  }}</span>
            <dl>
              <dt>Client</dt>
              <dd>{{ $invoice->client }}</dd>
              <dt>Hours</dt>
              <dd class="hours">{{ $invoice->total()['hours'] }}h</dd>
              <dt>Amount billed</dt>
              <dd class="total">${{ $invoice->total()['total'] }}</dd>
            </dl>
          </div>
          <span class="name caption"></span>
        </div>
      @endforeach
      </ul>
    </div>
  </div>
@endsection