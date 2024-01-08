<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $mosaic            the mosaic to display
 * @param string $style             mosaic's style tag
 * @param string $js                mosaic's script tag
 * @param string $containerClass    class of Mosaic's container
 * @param string $sizerClass        class Mosaic's sizer tag
 */

?>

<!-- <div class="grid"> -->
<div class="<?= $containerClass ?>">
    <!-- <div class="grid-sizer"></div> -->
    <div class="<?= $sizerClass ?>"></div>
    <?= $mosaic ?>
    <?= $style ?>
    <?= $js ?>
</div>