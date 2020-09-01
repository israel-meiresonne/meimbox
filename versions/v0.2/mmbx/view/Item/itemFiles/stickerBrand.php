<?php
require_once 'controller/ControllerItem.php';
/**
 * Build a brand sticker with a brand name given
 * @param string $brandName the brand's name
 */

$stickerTitle = $translator->translateStation("US46");
$stickerName = $translator->translateStation("US47");

$stickerTitleDatas["inputName"] = Size::INPUT_BRAND;
$stickerTitleDatas["inputValue"] = $brandName;
$stickerTitleDatas["stickerTitle"] = $stickerTitle;
$stickerTitleDatas["removeBtnId"] = null;
$stickerTitleDatas["btnFunc"] = null;
ob_start();
?>

<div class="sticker-content-div">
    <div class="data-key_value-wrap">
        <span class="data-key_value-key"><?= $stickerName ?>:</span>
        <span class="data-key_value-value"><?= $brandName ?></span>
    </div>
</div>
<?php
$stickerTitleDatas["content"] = ob_get_clean();
require 'view/elements/stickerTitle.php';
?>