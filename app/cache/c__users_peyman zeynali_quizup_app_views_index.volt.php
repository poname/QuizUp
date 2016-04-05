<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <?= $this->tag->getTitle() ?>
  <link rel="stylesheet" type="text/css" href="<?= $this->url->get('lib/semantic/semantic.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/font.yekan.css') ?>">
  <link rel="shortcut icon" sizes="16x16" href="<?= $this->url->get('img/icon-16.png') ?>">
  <link rel="shortcut icon" sizes="32x32" href="<?= $this->url->get('img/icon-32.png') ?>">
  <script src="<?= $this->url->get('lib/jquery/jquery.min.js') ?>"></script>
  <script src="<?= $this->url->get('lib/semantic/semantic.min.js') ?>"></script>

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
  <?= $this->getContent() ?>
</body>
</html>
