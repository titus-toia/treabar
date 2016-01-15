<div id="tasks-container">
  <div class="tasks columns large-3">
    @foreach($tasks as $task)
    <div class="task">
      <div class="title">
        <span>{{ $task->name }}</span>
        <a class="edit" href="#"
           data-ajax="{{ route('manager.popups.task-edit', ['project' => $project->id, 'task' => $task->id]) }}">
          <i class="fi-page-edit"></i>
        </a>
      </div>
      <div class="content">
        <span class="logged">Logged: {{ $task->logged()  }} hrs</span>
        <span class="estimated">Estimated: 100hrs</span>
        <div class="clearfix"></div>
        <div class="description">{{ $task->description }}</div>
      </div>
    </div>
    @endforeach
    <div class="task new">
      <div class="title" data-ajax="{{ route('manager.popups.task-create', ['project' => $project->id]) }}">
        <span>New Task...</span>
      </div>
    </div>
  </div>
</div>
<div class="reveal-modal" id="tasks-modal" data-reveal role="dialog"></div>