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
        ?>
        <iframe id="framepad" name="myframe" width=600 height=400 src="<?= $iframe ?>"></iframe>
    </article>
</div>
<?php snippet('footer') ?>
