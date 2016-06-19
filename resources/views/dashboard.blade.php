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
    .dashboard-project .tasks-list .task {
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

    .dashboard-project .tasks-list .task.active {
      border-color: #ffbf00;
    }
    .dashboard-project .tasks-list .task .name {
      max-height: 40%;
      text-overflow: ellipsis;
      overflow: hidden;
    }
    .dashboard-project .tasks-list .task .duration {

    }
    .dashboard-project .tasks-list .task span {
      position: relative;
      display: block;
      z-index: 5;
    }
    .dashboard-project .tasks-list .task .completion {
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: #3498db;
    }
    .dashboard-project .tasks-list .task .completion > span {
      position: absolute;
      left: 40%;
      bottom: 15%;
      color: white;
    }
    .dashboard-project .overview .task {

    }
    .dashboard-project .overview .task:before {
      position: absolute;
      width: 15%;
      content: '';
      top: 0;
      left: 0;
      border-top: 1px solid #bbb;
    }
    .dashboard-project .overview table {
      border: 0;
    }
    .dashboard-project .overview tr {
      background-color: white;
    }
    .dashboard-project .overview td {
      padding-left: 0;
    }
    .dashboard-project img {
      height: 24px;
      width: 24px;
      margin-right: 5px;
    }
  </style>
  <div id="dashboard" class="row wrapper">
    <div class="large-8 columns main projects">
      <div class="frame">
        @each('partials.dashboard-project', $projects, 'project', 'partials.dashboard-empty')
      </div>
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