<h3>{{ isset($project)? 'EDIT PROJECT': 'NEW PROJECT' }}</h3>
<form id="project-form" method="post" action="{{ !isset($project)?
    route('manager.projects.store'):
    route('manager.projects.update', ['project' => $project->id]) }}">
  {{ csrf_field() }}
  <input type="hidden" name="_method" value="{{ isset($project)? 'PUT': 'POST'}}" />

  <div class="row">
    <div class="large-12 columns">
      <label>Name
        <input type="text" name="name" value="{{ isset($project)? $project->name: '' }}">
      </label>
    </div>

    <div class="large-12 columns">
      <input type="hidden" name="color" value="{{ isset($project)? $project->color: '' }}" />
      <label for="project-dropdown-color">Color</label>
      <div id="project-dropdown-color" class="project-color" data-dropdown="color-dropdown"
           data-options="align:right" aria-expanded="false">
        @if(isset($project))
          <div style="height: 30px; width: 30px;" class="color-{{ $project->color }}"></div>
        @else
          <div style="height: 30px; width: 30px;" class="color-1"></div>
        @endif
      </div>
      <ul id="color-dropdown" class="f-dropdown treabar-control" data-field="color" data-dropdown-content aria-hidden="true" tabindex="-1">
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

    </div>
  </div>

  <div class="form-buttons">
    <a class="button tiny submit">Submit</a>
    <a class="button tiny cancel">Cancel</a>
  </div>
</form>