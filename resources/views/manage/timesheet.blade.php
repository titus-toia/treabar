<div id="timesheet-container" class="vertical-feed">
  <div id="timesheet-wrapper" class="vertical-feed-wrapper small-12 large-7 large-offset-1 columns">
    <div class="slidee">
    @foreach($activities as $activity)
      <div class="activity clearfix">
        <div class="icon">
          <img src="{{ $activity->user->icon() }}" />
          <span class="duration">{{ $activity->duration() }}</span>
        </div>
        <div class="content">
          <span class="name"><b>{{ $activity->user->name }}</b></span>
          <span class="date">{{ $activity->createdAt() }}</span>
          <span class="task label info">{{ $activity->task->name }}</span>
          <span class="interval">{{ $activity->startedAt() . ' - ' . $activity->finishedAt() }}</span>
          <div class="clearfix"></div>
          <p>{{ $activity->description }}</p>
        </div>
        <ul class="actions">
          <li><a class="edit" href="#" data-ajax-interact data-display="slider"
                 data-url="{{ route('manager.timesheet.edit', ['project' => $project->id, 'activity' => $activity->id]) }}">
              <i class="fi-page-edit"></i></a></li>
          <li><a class="delete" href="#" data-ajax-interact data-method="delete"
             data-url="{{ route('manager.timesheet.delete', ['activity' => $activity->id]) }}"
             data-confirm="Are you sure you want to delete this activity?">
            <i class="fi-trash"></i>
          </a></li>
        </ul>
      </div>
    @endforeach
    </div>
  </div>
  <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
</div>