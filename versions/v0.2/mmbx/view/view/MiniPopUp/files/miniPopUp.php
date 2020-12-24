<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string|null $id mini pop's id
 * @param string|null $classes mini pop's additional classes
 * @param [up|down|left|right] $direction direction where to dipay the pop up following its relative elements
 * + up: will place popup in top of its parant
 * + down: will place popup under its parant
 * @param string $content the content of the pop up
 */
switch ($direction) {
    case self::DIRECTION_TOP:
        $class = "minipop_top";
        break;
    case self::DIRECTION_BOTTOM:
        $class = "minipop_bottom";
        break;
    case self::DIRECTION_LEFT:
        $class = "minipop_left";
        break;
    case self::DIRECTION_RIGHT:
        $class = "minipop_right";
        break;
}
?>
<div id="<?= $id ?>" class="minipop-wrap <?= $classes ?> <?= $class ?>">
    <div class="minipop-content">
        <?= $content ?>
    </div>
</div>