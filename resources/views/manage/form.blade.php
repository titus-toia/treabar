<h3>{{ isset($task)? 'EDIT TASK': 'NEW TASK' }}</h3>
<form id="task-form" method="post" action="{{ !isset($task)?
    route('manager.tasks.store', ['project' => $project->id]):
    route('manager.tasks.update', ['task' => $task->id]) }}">
  {{ csrf_field() }}
  <input type="hidden" name="_method" value="{{ isset($task)? 'PUT': 'POST'}}" />


  <div class="row">
    <div class="large-12 columns">
      <label>Name
        <input type="text" name="name" value="{{ isset($task)? $task->name: '' }}">
      </label>
    </div>
    <div class="large-12 columns">
      <label>Description
        <textarea name="description">{{ isset($task)? $task->description: '' }}</textarea>
      </label>
    </div>
    <div class="columns">
      <label>Duration
        <input type="text" name="duration" value="{{ isset($task)? $task->duration: '' }}">
      </label>
    </div>
  </div>

  <div class="form-buttons">
    <a class="button small submit">Submit</a>
    <a class="button small cancel">Cancel</a>
  </div>
</form>