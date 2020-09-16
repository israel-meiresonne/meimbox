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
$popUpDatas["submitClass"] = "standard-button-desabled";
$contentTitle = $translator->translateStation("US35");

$dadId = ModelFunctionality::generateDateCode(25);
$dadx = "#" . $dadId;
$brotherx = "#" . ModelFunctionality::generateDateCode(25);
$sbtnx = "#". $popUpDatas["submitButtonId"];

$popUpDatas["submitButtonFunc"] = "selectBrand('". $sbtnx ."')";
ob_start();
?>
<div class="pop_up-content-block-inner">
    <div class="brand_reference-info-div">
        <p><?= $contentTitle ?></p>
    </div>
    <div id="<?= $dadId ?>" class="brand_reference-grid-container" data-sbtnx="<?= $sbtnx ?>">
        <?php
        foreach ($brandsMeasures as $brandName => $brandDatas) :
            $dataBrand = [
                SIze::KEY_BRAND_NAME => $brandName
            ];
            $dataBrand_json = json_encode($dataBrand);
            $launch = ModelFunctionality::generateDateCode(25);
            $launchx = "#" . $launch;
        ?>
            <div id="<?= $launch ?>" class="brand_reference-grid-img-block" onclick="selectPopUp('<?= $launchx ?>')" data-flagx="<?= $launchx ?>" data-dadx="<?= $dadx ?>" data-brotherx="<?= $brotherx ?>" data-submitdata='<?= $dataBrand_json ?>'>
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