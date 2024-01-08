<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string    $content        content of the touch
 * @param int|null  $nbNofif        the number of notif
 * @param Map       $positionMap|null    holds vertical and horizontal position of the notification
 *                                  + $positionMap[Map::vertical] => [top|bottom]
 *                                  + $positionMap[Map::side] => [left|right]
 * @param string    $tagParams      params to place on the element's wraper tag
 */
$tagParams = (!empty($tagParams)) ? $tagParams : null;
?>
<div class="touch-wrap transition_time" <?= $tagParams ?> >
    <?php if ((!empty($nbNofif)) && ($nbNofif > 0)) {
        $notifDatas = [
            "nbNofif" => $nbNofif,
            "positionMap" => $positionMap
        ];
        echo $this->generateFile('view/view/BasicFiles/notif.php', $notifDatas);
    } ?>
    <div class="touch-content">
        <?= $content ?>
    </div>
</div>