@extends('partials.scrollers.scroller')

@section('before')
<div class="vertical-feed-wrapper">
  <div class="slidee">
@overwrite

@section('data')
  @foreach($comments as $comment)
  <div class="comment clearfix" data-id="{{ $comment->id }}">
    <div class="icon">
      <img src="{{ $comment->user->icon() }}" />
    </div>
    <div class="content">
      <span class="name">{{ $comment->user->name }}</span>
      <span class="project-label color-{{ $comment->project->color }}">{{ $comment->project->name }}</span>
      <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
      <div class="clearfix"></div>
      <p>{{ $comment->content }}</p>
    </div>
  </div>
  @endforeach
@overwrite

@section('after')
  </div>
</div>
<div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
@overwrite