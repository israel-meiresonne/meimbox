<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string|null $id mini pop's id
 * @param [up|down|left|right] $dir direction where to dipay the pop up following its parent
 * + up: will place popup in top of its parant
 * + down: will place popup under its parant
 * @param string $content the content of the pop up
 */
?>
<div id="<?= $id ?>" class="minipop-wrap minipop-<?= $dir ?>">
    <div class="minipop-content">
        <?= $content ?>
    </div>
</div>