@extends('main')
@section('content')
<style>
#company-settings div.columns {
  padding-top: 15px;
  padding-left: 15px;
}
#company-settings ul.people {
  list-style-type: none;
}
#company-settings ul.people li {
  list-style-type: none;
  display: inline-block;
  margin-right: 2px;
  float: left;
}
#company-settings dd, dt {
  clear: both;
}
#company-settings div.columns > div {
  position: relative;
  width: 350px;
  padding: 20px;
  background-color: whitesmoke;
  display: inline-block;
}
#company-settings .user-form {
  width: 350px;
  position: absolute;
  top: -10px;
  left: 380px;
  display: none;
}
#company-settings .new-user .user-form {
  top: -29px;
  left: 500px;
}
#company-settings dl {
  font-size: 13px;
}
#company-settings ul.people img {
  cursor: pointer;
}
#company-settings ul.people img.active ~ .user-form {
  display: block;
}
#company-settings .new-user.active .user-form {
  display: block;
}
#company-settings ul.people img:hover ~ .user-form {
  display: block;
}
#company-settings .new-user {
  position: relative;
  float: right;
  display: inline-block;
}
</style>
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