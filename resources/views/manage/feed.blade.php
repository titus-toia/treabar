<!-- https://www.iconfinder.com/iconsets/dortmund -->
<div id="feed-container" class="vertical-feed">
  <div id="feed-wrapper" class="vertical-feed-wrapper small-12 large-7 large-offset-1 columns">
    <div class="slidee">
      @foreach($feed as $item)
        <div class="feed clearfix">
          <div class="icon">
            <img src="{{ $item->icon() }}" />
          </div>
          <div class="content">
            <span class="date right">{{ $item->timestamp()->diffForHumans() }}</span>
            <p>{{ $item->content() }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
</div>