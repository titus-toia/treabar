<!-- https://www.iconfinder.com/iconsets/dortmund -->
@extends('partials.scrollers.scroller')

@section('before')
<div id="feed-container" class="vertical-feed">
  <div id="feed-wrapper" class="vertical-feed-wrapper small-12 large-7 large-offset-1 columns">
    <div class="slidee">
@endsection

@section('data')
  @foreach($feed as $item)
    <div class="feed clearfix">
      <div class="icon">
        <i class="fi-{{ $item->icon() }}"></i>
      </div>
      <div class="content">
        <span class="date">{{ $item->timestamp()->diffForHumans() }}</span>
        <p>{{ $item->content() }}</p>
      </div>
    </div>
  @endforeach
@endsection

@section('after')
    </div>
  </div>
  <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
</div>
@endsection