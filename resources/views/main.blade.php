<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Treabar</title>

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
  <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">

  <link href="{{ asset('foundation/css/foundation.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('foundation/icons/foundation-icons.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/foundation-amends.css') }}" rel="stylesheet" type="text/css">
  <script src="{{ asset('foundation/js/vendor/modernizr.js') }}"></script>
</head>
<body>
<nav class="top-bar">
  <ul class="title-area">
    <li class="name"><!-- Leave this empty --></li>
  </ul>
  <section class="top-bar-section">
    <ul class="left">
<<<<<<< HEAD
      <li class="dashboard page"><a href="{{ url('')  }}">Dashboard</a></li>
      <li class="manager page"><a href="{{ url('manage')  }}">Manage</a></li>
=======
      <li class="dashboard page"><a href="#">Dashboard</a></li>
      <li class="manager page"><a href="#">Manage</a></li>
>>>>>>> 4e5bb1960842a3432876771d736fe7dfd1062934
      <li class="invoices page"><a href="#">Invoice</a></li>
    </ul>
    <ul class="right">
      <li class="fullname"><span>Full Name</span></li>
      <li class="has-dropdown profile">
        <a href="#"><i class="fi-torso"></i></a>
        <ul class="dropdown">
          <li><a href="#">Profile</a></li>
          <li><a href="#">Log Out</a></li>
        </ul>
      </li>
    </ul>
  </section>
</nav>

@yield('content')
<script src="{{ asset('foundation/js/vendor/jquery.js') }}"></script>
<script src="{{ asset('foundation/js/foundation.min.js') }}"></script>
<script src="{{ asset('js/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('js/jquery.scrollpanel.js') }}"></script>
<script>
  $(document).foundation();
<<<<<<< HEAD
  $.ready(function () {
=======
  $.ready(function() {
>>>>>>> 4e5bb1960842a3432876771d736fe7dfd1062934
    $('.scrollpanel').scrollpanel();
  });
</script>
</body>
</html>
