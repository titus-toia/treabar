<div class="gantt">
  <div class="frame">
    <ul class="slidee">
      <div class="task jsPlumbIgnoreParents" id="task-pattern">
        <div class="container">
          <span class="date"></span>
          <span class="name"></span>
          <div class="slack"></div>
        </div>
      </div>
      <div class="task" id="chart-no-date">
        <div class="container">
          <span class="name">Tasks with no date</span>
          <div class="tasks">
          </div>
        </div>
      </div>
      @foreach($dates as $date)
      <li class="division" data-date="{{ $date }}">
        <span class="date">{{ $date }}</span>
      </li>
      @endforeach
    </ul>
  </div>
  <div class="scrollbar">
    <div class="handle">
      <div class="mousearea"></div>
    </div>
  </div>
</div>
<script>
  $('.gantt').data('tasks', JSON.parse('{!! json_encode($tasks) !!}'));
</script>
