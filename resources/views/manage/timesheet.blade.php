<div id="new-activity" class="vertical-button-control" data-ajax-interact data-display="slider"
     data-url="{{ route('manager.timesheet.create', ['project' => $project->id]) }}">
  <span><i class="fi-plus"></i>&nbsp;&nbsp;New Activity</span>
</div>
@include('partials.scrollers.timesheet')