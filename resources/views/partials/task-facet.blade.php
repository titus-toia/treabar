<div class="task-facet" data-id="{{ $task->id }}" data-parent-id="{{ $task->parent_id }}">
  <span>{{ $task->name }}</span>
  @if($task->parent_id)
  <div class="handle-prev">*</div>
  @endif
  @if(count($task->children))
  <div class="handle-next">*</div>
  <div class="children">
    @each('partials.task-facet', $task->children, 'task')
  </div>
  @endif
</div>