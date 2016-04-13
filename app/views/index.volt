<!DOCTYPE html>
<html dir="{{ _direction }}">
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  {{ get_title() }}
  <link rel="stylesheet" type="text/css" href="{{ url('lib/semantic/semantic.' ~ _direction ~'.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('css/font.yekan.css') }}">
  <link rel="shortcut icon" sizes="16x16" href="{{ url('img/icon-16.png') }}">
  <link rel="shortcut icon" sizes="32x32" href="{{ url('img/icon-32.png') }}">
  <script src="{{ url('lib/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('lib/semantic/semantic.min.js') }}"></script>

  <style type="text/css">
    * {
      font-family: BYekan ;
    }
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>
</head>
<body>
  {{ get_content() }}
</body>
</html>
