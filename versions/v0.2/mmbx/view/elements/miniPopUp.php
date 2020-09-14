<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string|null $id mini pop's id
 * @param [up|down] $dir direction where to dipay the pop up following its parent
 * + up: will place popup in top of its parant
 * + down: will place popup under its parant
 * @param string $content the content of the pop up
 */
?>
<!-- <div class="minipop-wrap minipop-down"> -->
<div id="<?= $id ?>" class="minipop-wrap minipop-<?= $dir ?>">
    <div class="minipop-content">
        <?= $content ?>
        <!-- <ul class="remove-ul-default-att">
            <li class="grey-tag-button standard-tag-button remove-li-default-att">empty the box</li>
            <li class="grey-tag-button standard-tag-button remove-li-default-att">move to</li>
        </ul> -->
    </div>
</div>