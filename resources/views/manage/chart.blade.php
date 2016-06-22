<style>
  .gantt {
    overflow: visible;
    height: 100%;
  }
  .gantt .frame {
    background: whitesmoke;
    height: calc(100% - 15px);
  }
  .gantt .slidee {
    height: 100%;
    margin: 0;
    list-style: none;
  }

  .gantt .scrollbar {
    position: relative;
    top: 7px;
    width: 100%;
    height: 3px;
  }
  .gantt .scrollbar .handle {
    cursor: pointer;
    height: 100%;
    background: #555;
  }
  .gantt .scrollbar .handle .mousearea {
    position: absolute;
    height: 15px;
    width: 100%;
    left: 0;
    top: -7px;
  }

  .gantt .division {
    height: 100%;
    width: 30px;
    display: inline-block;
    float: left;
    position: relative;
    overflow: visible;
    text-align: center;
  }
  .gantt .division .date {
    font-size: 9px;
    font-weight: bold;
    display: none;
    left: -4px;
    position: absolute;

    transform: rotate(-15deg);
    -ms-transform: rotate(-15deg);
    -webkit-transform: rotate(-15deg);

    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
  }
  .gantt .division:nth-child(5n):before, .division:first-child:before, .division:last-child:before {
    content: '';
    position: absolute;
    height: 100%;
    border-left: dotted 1px #333;

    left: 50%;
  }
  .gantt .division:nth-child(5n) .date, .division:first-child .date, .division:last-child .date {
    display: inline-block;
  }

  .gantt .task {
    height: 22px;
    width: 100px;
    padding: 1px 2px;
    background: #7125a9;
    color: white;
    position: absolute;
    font-size: 9px;
    left: 5px;
    cursor: pointer;
    z-index: 2;

    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
  }
  .gantt .task .name {
    overflow: hidden;
    line-height: 19px;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  #task-pattern {
    display: none;
  }
</style>
<?php $i=0; ?>

<div class="task" id="task-pattern">
  <span class="name"></span>
  <span class="date"></span>
</div>
<div class="gantt">
  <div class="frame">
    <ul class="slidee">
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
  var $gantt = $('.gantt');
  $gantt.data('tasks', JSON.parse('{!! json_encode($tasks) !!}'));
  var tasks = $gantt.data('tasks');
  var $divisions = $gantt.find('.division');

  var $pattern = $('#task-pattern').clone().removeAttr('id');
  for(var i in tasks) {
    var task = tasks[i];

    var $task = $pattern.clone();
    if(task.from && task.to) {
      $task.find('.date').text(task.from + ' - ' + task.to);
    } else {
      $task.find('.date').text('No date specified.')
    }

    $task.clone()
      .css('top', '50%')
      .find('.name').text(task.name).end()
      .appendTo($divisions.first());
    break;
  }
</script>