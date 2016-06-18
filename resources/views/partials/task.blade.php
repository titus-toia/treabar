<div class="task" data-id="{{ $task->id }}"
  @if($task->parent_id) data-parent-id="{{ $task->parent_id }}" @endif>

  <div class="title" id="task-title-{{ $task->id }}">
    <a class="comments" href="#" data-ajax-interact data-display="slider"
       data-url="{{ route('manager.tasks.comments', ['task' => $task->id]) }}"
       data-payload='{{ json_encode(['parent_id' => $task->parent_id]) }}'>
      <i class="fi-comment"></i>
    </a>
    <span>{{ $task->name }}</span>
    <a class="edit" href="#" data-ajax-interact data-display="slider"
       data-url="{{ route('manager.tasks.edit', ['project' => $project->id, 'task' => $task->id]) }}"
       data-payload='{{ json_encode(['parent_id' => $task->parent_id]) }}'>
      <i class="fi-page-edit"></i>
    </a>
  </div>

  <div class="content">
    <span class="logged">Logged: {{ $task->logged() }} hrs</span>
    <span class="estimated">@if($task->duration)Estimated: {{ $task->durationReadable() }}@endif</span>
    <div class="clearfix"></div>
    <div class="description">{{ $task->description }}</div>
    @if($task->finished && $task->depth == 0)
      <a class="invoice" href="#"><i class="fi-price-tag" data-invoice="{{ $task->invoice_id?: 'new' }}"></i></a>
    @endif

    <a class="delete" href="#" data-ajax-interact data-method="delete"
       data-url="{{ route('manager.tasks.delete', ['project' => $project->id]) }}"
       data-confirm="Are you sure you want to delete this task?">
      <i class="fi-trash"></i>
    </a>
    <div class="clearfix"></div>
  </div>
</div>