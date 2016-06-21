<style>
  .gantt {
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

  .division {
    height: 100%;
    width: 30px;
    display: inline-block;
    float: left;
  }

  .gantt .scrollbar {
    width: 100%;
    height: 3px;
  }
  .gantt .scrollbar .handle {
    height: 100%;
    background: #555;
  }
</style>
<?php $i=0; ?>

<div class="gantt">
  <div class="frame">
    <ul class="slidee">
      @foreach($dates as $date)
      <li class="division" data-date="{{ $date->format('Y-m-d') }}">
        <span class="date"></span>
      </li>
      @endforeach
    </ul>
  </div>
  <div class="scrollbar"><div class="handle"></div></div>
</div>