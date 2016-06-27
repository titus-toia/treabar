@extends('main')
@section('content')
  <style>
    #invoice-page {
      padding-left: 0;
      padding-top: 15px;
      padding-right: 15px;
    }
    #invoice-list {
      padding-left: 55px;
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
    #invoice-list .invoice:hover {
      background-color: #e8e8e8;
    }
    #invoice-list .invoice .banner {
      width: 10px;
      height: calc(100% - 15px);
      float: left;
    }
    #invoice-list .caption {
      text-align: center;
      display: block;
      font-size: 10px;
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

    #invoice-controls {
      position: relative;
      float: left;
    }

    #invoice-controls .filter {
      width: 89px;
      top: 46px;
      left: 25px;
      padding-top: 4px;
      padding-right: 4px;
    }
    #invoice-controls .project-picker {
      width: 400px;
      left: 51px;
      top: 1px;
      position: absolute;
      padding: 5px 10px;
      background-color: white;
      text-align: center;
      z-index: 5;

      -webkit-box-shadow: 6px 6px 2px 1px rgba(0,0,0,0.75);
      -moz-box-shadow: 6px 6px 2px 1px rgba(0,0,0,0.75);
      box-shadow: 6px 6px 2px 1px rgba(0,0,0,0.75);
    }
  </style>
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
              <dd>{{ $invoice->client }}</dd>
              <dt>Hours</dt>
              <dd class="hours">{{ $invoice->total()['hours'] }}h</dd>
              <dt>Amount billed</dt>
              <dd class="total">${{ $invoice->total()['total'] }}</dd>
            </dl>
          </div>
          <span class="name caption">{{ $invoice->name }}</span>
        </div>
      @endforeach
      </ul>
    </div>
  </div>
@endsection