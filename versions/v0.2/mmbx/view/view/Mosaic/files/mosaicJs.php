<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerClass    class of Mosaic's container
 * @param string $stoneClass        class shared by all stone
 * @param string $sizerClass        class Mosaic's sizer tag
 */

$var = "id".ModelFunctionality::generateDateCode(25);
?>

<script>
    var <?= $var ?> = $('.<?= $containerClass ?>').imagesLoaded(function() {
        // init Masonry after all images have loaded
        <?= $var ?>.masonry({
            itemSelector: '.<?= $stoneClass ?>',
            columnWidth: '.<?= $sizerClass ?>',
            percentPosition: true
        });
    });
</script>