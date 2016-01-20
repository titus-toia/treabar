<div class="task" data-id="{{ $task->id }}"
  @if($task->parent_id) data-parent-id="{{ $task->parent_id }}" @endif>

  <div class="title" id="task-title-{{ $task->id }}">
    <span>{{ $task->name }}</span>
    <a class="edit" href="#"
       data-ajax="{{ route('manager.tasks.edit', ['project' => $project->id, 'task' => $task->id]) }}">
      <i class="fi-page-edit"></i>
    </a>
  </div>

  <div class="content">
    <span class="logged">Logged: {{ $task->logged() }} hrs</span>
    <span class="estimated">Estimated: {{ $task->duration }} hrs</span>
    <div class="clearfix"></div>
    <div class="description">{{ $task->description }}</div>
  </div>

</div>