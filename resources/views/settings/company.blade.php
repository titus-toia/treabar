@extends('main')
@section('content')
<script>
  page = '{{ $page }}';
</script>
<div id="company-settings" class="row wrapper">
  <div class="columns large-12">
    <div>
      <div class="new-user">
        <a href="#">
          New User
          <i class="fi-page-add"></i>
        </a>
        @include('partials.settings-user-form')
      </div>
      <dl>
        <dt>Devs</dt>
        <dd><ul class="people">
        @foreach($devs as $user)
          <li>
            <img height="35" width="35" src="{{ $user->icon() }}"/>
            @include('partials.settings-user-form', ['user' => $user])
          </li>
        @endforeach
        </ul></dd>
        <dt>Managers</dt>
        <dd><ul class="people">
        @foreach($managers as $user)
          <li>
            <img height="35" width="35" src="{{ $user->icon() }}"/>
            @include('partials.settings-user-form', ['user' => $user])
          </li>
        @endforeach
          </ul></dd>
        <dt>Clients</dt>
        <dd><ul class="people">
        @foreach($clients as $user)
          <li>
            <img height="35" width="35" src="{{ $user->icon() }}"/>
            @include('partials.settings-user-form', ['user' => $user])
          </li>
        @endforeach
        </ul></dd>
      </dl>
      <div style="clear:both"></div>
      <div>
        <br /><br />
        <form method="post" action="{{ route('settings.company.update', ['company' => $company]) }}" enctype="multipart/form-data">
          <h4>Misc. settings</h4>
          <div class="large-12 columns">
            <label>Name
              <textarea name="name">{{ $company->name }}"</textarea>
            </label>
          </div>
          <div class="large-12 columns">
            <img height="200" width="200" src="{{ asset('img/companies/' . $company->icon) }}"/>
          </div>
          <div class="large-12 columns">
            <label>Picture
              <input type="file" name="icon" />
            </label>
          </div>
          <div class="form-buttons">
            <input type="submit" value="Save" class="button tiny" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection