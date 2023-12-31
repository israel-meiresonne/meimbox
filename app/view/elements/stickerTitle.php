<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build a sticker with a title and an input
 * @param string[] $stickerTitleDatas provide datas needed to build a sticker with title
 * $stickerTitleDatas = [
 *      "inputName" => string,
 *      "inputValue" => string,
 *      "stickerTitleDatas" => string,
 *       
 *      "content" => string,
 *      "removeBtnId" => string,
 *      "btnFunc" => string,{ex: "myFunction(param)"}
 * ]
 * @param string $TagInput $TagParams additional params to place on input tag
 * + i.e.: "data-mydate='value' myFunction='newFunction()'"
 */
$TagInput = (!empty($$TagInput)) ? $TagInput : null;

$stickerDatas = [
    "content" => $stickerTitleDatas["content"],
    "removeBtnId" => $stickerTitleDatas["removeBtnId"],
    "btnFunc" => $stickerTitleDatas["btnFunc"]
];
?>
<div class="custom_selected-inner">
    <input <?= $TagInput ?> name="<?= $stickerTitleDatas["inputName"] ?>" type="hidden" value="<?= $stickerTitleDatas["inputValue"] ?>">
    <div class="custom_selected-title-div">
        <p class="custom_selected-title"><?= $stickerTitleDatas["stickerTitle"] ?>:</p>
    </div>
    <div class="sticker-container">
        <?= $this->generateFile('view/elements/sticker.php', ["stickerDatas" => $stickerDatas]); ?>
    </div>
</div>