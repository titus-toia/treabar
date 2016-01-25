<style>
  .task-comments {
    height: calc(100% - 120px);
    overflow: hidden;
  }
  .task-comments .comment {
  }
  .comment div.icon {
    display: block;
    float: left;
    width: 35px;
    height: 100%;
  }
  .comment .icon img {
    float: left;
    height: 35px;
    width: 35px;
  }
  .comment div.content {
    float: right;
    width: calc(100% - 40px);
    height: 100%
  }
  .comment span.name {
    font-size: 9px;
    float: left;
    color: #888;
    text-transform: uppercase;
  }
  .comment span.time {
    font-size: 9px;
    float: right;
    color: #898989;
  }
  .comment p {
    font-size: 13px;
    margin-bottom: 10px;
    padding: 2px;
  }

  #task-comment {
    padding-top: 15px;
    height: 120px;
  }
  #task-comment textarea {
    width: 100%;
    height: calc(100px - 2.1rem);
    margin-bottom: 5px;
  }
  #task-comment .form-buttons {
    display: inline-block;
    float: right;
  }
</style>
<div class="task-comments">
  @foreach($comments as $comment)
  <div class="comment" data-id="{{ $comment->id }}">
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
  <div class="clearfix"></div>
  @endforeach
</div>
<form id="task-comment">
  <textarea name="content"></textarea>
  <div class="form-buttons">
    <a class="button tiny submit">Submit</a>
    <a class="button tiny cancel">Cancel</a>
  </div>
</form>