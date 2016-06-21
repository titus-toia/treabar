@extends('main')
@section('content')
  <div id="dashboard" class="row wrapper">
    <div class="large-8 columns main projects">
      @each('partials.dashboard-project', $projects, 'project', 'partials.dashboard-empty')
    </div>
    <aside class="large-4 columns notifications">
      <ul class="tabs" data-tab>
        <li class="tab-title active"><a href="#discussion-panel">DISCUSSION
            <div class="tab-pedestal"></div>
          </a></li>
        <li class="tab-title"><a href="#activity-panel">ACTIVITY
            <div class="tab-pedestal"></div>
          </a></li>
        <li class="tab-title controls">
          <a href="#" class="filter">
            <span>Project
              <i class="fi-filter"></i>
            </span>
            @foreach($projects as $project)
            <div class="project-bar hide" data-id="{{ $project->id }}">
              {{ $project->name }}
              <div class="bar color-{{ $project->color }}"></div>
            </div>
            @endforeach
          </a>
        </li>
      </ul>
      <div class="project-picker hide">
        @foreach($projects as $project)
          <span class="project-label color-{{ $project->color }}" data-id="{{ $project->id }}">{{ $project->name }}</span>
        @endforeach
      </div>
      <div id="notifications" class="tabs-content">
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