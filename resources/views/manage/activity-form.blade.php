<style>
  #activity-form div.columns {
    padding: 0;
  }
  #activity-form .form-buttons {
    display: inline-block;
    float: right;
  }
  #activity-form a.button {
    padding: 7px 20px;
  }
  #activity-form textarea {
    height: 200px;
  }
  .task-facets {
    display: none;
  }
</style>

<h3>{{ isset($activity)? 'EDIT ACTIVITY': 'NEW ACTIVITY' }}</h3>
<form id="activity-form" method="post" action="{{ !isset($activity)?
    route('manager.timesheet.store', ['project' => $project->id]):
    route('manager.timesheet.update', ['project' => $project->id, 'activity' => $activity->id]) }}">

  {{ csrf_field() }}
  <input type="hidden" name="_method" value="{{ isset($activity)? 'PUT': 'POST'}}" />

  <div class="row">
    <div class="large-12 columns">
      <label>Description
        <textarea name="description">{{ isset($activity)? $activity->description: '' }}</textarea>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-6 columns end">
      <label>Started At
        <input type="text" name="started_at" value="{{ isset($activity)? $activity->startedAt(): '' }}">
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-6 columns end">
      <label>Finished At
        <input type="text" name="finished_at" value="{{ isset($activity)? $activity->finishedAt(): '' }}">
      </label>
    </div>
  </div>
  <div class="row">
    <div class="task-facets">
      @each('partials.task-facet', $tasks, 'task')
    </div>
  </div>

  <div class="form-buttons">
    <a class="button small submit">Submit</a>
    <a class="button small cancel">Cancel</a>
  </div>
</form>
