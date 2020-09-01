<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string[] $stickerDatas list of param needed to build a sticker
 * $stickerDatas = [
 *      "content" => string,
 *      "removeBtnId" => string,
 *      "btnFunc" => string,{ex: "myFunction(param)"}
 * ]
 */

$removeBtnId = (!empty($stickerDatas["removeBtnId"])) ? 'id="' . $stickerDatas["removeBtnId"] . '"' : null;
$btnFunc = (!empty($stickerDatas["btnFunc"])) ? 'onclick="' . $stickerDatas["btnFunc"] . '"' : null;
?>
<div class="sticker-wrap">
    <div class="sticker-content-div">
        <?= $stickerDatas["content"] ?>
    </div>
    <button <?= $removeBtnId ?> <?= $btnFunc ?> class="sticker-button remove-button-default-att">
        <span class="sticker-x-left"></span>
        <span class="sticker-x-right"></span>
    </button>
</div>