<?php global $libreto ?>
<header class="<?= count($libreto->pads()->children()) > 1 ? 'close' : 'open' ?>">
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
    <p class="instance_name"><a href="<?= $libreto->options('url') ?>"><?= $libreto->options('name') ?></a></p>
    <p class="libreto_name"><?= $libreto->name() ?></p>
    <?php if($_SESSION['mode']=="write"): ?>
    <button class="switch">?</button>
    <?php endif; ?>
  </div>
</header>
