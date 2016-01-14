<div id="tasks-container">
  <div class="tasks columns large-3">
    @foreach($tasks as $task)
    <div class="task">
      <div class="title"><span>{{ $task->name }}</span></div>
      <div class="content">
        <span class="logged">Logged: {{ $task->logged()  }} hrs</span>
        <span class="estimated">Estimated: 100hrs</span>
        <div class="description">{{ $task->description }}</div>
      </div>
    </div>
    @endforeach
    <div class="task new">
      <div class="title"><span>New Task...</span></div>
    </div>
  </div>
</div>
