<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param int  $nbNofif        the number of notif
 * @param Map  $positionMap    holds vertical and horizontal position of the notification
 *                             + $positionMap[Map::vertical] => [top|bottom]
 *                             + $positionMap[Map::side] => [left|right]
 */
/**
 * @var Map */
$positionMap =  $positionMap;
$side = ($positionMap->get(Map::side) == self::DIRECTION_LEFT) ? "notif_left" : "notif_right";
$virtical = ($positionMap->get(Map::vertical) == self::DIRECTION_TOP) ? "notif_top" : "notif_bottom";
$TagNotifClass = "notif_active $side $virtical";
?>
<div class="touch-notif">
    <!-- <div class="notif-wrap notif_top notif_right"> -->
    <div class="notif-wrap <?= $TagNotifClass ?>">
        <div class="notif_content back_blue">
            <span><?= $nbNofif ?></span>
        </div>
    </div>
</div>