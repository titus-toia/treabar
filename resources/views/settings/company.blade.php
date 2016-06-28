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
    </div>
  </div>
</div>
@endsection