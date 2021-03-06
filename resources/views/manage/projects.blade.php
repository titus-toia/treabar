<div id="new-project" class="vertical-button-control" data-ajax-interact data-display="slider"
     data-url="{{ route('manager.projects.create') }}">
  <span><i class="fi-plus"></i>&nbsp;&nbsp;New Project</span>
</div>
<div id="manager-projects-list-wrapper" class="frame">
  <ul id="manager-projects-list" class="slidee">
    @foreach($projects as $project)
      <li>
        <div class="manager-project" data-id="{{ $project->id }}">
          <div class="left">
            <span class="name">{{ $project->name }}</span>
            <span class="date">{{ $project->createdAt() }}</span>
            <ul class="people">
              @foreach($project->users as $user)
                <li><img height="35" width="35" src="{{ $user->icon() }}"/></li>
              @endforeach
            </ul>
            <div class="clearfix"></div>
            <span class="tracked">Logged {{ $project->logged() }} hours.</span>
          </div>
          <div class="banner color-{{ $project->color }}" data-color="color-{{ $project->color }}"></div>
        </div>
      </li>
    @endforeach
  </ul>
</div>
<div class="scrollbar"><div class="handle"></div></div>
<div id="bridge"></div>
<div id="current-project" class="columns large-12">
  @foreach($projects as $project)
    <div class="project-listing" data-id="{{ $project->id }}">
      <h3>{{ $project->name }}</h3>
      <a href="#" data-ajax-interact data-display="slider"
           data-url="{{ route('manager.projects.edit', ['project' => $project]) }}">
        Edit Project<i class="fi-edit-page"></i></span>
      </a>
      <dl>
        <dt>Number of root tasks:</dt>
        <dd>{{ $project->tasks(true)->count() }}</dd>
        <dt>Total number of tasks:</dt>
        <dd>{{ $project->tasks()->count() }}</dd>
        <dt>Number of invoices:</dt>
        <dd>{{ $project->invoices()->count() }}</dd>
      </dl>
    </div>
  @endforeach
</div>