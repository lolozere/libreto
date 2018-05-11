<?php
global $libreto;
if (!$libreto->pads()->selected()):
    header('Location: ?mode=write');
    return;
endif;

snippet('header'); ?>
<div id="container">
    <?php snippet('introduction') ?>
    <?php snippet('nav') ?>
    <article>
        <?php
        $iframe = $libreto->pads()->selected()->url();
        if ($_SESSION['mode'] == 'write' || $iframe[0] != '/'):?>
        <iframe id="framepad" name="myframe" width=600 height=400 src="<?= $iframe ?>"></iframe>
        <?php else:
          $scheme = ($_SERVER['REMOTE_PORT'] == 443)?'https':'http';?>
        <section class="reader-pane">
          <?php echo  file_get_contents($scheme . '://' . $_SERVER['HTTP_HOST'] . $iframe);?>
        </section>
        <?php endif;?>
    </article>
</div>
<?php snippet('footer') ?>
