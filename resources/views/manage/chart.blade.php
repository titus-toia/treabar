<style>
  .gantt {
    overflow: visible;
    height: 100%;
  }
  .gantt .frame {
    background: whitesmoke;
    height: calc(100% - 10px);
  }
  .gantt .slidee {
    height: 100%;
    margin: 0;
    list-style: none;
  }

  .gantt .scrollbar {
    width: 100%;
    height: 3px;
  }
  .gantt .scrollbar .handle {
    height: 100%;
    background: #555;
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
    transform: rotate(-15deg);
    -ms-transform: rotate(-15deg);
    -webkit-transform: rotate(-15deg);

    font-size: 9px;
    font-weight: bold;
    display: none;
    left: -4px;
    position: absolute;
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
    padding: 1px 2px;
    background: #7125a9;
    color: white;
    position: absolute;
    font-size: 9px;
    left: 5px;
    cursor: pointer;
  }
  .gantt .task .name {
    overflow: hidden;
    line-height: 19px;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

</style>
<?php $i=0; ?>

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
  <div class="scrollbar"><div class="handle"></div></div>
</div>
<script>
  var $gantt = $('.gantt');
  $gantt.data('tasks', JSON.parse('{!! json_encode($tasks) !!}'));
  var tasks = $gantt.data('tasks');
  var $divisions = $gantt.find('.division');

  var $task = $('<div class="task"><span class="name"></span></div>')
  for(var i in tasks) {
    var task = tasks[i];
    $task.clone()
      .css('top', '50%')
      .find('.name').text(task.name).end()
      .appendTo($divisions.first());
    break;
  }
</script>