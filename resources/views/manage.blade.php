@extends('main')
@section('content')
<div id="manage" class="row wrapper">
  <div id="manager-tabs" class="columns large-1">
    <div id="manage-tasks"><a href="#tasks">TASKS</a></div>
    <div id="manage-timesheet"><a href="#timesheet">TIMESHEET</a></div>
    <div id="manage-chart"><a href="#chart">CHART</a></div>
    <div id="manage-feed"><a href="#feed">FEED</a></div>
  </div>
  <div id="manager-page" class="columns large-11">
  </div>
</div>
@endsection