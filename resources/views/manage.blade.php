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
    <div id="manager-projects-list-wrapper" class="frame">
      <ul id="manager-projects-list" class="slidee">
        @for($i = 1; $i <= 10; $i++)
          <li>
            <div class="manager-project" data-id="{{ $i }}">
              <div class="left">
                <span class="name">Project Name</span>
                <span class="date">{{ date('Y-m-d', strtotime('-1 month'))  }}</span>
                <ul class="people">
                  @for($keys = array_rand(range(1, 7), rand(2, 4)), $j = 0; $j < count($keys); $j++)
                    <li><img height="35" width="35"
                             src="{{ url('images/dev/user-' . range(1, 7)[$keys[$j]] . '.jpg') }}"/></li>
                  @endfor
                </ul>
                <div class="clearfix"></div>
                <span class="tracked">Tracked {{ rand(10, 150) }} hours.</span>
              </div>
              <div class="banner color-{{ rand(1, 5) }}"></div>
            </div>
          </li>
        @endfor
      </ul>
    </div>
    <div class="scrollbar"><div class="handle"></div></div>
    <div id="bridge"></div>
    <div id="current-project" class="columns large-12">Project Info
      @for($i = 1; $i <= 10; $i++)
      <div class="current-project-listing" data-id="{{ $id }}">
        Stuff about this project
      </div>
      @endfor
    </div>
  </div>
</div>
@endsection
