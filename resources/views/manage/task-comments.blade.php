<div class="task-comments">
  @foreach($comments as $comment)
  <div class="comment clearfix" data-id="{{ $comment->id }}">
    <div class="icon">
      <img src="{{ $comment->user->icon() }}" />
    </div>
    <div class="content">
      <span class="name">{{ $comment->user->name }}</span>
      <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
      <div class="clearfix"></div>
      <p>{{ $comment->content }}</p>
    </div>
  </div>
  @endforeach
</div>
<form id="task-comment" method="post" action="{{ route('manager.tasks.comment', ['task' => $task->id]) }}">
  <textarea name="content"></textarea>
  <div class="form-buttons">
    <a class="button tiny submit">Submit</a>
    <a class="button tiny cancel">Cancel</a>
  </div>
</form>