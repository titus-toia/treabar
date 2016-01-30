<div class="task-facet facet"
     data-id="{{ $task->id }}" data-name="{{ $task->name }}" data-parent-id="{{ $task->parent_id }}">
  <span class="name">{{ $task->name }}</span>
  <div class="handle-prev left">@if($task->parent_id)<i class="fi-play"></i>@endif</div>
  <div class="handle-next right">@if(count($task->children)) <i class="fi-play"></i>@endif</div>
  @if(count($task->children))
  <div class="facets children" data-parent-id="{{ $task->id }}">
    @each('partials.task-facet', $task->children, 'task')
  </div>
  @endif
</div>