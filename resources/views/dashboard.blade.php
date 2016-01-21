@extends('main')

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
      <div class="tabs-content">
        <div class="content active" id="discussion-panel">
          <p>This is the first panel of the basic tab example. You can place all sorts of content here including a
            grid.</p>
        </div>
        <div class="content" id="activity-panel">
          <p>This is the second panel of the basic tab example. This is the second panel of the basic tab example.</p>
        </div>
      </div>
    </aside>
  </div>
@endsection
