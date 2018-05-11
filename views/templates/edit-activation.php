<?php global $libreto ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trello Tuto</title>
  <link rel="stylesheet" href="/libreto/assets/style-index.css">
  <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
  <style>
    input[type=password] {
      font-family: "HKGrotesk";
      font-size: 3rem;
      background: none;
      border: 0;
      border-bottom: .2rem solid rgba(0,0,0,.5);
      width: 30rem;
      text-transform: lowercase;
      margin: 0 .5rem;
    }

    input[type=password]::placeholder {
      color: rgba(0,0,0,.5);
      opacity: 1;
    }
  </style>
</head>

<body>
  <?php if (isset($_GET['bad'])):?>
  <div style="text-align: center;">
    <strong>Mot de passe incorrect</strong>
  </div>
  <?php endif;?>
  <form action="/site/" method="POST">
    <div class="url">
      <span class="directory"><input type="password" autofocus="autofocus" onfocus="this.select()" name="key" placeholder="Mot de passe" /></span>
      <input type="hidden" name="mode" value="write" />
      <button type="submit" /><?= l("activate_edition", false) ?></button>
    </div>

  </form>

</body>

</html>
