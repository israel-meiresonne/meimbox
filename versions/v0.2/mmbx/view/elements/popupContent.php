<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $instruction instruction to display
 * @param string $content content to display inside
 * @param string $btnId id of the button
 * @param string $btnTxt text to display on button
 * @param string $btnFunc onclick attribut for the button
 * + i.e: $btnFunc = "switchPopUp(#from, #to)"
 * + i.e: $btnFunc = "switchPopUp(#from, #to);close(#boxid)"
 * @param string $btnDataAttr data attribut for the button
 * + i.e: $btnDataAttr = "data-fromx='#hello' data-tox='#bonjour'"
 */
$btnFunc = (!empty($btnFunc)) ? 'onclick="' . $btnFunc . '"' : "";
$btnDataAttr = (!empty($btnDataAttr)) ? $btnDataAttr : "";
?>

<div class="pop_up-content-block-inner">
    <div class="popup-content-instruct-div">
        <p class="popup-content-instruct"><?= $instruction ?></p>
    </div>
    <?= $content ?>
    <?php
    if (!empty($btnId)) : ?>
        <div class="popup-add-btn-div">
            <button id="<?= $btnId ?>" class="green-button standard-button remove-button-default-att" <?= $btnFunc ?> <?= $btnDataAttr ?>><?= $btnTxt ?></button>
        </div>
    <?php
    endif; ?>
</div>