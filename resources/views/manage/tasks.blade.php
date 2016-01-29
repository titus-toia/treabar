<div id="tasks-container">
  <div class="tasks master large-3 columns">
    @each('partials.task', $tasks->where('depth', 0), 'task')
    @include('partials.task-new', ['params' => ['project' => $project->id]])
  </div>

  <div class="tasks large-3 columns">
    @each('partials.task', $tasks->where('depth', 1), 'task')
    @include('partials.task-new', ['params' => ['project' => $project->id]])
  </div>

  <div class="tasks leaf large-3 columns end">
    @each('partials.task', $tasks->where('depth', 2), 'task')
    @include('partials.task-new', ['params' => ['project' => $project->id]])
  </div>
</div>
