<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $meassge instruction to display
 * @param string $content content to display inside
 * @param string $btnTxt text to display on button
 * @param string $btnId id of the button
 */
?>

<div class="pop_up-content-block-inner">
    <div class="popup-content-instruct-div">
        <p class="popup-content-instruct"><?= $meassge ?>:</p>
    </div>
    <?= $content ?>
    <div class="popup-add-btn-div">
        <button id="<?= $btnId ?>" class="green-button remove-button-default-att"><?= $btnTxt ?></button>
    </div>
</div>