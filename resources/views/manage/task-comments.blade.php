<!-- https://www.iconfinder.com/iconsets/dortmund -->
<div id="task-comments-container" class="vertical-feed">
  <div id="task-comments-container-wrapper" class="task-comments vertical-feed-wrapper">
    <div class="slidee">
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
  </div>
  <div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>
</div>

<form id="task-comment" method="post" action="{{ route('manager.tasks.comment', ['task' => $task->id]) }}">
  <textarea name="content"></textarea>
  <div class="form-buttons">
    <a class="button tiny submit">Submit</a>
    <a class="button tiny cancel">Cancel</a>
  </div>
</form>

<script>
var $frame = $('#task-comments-container-wrapper');
var $scrollbar = $frame.parent().find('.scrollbar');

DefaultSly($frame, $scrollbar);
</script>