<form method="pot"
  action="{{ $project? route('manager.tasks.store', ['project' => $project->id]): route('manager.tasks') }}">
  <input name="_action" value="{{ $project? 'PUT': 'POST'}}" />
</form>
@if(isset($project))
  {{ dump($project) }}
@else
  <h1>New form for new Task</h1>
@endif
