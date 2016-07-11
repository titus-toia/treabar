<h3>{{ isset($project)? 'EDIT PROJECT': 'NEW PROJECT' }}</h3>
<form id="project-form" method="post" action="{{ !isset($project)?
    route('manager.projects.store'):
    route('manager.projects.update', ['project' => $project->id]) }}">
  {{ csrf_field() }}
  <input type="hidden" name="_method" value="{{ isset($project)? 'PUT': 'POST'}}" />
  @if(!isset($project))
    <input type="hidden" name="company_id" value="{{ \Auth::user()->company_id  }}" />
  @endif

  <div class="row">
    <div class="large-12 columns">
      <label>Name
        <input type="text" name="name" value="{{ isset($project)? $project->name: '' }}">
      </label>
    </div>
    <div class="large-12 columns" style="margin-bottom: 20px;">
      <input type="hidden" name="color" value="{{ isset($project)? $project->color: '' }}" />
      <label for="project-dropdown-color">Color</label>
      <div id="project-dropdown-color" class="project-color" data-dropdown="color-dropdown"
           data-options="align:right" aria-expanded="false">
        <div style="height: 30px; width: 30px;" class="color-{{ isset($project)? $project->color: '1' }}"></div>
      </div>
      <ul id="color-dropdown" class="f-dropdown treabar-single-dropdown" data-field="color" data-dropdown-content aria-hidden="true" tabindex="-1">
        @for($i = 1; $i <= \Treabar\Models\Project::COLOR_COUNT; $i++)
          <li data-id="{{ $i }}">
            <div>
              <div style="height: 30px; width: 30px;" class="color-{{ $i }}"></div>
            </div>
          </li>
        @endfor
      </ul>
    </div>
    <div class="large-12 columns">
      <div class="row collapse">
        <div class="columns large-6">
          <label>
            From
            <input type="text" name="from" value="{{ isset($project) && $project->from? $project->from->format('d-m-Y'): '' }}" />
          </label>
        </div>
        <div class="columns large-6">
          <label>
            To
            <input type="text" name="to" value="{{ isset($project) && $project->to? $project->to->format('d-m-Y'):  '' }}" />
          </label>
        </div>
      </div>
    </div>
    @if(!isset($project))
    <div class="large-12 columns">
      <label>Client
        <select name="client_id">
          @foreach($clients as $client)
          <option value="{{ $client->id }}">{{ $client->name }}</option>
          @endforeach
        </select>
      </label>
    </div>
    @endif
    <div class="large-12 columns" style="margin-bottom: 20px;">
      <label for="user-dropdown-head">Add Users to Project</label>
      <div id="user-dropdown-head" class="user-image-div head" data-dropdown="user-dropdown"
           data-options="align:right" aria-expanded="false" style="padding-left: 5px">
        Select User
      </div>
      <ul id="user-dropdown" class="f-dropdown treabar-multi-dropdown" data-container="project-users"
          data-dropdown-content aria-hidden="true" tabindex="-1">
        @foreach($users as $user)
          <li data-id="{{ $user->id }}">
            <div class="user-image-div small">
              <img src="{{ $user->icon() }}" /><span>{{ $user->name}}</span>
              <input type="hidden" disabled name="user_ids[]" value="{{ $user->id }}" />
              <span class="delete">&#10006;</span>
            </div>
          </li>
        @endforeach
      </ul>

      <div class="project-users" id="project-users">
      @if(isset($project))
        @foreach($project->users as $user)
          <div class="user-image-div small">
            <img src="{{ $user->icon() }}" /><span>{{ $user->name}}</span>
            <input type="hidden" name="user_ids[]" value="{{ $user->id }}" />
            <span class="delete">&#10006;</span>
          </div>
        @endforeach
      @endif
      </div>
    </div>
  </div>

  <div class="form-buttons">
    <a class="button tiny submit">Submit</a>
    <a class="button tiny cancel">Cancel</a>
  </div>
</form>
<script>
  var $form = $('#project-form');
  $form.on('click', 'span.delete', function() {
    $(this).parent().remove();
  });
  $form.find('[name=from], [name=to]').fdatepicker({
    format: 'dd-mm-yyyy'
  });
</script>