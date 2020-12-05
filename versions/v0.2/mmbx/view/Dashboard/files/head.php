<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string[] $datas additional datas
 */
if (!empty($additionals)) {
    foreach ($additionals as $additional) {
        echo $additional;
    }
}
?>
<link rel="stylesheet" href="<?= self::$PATH_CSS ?>cart.css">