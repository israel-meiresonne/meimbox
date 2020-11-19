<?php

/**
 * Build a Measure sticker with a Measure given
 * @param Measure $measure Visitor's measure
 * @param string $TagInput $TagParams additional params to place on input tag
 * + i.e.: "data-mydate='value' myFunction='newFunction()'"
 */
$TagInput = (!empty($$TagInput)) ? $TagInput : null;

$measure_id = $measure->getMeasureID();
$measureName = $measure->getMeasureName();
$stickerTitle = $translator->translateStation("US46");
$stickerName = $translator->translateStation("US48");

$stickerTitleDatas["inputName"] = Measure::KEY_MEASURE_ID;
$stickerTitleDatas["inputValue"] = $measure_id;
$stickerTitleDatas["stickerTitle"] = $stickerTitle;
$stickerTitleDatas["removeBtnId"] = null;
$stickerTitleDatas["btnFunc"] = null;

ob_start();
?>
<div class="sticker-content-div">
    <div class="data-key_value-wrap">
        <span class="data-key_value-key"><?= $stickerName ?>:</span>
        <span class="data-key_value-value"><?= $measureName ?></span>
    </div>
</div>
<?php
$stickerTitleDatas["content"] = ob_get_clean();

$datas = [
    "stickerTitleDatas" => $stickerTitleDatas,
    "TagInput" => $TagInput
];
echo $this->generateFile('view/elements/stickerTitle.php', $datas);