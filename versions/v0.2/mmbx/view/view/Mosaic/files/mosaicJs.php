<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerClass    class of Mosaic's container
 * @param string $stoneClass        class shared by all stone
 * @param string $sizerClass        class Mosaic's sizer tag
 */

?>

<script>
    // $('.grid').masonry({
    $('.<?= $containerClass ?>').masonry({
        // set itemSelector so.grid - sizer is not used in layout
        // itemSelector: '.grid-item',
        itemSelector: '.<?= $stoneClass ?>',
        // use element for option
        // columnWidth: '.grid-sizer',
        columnWidth: '.<?= $sizerClass ?>',
        percentPosition: true
    })
</script>