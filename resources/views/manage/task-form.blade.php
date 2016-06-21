<h3>{{ isset($task)? 'EDIT TASK': 'NEW TASK' }}</h3>
<form id="task-form" method="post" action="{{ !isset($task)?
    route('manager.tasks.store', ['project' => $project->id]):
    route('manager.tasks.update', ['task' => $task->id]) }}"
    data-submit="refresh">
  @if($parent)
    <span class="under">Under:&nbsp;&nbsp;<span class="info label">{{ $parent->name }}</span></span>
  @endif
  {{ csrf_field() }}
  <input type="hidden" class="holder" value="{{ isset($task)? $task->id: '' }}" />
  <input type="hidden" name="_method" value="{{ isset($task)? 'PUT': 'POST'}}" />

  @if(!isset($task) && $parent)
    <input type="hidden" name="parent_id" value="{{ $parent->id  }}" />
  @endif
  <div class="row">
    <div class="large-12 columns">
      <label>Name
        <input type="text" name="name" value="{{ isset($task)? $task->name: '' }}">
      </label>
    </div>
    <div class="large-12 columns">
      <label>Description
        <textarea name="description">{{ isset($task)? $task->description: '' }}</textarea>
      </label>
    </div>
    @if(!$parent)
    <div class="large-12 columns">
      <div class="row collapse">
        <div class="columns large-6">
          <label>
            From
            <input type="text" name="from" />
          </label>
        </div>
        <div class="columns large-6">
          <label>
            To
            <input type="text" name="to" />
          </label>
        </div>
      </div>
    </div>
    <div class="large-6 columns end">
      <label>Master Task
        <select name="master_id">
          <option>n/a</option>
          @foreach($tasks as $master)
            <option value="{{ $master->id }}" selected="{{ $master->id == $task->master_id? 'selected': '' }}">
              {{ $master->name }}
            </option>
          @endforeach
        </select>
      </label>
    </div>
    @endif
    <div class="large-6 columns end">
      <label>Estimate (hours)
        <input type="text" name="duration" value="{{ $task->duration or '' }}">
      </label>
    </div>
    <div class="large-12 columns">
      <input type="hidden" name="user_id" value="{{ isset($task)? $task->user_id: '' }}" />
      <label for="user-dropdown-head">Assignee</label>
      <div id="user-dropdown-head" class="user-image-div head" data-dropdown="user-dropdown"
           data-options="align:right" aria-expanded="false">
      @if(isset($task) && $task->user)
        <img src="{{ $task->user->icon() }}" /><span>{{ $task->user->name }}</span>
      @else
        <i class="fi-torso"></i>
        <span>No one assigned.</span>
      @endif
      </div>
      <ul id="user-dropdown" class="f-dropdown treabar-single-dropdown" data-field="user_id" data-dropdown-content aria-hidden="true" tabindex="-1">
        <li>
          <div class="user-image-div">
            <i class="fi-torso"></i><span>No one assigned.</span>
          </div>
        </li>
        @foreach($users as $user)
        <li data-id="{{ $user->id }}">
          <div class="user-image-div">
            <img src="{{ $user->icon() }}" /><span>{{ $user->name }}</span>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="form-buttons">
    @if(isset($task) && !$task->finished && $task->depth == 0)
    <a data-url="{{ route('manager.tasks.complete', ['task' => $task->id]) }}" class="button tiny submit">Complete Task</a>
    @endif
    <a class="button tiny submit">Submit</a>
    <a class="button tiny cancel">Cancel</a>
  </div>
</form>
<script>
  var $form = $('#task-form');
  state.change({
    task_id: $form.find('.holder').val()
  });
  $form.find('[name=from], [name=to]').fdatepicker({
    format: 'dd-mm-yyyy'
  });
</script>