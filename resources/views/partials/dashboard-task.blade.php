<?php $tasks = $project->tasks(true)->get();  ?>
<div class="dashboard-project row collapse">
  <div class="header columns large-3">
    <div class="left banner color-{{ $project->color }}" data-color="color-{{ $project->color }}"></div>
    <div class="left info">
      <span class="name">{{ $project->name }}</span>
      <span class="span">{{ $project->from->format('j M') . ' - ' . $project->to->format('j M')  }}</span>
      <span class="duration">{{ $tasks->sum('duration') }} hours.</span>
    </div>
  </div>
  <div class="tasks columns large-9">
    <div class="tasks-list-wrapper frame">
      <ul class="tasks-list slidee">
        @foreach($tasks as $task)
        <li>
          <div class="task" data-id="{{ $task->id }}">
            <span class="name">{{ $task->name }}</span>
            <span class="duration">Est. {{ $task->durationReadable() }}</span>
            <div class="completion" style="height: {{ $task->completion() }}%;"></div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="overview hide columns large-12">
    Sp00ky
  </div>
</div>