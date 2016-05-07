@extends('partials.scrollers.scroller')

@section('before')
<div class="vertical-feed-wrapper">
  <div class="slidee">
@endsection

@section('data')
  @foreach($activities as $item)
    <div class="feed clearfix">
      <div class="icon">
        <i class="fi-{{ $item->icon() }}"></i>
      </div>
      <div class="content">
        <span class="project-label color-{{ $item->project->color }}">{{ $item->project->name }}</span>
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
@endsection