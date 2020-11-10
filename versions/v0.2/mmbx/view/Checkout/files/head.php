<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $datas additional datas
 */
if(!empty($additionals)){
    foreach($additionals as $additional){
        echo $additional;
    }
}
?>
<script src="<?= self::$PATH_JS ?>checkout.js"></script>
<link rel="stylesheet" href="<?= self::$PATH_CSS ?>checkout.css">