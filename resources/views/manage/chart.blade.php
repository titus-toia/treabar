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
  .gantt .division > .date {
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
  .gantt .division:nth-child(5n) > .date, .division:first-child > .date, .division:last-child > .date {
    display: inline-block;
  }

  .gantt .task {
    height: 35px;
    min-width: 100px;
    background: white;
    text-align: left;
    overflow: hidden;
    position: absolute;
    font-size: 9px;
    left: 5px;
    cursor: pointer;
    margin-bottom: 2px;
    border: 1px solid #a477c4;
    z-index: 2;

    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
  }

  .gantt .container {
    padding: 1px 3px;
    height: 100%;
    width: 100%;
    position: relative;
  }
  .gantt .task .date {
    color: #551C7D;
    display: inline-block;
    font-size: 8px;
  }

  .gantt .task .name {
    display: inline-block;
    line-height: 19px;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .gantt .task .slack {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    padding: 1px 3px;
    opacity: 0.4;
    background: #aaa;
    text-align: right;
  }
  .gantt .task .slack[data-slack="0"] {
    visibility: hidden;
  }


  #task-pattern {
    visibility: hidden;
  }
</style>
<?php $i=0; ?>

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
