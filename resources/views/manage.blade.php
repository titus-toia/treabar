@extends('main')
@section('content')
<div id="manage" class="row wrapper">
  <div id="manager-tabs" class="columns large-1">
      <div id="manage-tasks"><a href="#tasks">TASKS</a></div>
      <div id="manage-timesheet"><a href="#timesheet">TIMESHEET</a></div>
      <div id="manage-chart"><a href="#chart">CHART</a></div>
      <div id="manage-feed"><a href="#feed">FEED</a></div>
  </div>
  <div id="manager-projects" class="columns large-11">
    <ul id="manager-projects-list">
      <li>
        <div class="manager-project">
          <div class="left">
            <span class="name">IOS Project</span>
            <span class="date">2015-09-15</span>
            <ul class="people">
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
            </ul>
            <div class="clearfix"></div>
            <span class="tracked">Tracked %hrs% hours.</span>
          </div>
          <div class="banner color-1"></div>
        </div>
      </li>
      <li>
        <div class="manager-project">
          <div class="left">
            <span class="name">UX Design</span>
            <span class="date">2015-09-15</span>
            <ul class="people">
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
              <li><img src="http://lorempixel.com/30/35/people/" /></li>
            </ul>
            <span class="tracked">Tracked %hrs% hours.</span>
          </div>
          <div class="banner color-2"></div>
        </div>
      </li>
    </ul>
  </div>
</div>
@endsection
