<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Map $liMap   elements to display
 */
/**
 * @var Map */
$liMap = $liMap;
?>
<ul class="remove-ul-default-att">
    <?php
    $keys = $liMap->getKeys();
    foreach($keys as $key):?>
        <li class="remove-li-default-att">
            <?= $liMap->get($key) ?>
        </li>
    <?php endforeach; ?>
</ul>