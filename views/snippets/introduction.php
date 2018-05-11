<?php global $libreto ?>
<header class="<?= count($libreto->pads()->children()) > 1 ? 'close' : 'open' ?>">
  <a id="btn-menu" href="#site-menu" data-toggle="collapse">Menu</a>
  <?php if($_SESSION['mode']=="write"): ?>
  <div class="full">
    <?= l("help") ?>
    <hr>
    <div class="colophon">
      <div><?= l('about') ?></div>
      <div><?= l('credits') ?></div>
    </div>
    <button class="switch">×</button>
  </div>
  <?php endif; ?>
  <div class="reduced">
    <p class="libreto_name"><?= $libreto->options('name') ?></p>
    <?php if($_SESSION['mode']=="write"): ?>
    <button class="switch">?</button>
    <?php endif; ?>
  </div>

</header>
