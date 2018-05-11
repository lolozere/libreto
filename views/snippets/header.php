<?php
global $libreto;
$title = "Trello Tuto";
/** @var Pad $pad */
if ($pad = $libreto->pads()->selected()):
  $title = $pad->name() . " - $title";
endif;
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= $title;?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/belgica-belgika" type="text/css"/>
  <link rel="stylesheet" href="/libreto/assets/style.css?0.1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="/libreto/assets/script.js"></script>
</head>
<body>
