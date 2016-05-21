@extends('partials.scrollers.scroller')

@section('before')
<div class="vertical-feed-wrapper update"
     data-created="{{ $activities->count()? $activities->last()->created_at: \Carbon\Carbon::today() }}"
     data-url="{{ route('dashboard.activity.feed') }}">
  <div class="slidee">
@overwrite

@section('data')
  @foreach($activities as $item)
    <div class="feed clearfix" data-id="{{ $item->id }}" data-created="{{ $item->created_at }}">
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
@overwrite

@section('after')
  </div>
</div>
<div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
@overwrite