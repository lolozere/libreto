<style>
  main.content {
    padding: 1rem;
    max-width: 40rem;
    font-size: 1rem;
  }

  main.content p,
  main.content h1,
  main.content h2,
  main.content h3,
  main.content h4,
  main.content h5,
  main.content h6,
  main.content ul,
  main.content blockquote {
    margin: 0;
    margin-bottom: 1rem;
  }
  main.content hr {
    border: none;
    border-bottom: 1px solid #ccc;
    margin-bottom: 1rem;
  }
  main.content img {
    max-width: 100%;
    height: auto;
    margin: auto;
    display: block;
  }
  main.content a {
    color: blue; text-decoration: underline;
  }
  main.content h1 {
    font-size: 1.8rem;
  }
</style>
<?php
global $libreto;

$css = $libreto->pads()->css();
if ($css !== false) {
  require ROOT . DS . "libreto" . DS . "vendor" . DS . "lessphp" . DS . "lessc.inc.php";
  $less = new lessc;
  echo '<style>' . $less->compile("main.content { $css }") . '</style>';
}?>
<main class="content">
  <?php
  if ($libreto->router()->pad()) :
    ?>
    <?= $libreto->pads()->selected()->html() ?>
    <?php
  else:
    ?>
    <h1><?= $this->name() ?></h1>
    <?php
    $pads = $this->pads()->children('visible');
    foreach($pads as $pad) :
      ?>
      <h2><?= $pad->name() ?></h2>
      <div><?= $pad->html() ?></div>
      <?php
    endforeach;
  endif;
  ?>
</main>
