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
      background-color: whitesmoke;
      cursor: pointer;
    }
    #invoice-list .invoice .banner {
      width: 10px;
      height: 140px;
      float: left;
    }
    #invoice-list .invoice .preview {
      overflow: hidden;
      height: 140px;
      width: 140px;
      white-space: nowrap;
    }
  </style>
  <div id="invoice" class="row wrapper">
    <div id="invoice-page" class="columns large-12">
      <ul id="invoice-list">
      @foreach($invoices as $invoice)
        <div class="invoice">
          <div class="banner color-{{ $invoice->project->color }}" data-color="color-{{ $invoice->project->color }}"></div>
          <div class="preview">
            <span class="hours">{{ $invoice->total()['hours'] }}h</span>
            <span class="total">${{ $invoice->total()['total'] }}</span>
          </div>
          <span class="name caption"></span>
        </div>
      @endforeach
      </ul>
    </div>
  </div>
@endsection