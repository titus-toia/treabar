@extends('partials.scrollers.scroller')

@section('before')
<div id="timesheet-container" class="vertical-feed">
  <div id="timesheet-wrapper"
       class="vertical-feed-wrapper update small-12 large-7 large-offset-1 columns"
       data-id="{{ $activities->count()? $activities->last()->id: '' }}"
       data-url="{{ route('manager.timesheet', ['project' => $project->id]) }}">
    <div class="slidee">
@endsection

@section('data')
  @foreach($activities as $activity)
    <div class="activity clearfix" data-id="{{ $activity->id }}">
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
@endsection

@section('after')
    </div>
  </div>
  <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
</div>
@endsection
