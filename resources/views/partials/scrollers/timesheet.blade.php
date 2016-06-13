@extends('partials.scrollers.scroller')

@section('before')
<div id="new-activity" class="vertical-button-control" data-ajax-interact data-display="slider"
     data-url="{{ route('manager.timesheet.create', ['project' => $project->id]) }}">
  <span><i class="fi-plus"></i>&nbsp;&nbsp;New Activity</span>
</div>
<div id="timesheet-container" class="vertical-feed">
  <div id="timesheet-wrapper"
       class="vertical-feed-wrapper update small-12 large-7 large-offset-1 columns"
       data-after="{{ $activities->count()? $activities->first()->created_at: \Carbon\Carbon::today() }}"
       data-before="{{ $activities->count()? $activities->last()->created_at: \Carbon\Carbon::today() }}"
       data-url="{{ route('manager.timesheet', ['project' => $project->id]) }}">
    <div class="slidee">
@overwrite

@section('data')
  @foreach($activities as $activity)
    <div class="activity clearfix" data-id="{{ $activity->id }}" data-created="{{ $activity->created_at }}">
      <div class="icon">
        <img src="{{ $activity->user->icon() }}" />
        <span class="duration">{{ $activity->duration() }}</span>
      </div>
      <div class="content">
        <span class="name"><b>{{ $activity->user->name }}</b></span>
        <span class="date">{{ $activity->createdAt() }}</span>
        <span class="task label info">{{ $activity->task? $activity->task->name: 'NO TASK' }}</span>
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
@overwrite

@section('after')
    </div>
  </div>
  <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
</div>
@overwrite
