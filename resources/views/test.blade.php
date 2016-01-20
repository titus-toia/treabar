<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Treabar</title>

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
  <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">

  <link href="{{ asset('foundation/css/foundation.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('foundation/icons/foundation-icons.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/foundation-amends.css') }}" rel="stylesheet" type="text/css">
  <script src="{{ asset('foundation/js/vendor/modernizr.js') }}"></script>
  <style>
    body {
      padding: 25px;
    }
    div.test {
      height: 75px;
      width: 75px;
      display: inline-block;
      background-color: sandybrown;
      margin: 10px;
    }
    .left {
      float: left;
      position: relative;
    }
    .right {
      float: right;
      position: relative;
    }
  </style>
</head>

<body>

<div class="left" style="width: 60%; float: left">
  @for($i = 1; $i <= 50; $i++)
    <div id="div{{ $i }}" class="test"></div>
  @endfor
</div>
<div class="right" style="width: 40%; float: right">
  @for($i = 51; $i <= 100; $i++)
    <div id="div{{ $i }}" class="test"></div>
  @endfor
</div>




<script src="{{ asset('foundation/js/vendor/jquery.js') }}"></script>
<script src="{{ asset('foundation/js/foundation.min.js') }}"></script>
<script src="{{ asset('js/jquery.sly.js') }}"></script>
<script src="{{ asset('js/jquery-ui-effects.js') }}"></script>
<script src="{{ asset('js/jsPlumb.js') }}"></script>
<script>
  jsPlumb.ready(function() {
    jsPlumb.importDefaults({
      Connector: ['Flowchart', { stub: 5 }],
      Endpoint: 'Blank',
      Anchor: ['RightMiddle', [0, 0.5, -1, 0]]
    });
  });
  BASE_URL = '{{ url('') }}';

</script>
</body>
</html>
