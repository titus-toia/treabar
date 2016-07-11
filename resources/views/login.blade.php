<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Treabar</title>

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
  <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">

  <link href="{{ asset('foundation/css/foundation.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('foundation/icons/foundation-icons.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('foundation/css/foundation-datepicker.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/foundation-amends.css') }}" rel="stylesheet" type="text/css">
  <script src="{{ asset('foundation/js/vendor/modernizr.js') }}"></script>
  <style>
      .top-bar {
        background-color: #9dbce2 !important;
      }
      #login {
        position: relative;
        top: 150px;
      }
      .treabar {
        color: #3498db;
      }

      form {
        border: 1px solid #cacaca;
        padding: 1rem;
        border-radius: 3px;
      }
      input {
        width: 100%;
      }
  </style>
</head>
<body>
<nav class="top-bar">
  <ul class="title-area">
    <li class="name"><!-- Leave this empty --></li>
  </ul>
  <section class="top-bar-section">
    <ul class="left">
      <li class="dashboard page"><a href="#">Dashboard</a></li>
      <li class="manager page"><a href="#">Manage</a></li>
      <li class="invoices page"><a href="#">Invoice</a></li>
      <li id="page-state-button"><a href="#">Page state</a></li>
    </ul>
  </section>
</nav>

<div class="row">
  <div class="columns small-4 small-centered">
    <form id="login" method="post" action="{{ route('login') }}">
      <h5 class="text-center">Log in to <span class="treabar">Treabar.</span></h5>
      {{ csrf_field() }}
      <div class="row">
        <div class="small-12 columns">
          <label>E-mail
            <input type="text" name="email" />
          </label>
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <label>Password
            <input type="password" name="password" />
          </label>
        </div>
      </div>

      <div class="row">
        <div class="small-12 columns">
          <input type="submit" class="button expanded" value="Log In" />
        </div>
      </div>

    </form>
  </div>
</div>

@yield('content')
<script src="{{ asset('foundation/js/vendor/jquery.js') }}"></script>
<script src="{{ asset('foundation/js/foundation.min.js') }}"></script>
<script>
  BASE_URL = '{{ url('') }}';
  state = {!! json_encode(Session::get('state')) !!};
  state.change = function(obj) {
    state = $.extend(state, obj);
    $.ajax(BASE_URL + '/state', {
      method: 'POST',
      data: {
        state: JSON.parse(JSON.stringify(state)) //Object function properties are called, so we have to reconstruct the object
      }
    });
  };

  page = '{{ $page or '' }}';
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).foundation();
</script>
<script src="{{ asset('js/lib.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
