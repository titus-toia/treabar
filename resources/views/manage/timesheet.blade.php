<style>
  #timesheet-container {
    padding: 10px 0px;
  }
  .activity {
    padding: 5px 15px;
    font-size: 13px;
  }
  .activity .icon {
    display: block;
    float: left;
    width: 50px;
    height: 100%;
  }
  .activity .icon img {
    height: 50px;
    width: 50px;
  }
  .activity div.content {
    float: right;
    width: calc(100% - 50px);
    height: 100%
  }
  .activity span {
    font-size: 11px;
  }
  /*.activity span.name {
    font-size: 9px;
    float: left;
    color: #888;
    text-transform: uppercase;
  }
  .comment span.time {
    font-size: 9px;
    float: right;
    color: #898989;
  }*/
</style>

<div id="timesheet-container">
  <div class="small-12 large-7 large-offset-1 columns">
    <div class="header"></div>
    @foreach($activities as $activity)
      <div class="activity clearfix">
        <div class="icon">
          <img src="{{ $activity->user->icon() }}" />
          <span class="name">{{ $activity->user->name }}</span>
        </div>
        <div class="content">
          <span class="interval left">{{ $activity->startedAt() . ' - ' . $activity->finishedAt() }}</span>
          <span class="date right">{{ $activity->createdAt() }}</span>
          <div class="clearfix"></div>
          <p>{{ $activity->description }}</p>
        </div>
      </div>
    @endforeach
  </div>
</div>