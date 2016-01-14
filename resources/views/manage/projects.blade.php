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
  @for($i = 1; $i <= 10; $i++)
    <div class="current-project-listing" data-id="{{ $i }}">
      Stuff about project #{{ $i }}
    </div>
  @endfor
</div>
