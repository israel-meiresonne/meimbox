<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string|null   $id         mini pop's id
 * @param string        $content    the content the step
 * @param Map           $buttonsMap step's buttons
 *                      + Map::[View::DIRECTION_RIGHT]  => {string}
 *                      + Map::[View::DIRECTION_LEFT]   => {string}
 */
$left = $buttonsMap->get(self::DIRECTION_LEFT);
$right = $buttonsMap->get(self::DIRECTION_RIGHT);
?>
<div class="tutorial-wrap">
    <div class="tutorial-inner">
        <div class="tutorial_content">
            <?= ucfirst($content) ?>
        </div>
        <div class="tutorial_butttons">
            <div class="tutorial_butttons-container tutorial_butttons-left">
                <?= $left ?>
            </div>
            <div class="tutorial_butttons-container tutorial_butttons-right">
                <?= $right ?>
            </div>
        </div>
    </div>
</div>