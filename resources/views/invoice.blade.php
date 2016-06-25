@extends('main')
@section('content')
  <style>
    #invoice-page {
      padding-top: 15px;
      padding-right: 30px;
    }
    #invoice-list {
      padding-left: 30px;
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
      background-color: bisque;
    }
  </style>
  <div id="invoice" class="row wrapper">
    <div id="invoice-page" class="columns large-12">
      <ul id="invoice-list">
      @foreach($invoices as $invoice)
        <div class="invoice">
          <div class="banner"></div>
          <div class="preview">

          </div>
          <span class="name caption"></span>
        </div>
      @endforeach
      </ul>
    </div>
  </div>
@endsection