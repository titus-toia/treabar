@extends('main')

<style>
</style>

@section('content')
  <div id="dashboard" class="row wrapper">
    <div class="large-8 columns main scrollpanel">
      Dashboard main
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
        <div class="content active" id="discussion-panel">
          <div class="vertical-feed-wrapper">
            <div class="slidee">
              <p>Enter discussion content here</p>
            </div>
          </div>
          <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
        </div>
        <div class="content" id="activity-panel">
          <div class="vertical-feed-wrapper">
            <div class="slidee">
              <p>Enter activity content here</p>
            </div>
          </div>
          <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
        </div>
      </div>
    </aside>
  </div>
@endsection
