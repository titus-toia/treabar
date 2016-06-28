@extends('main')
@section('content')
  <style>
    #user-settings > div {
      padding: 25px;
    }
  </style>
  <script>
    page = '{{ $page }}';
  </script>
  <div id="user-settings" class="row wrapper">
    <div class="columns large-4">
      @include('partials.settings-user-form', ['user' => $user])
    </div>
  </div>
@endsection