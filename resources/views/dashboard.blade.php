@extends('main')
@section('content')
  <style>
    #dashboard .projects {
      overflow-y: scroll;
    }
    .dashboard-project {
      padding-bottom: 10px !important;
      border-bottom: 2px solid #bbb;
    }
    .dashboard-project .header {
      padding-top: 15px;
    }
    .dashboard-project .header .banner {
      height: 85px;
      width: 7px;
    }
    .dashboard-project .header .info {
      width: calc(100% - 7px);
      padding-left: 5px;
    }
    .dashboard-project .tasks {
      padding-top: 15px;
    }
    .dashboard-project .header .info .name {
      font-weight: lighter;
      font-size: 18px;
      white-space: nowrap;
      overflow: hidden;
    }
    .dashboard-project .header span {
      display: block;
      font-size: 13px;
    }
    .dashboard-project .tasks-list-wrapper {
      list-style: none;
      width: 100%;
      margin: 0 0 0 15px;
    }
    .dashboard-project ul.tasks-list {
      margin: 0;
    }
    .dashboard-project ul.tasks-list li {
      float: left;
      margin-right: 10px;
      display: inline-block;
    }
    .dashboard-project .task {
      position: relative;
      height: 65px;
      width: 65px;
      cursor: pointer;
      font-size: 9px;
      border: 2px solid #bbb;
      overflow: visible;
      text-align: center;
      line-height: 11px;
      padding: 1px 1px;

      user-select: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none
    }

    .dashboard-project .task .selected {
      border-color: #ffbf00;
    }
    .dashboard-project .task span {
      display: block;
    }
    .dashboard-project .task .completion {
      position: absolute;
      left: -2px;
      bottom: 0;
      width: calc(100% + 4px);
      background-color: #3498db;
    }
    .dashboard-project .scrollbar {
      width: 100%;
      height: 3px;
    }

    .dashboard-project .scrollbar .handle {
      width: 100px;
      height: 100%;
      background: #aaa;
    }
  </style>
  <div id="dashboard" class="row wrapper">
    <div class="large-8 columns main projects">
      @each('partials.dashboard-task', $projects, 'project', 'partials.dashboard-empty')
    </div>
    <aside class="large-4 columns notifications">
      <ul class="tabs" data-tab>
        <li class="tab-title active"><a href="#discussion-panel">DISCUSSION
            <div class="tab-pedestal"></div>
          </a></li>
        <li class="tab-title"><a href="#activity-panel">ACTIVITY
            <div class="tab-pedestal"></div>
          </a></li>
      </ul>
      <div class="project-picker hide">
        @foreach($projects as $project)
          <span class="project-label color-{{ $project->color }}">{{ $project->name }}</span>
        @endforeach
      </div>
      <div class="tabs-content">
        <div class="tab content active" id="discussion-panel">
          @include('partials.scrollers.notifications-discussion', ['comments' => $comments])
        </div>
        <div class="tab content" id="activity-panel">
          @include('partials.scrollers.notifications-activity', ['activities' => $activities])
        </div>
      </div>
    </aside>
  </div>
@endsection