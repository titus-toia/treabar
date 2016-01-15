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
      Stuff about project #{{ $project->id }}
      <h3>{{ $project->name }}</h3>
    </div>
  @endforeach
</div>
