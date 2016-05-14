<!-- https://www.iconfinder.com/iconsets/dortmund -->
@extends('partials.scrollers.scroller')

@section('before')
<div id="feed-container" class="vertical-feed">
  <div id="feed-wrapper"
       class="vertical-feed-wrapper update small-12 large-7 large-offset-1 columns"
       data-created="{{ $feed->count()? $feed->last()->created_at: \Carbon\Carbon::today() }}"
       data-url="{{ route('manager.feed', ['project' => $project->id]) }}">
    <div class="slidee">
@overwrite

@section('data')
  @foreach($feed as $item)
    <div class="feed clearfix" data-created="{{ $item->created_at }}">
      <div class="icon">
        <i class="fi-{{ $item->icon() }}"></i>
      </div>
      <div class="content">
        <span class="date">{{ $item->timestamp()->diffForHumans() }}</span>
        <p>{{ $item->content() }}</p>
      </div>
    </div>
  @endforeach
@overwrite

@section('after')
    </div>
  </div>
  <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
</div>
@overwrite