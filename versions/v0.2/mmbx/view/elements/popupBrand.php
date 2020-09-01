<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Provide the all attribut needed to build  a pop up
 * @param string[] $brandsMeasures db's BrandsMeasures table mapped
 */
$popUpDatas = [];
$popUpDatas["title"] = $translator->translateStation("US33");
$popUpDatas["closeButtonId"] = "brand_reference_close_button";
$popUpDatas["laodingId"] = "brandPopUp_loading";
$popUpDatas["submitButtonId"] = "brand_validate_button";
$popUpDatas["submitButtonTxt"] = $translator->translateStation("US34");
$popUpDatas["submitIsDesabled"] = true;
$popUpDatas["submitClass"] = "green-arrow-desabled";
$contentTitle = $translator->translateStation("US35");
ob_start();
?>
<div class="brand_reference-content">
    <div class="brand_reference-info-div">
        <p><?= $contentTitle ?></p>
    </div>
    <div class="brand_reference-grid-container">
        <?php
        foreach ($brandsMeasures as $brandName => $brandDatas) :
            $dataBrand = [
                ControllerItem::BRAND_NAME_KEY => $brandName
            ];
            $dataBrand_json = json_encode($dataBrand);
        ?>
            <div class="brand_reference-grid-img-block" data-brand='<?= $dataBrand_json ?>'>
                <div class="first-img-div">
                    <img src="content/brain/brand/<?= $brandDatas["brandPictures"][1] ?>">
                </div>
                <div class="second-img-div">
                    <img src="content/brain/brand/<?= $brandDatas["brandPictures"][2] ?>">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$popUpDatas["content"] = ob_get_clean();

$datas = [
    "datas" => $popUpDatas
];
echo $this->generateFile('view/elements/popup.php', $datas);
// require "view/elements/popup.php";
?>