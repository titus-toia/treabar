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
  .faceter {
    position: relative;
    margin-bottom: 1rem;
  }
  .faceter .head {
    border: 1px solid rgb(204, 204, 204);
    padding: 8px;
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
  }
  .faceter .facets-control {
    background: white;
    display: none;
    position: absolute;
    bottom: 2.13rem;
    left: 0;
    width: 100%;
    border: 1px solid #ccc;
  }
  .facets {
    display: none;
  }
  .facet {
    position: relative;
    clear: both;
    height: 2.13rem;
    font-size: 14px;
    line-height: 2.13rem;
    width: 100%;
    cursor: pointer;
  }
  .facet:hover {
    background-color: rgb(238, 238, 238);
  }
  .facet:hover .handle-prev , .facet:hover .handle-next {
    background: rgb(238, 238, 238);
  }
  .facet .name {
    display: inline-block;
    overflow: hidden;
    width: calc(100% - 2rem);
    padding: 0 5px;
    white-space: nowrap;
  }
  .facet .handle-prev, .facet .handle-next {
    background-color: white;
    height: 100%;
    width: 1rem;
    text-align: center;
  }
  .facet .handle-prev {
    transform: scaleX(-1);
    -moz-transform: scaleX(-1);
    -webkit-transform: scaleX(-1);
    -ms-transform: scaleX(-1);
  }
  .facet .handle-prev i, .facet .handle-next i {
    display: block;
  }
  .facet .handle-prev:hover i, .facet .handle-next:hover i {
    background: #aaa;
  }
</style>

<h3>{{ isset($activity)? 'EDIT ACTIVITY': 'NEW ACTIVITY' }}</h3>
<form id="activity-form" method="post" action="{{ !isset($activity)?
    route('manager.timesheet.store', ['project' => $project->id]):
    route('manager.timesheet.update', ['project' => $project->id, 'activity' => $activity->id]) }}"
  data-submit="sly" data-sly="#timesheet-wrapper">
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
    <div class="faceter columns large-8 end">
      <input type="hidden" name="task_id" value="{{ isset($activity)? $activity->task_id: ''  }}" />
      <label>
        Task
        <div class="head">
          <span class="display">{{ (isset($activity) && isset($activity->task))? $activity->task->name: 'Pick a Task' }}</span>
        </div>
      </label>
      <div class="facets-control"></div>
      <div class="facets">@each('partials.task-facet', $tasks, 'task')</div>
    </div>
  </div>

  <div class="form-buttons">
    <a class="button small submit">Submit</a>
    <a class="button small cancel">Cancel</a>
  </div>
</form>
<script>
  var $form = $('#activity-form');
  $form.find('.faceter').faceter();

  $form.find('[name=started_at], [name=finished_at]').fdatepicker({
    format: 'hh:ii',
    startView: 0
  });

</script>