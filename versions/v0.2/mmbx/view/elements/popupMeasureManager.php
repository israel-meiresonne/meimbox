<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build the measure manager pop up
 * @param Measure[] $measures list of Visitor's Measures
 * @param string[] $measureUnits db's MeasureUnits table in map format
 */
$popUpDatas["windowId"] = "mange_measure_window";
$popUpDatas["title"] = $translator->translateStation("US22");
$popUpDatas["closeButtonId"] = "close_measure_manager";
$popUpDatas["submitButtonId"] = "measure_select_button";
$popUpDatas["submitButtonTxt"] = $translator->translateStation("US34");
$popUpDatas["submitIsDesabled"] = true;
$popUpDatas["submitClass"] = "green-arrow-desabled";
$popUpDatas["laodingId"] = "measurePopUp_loading";

// $maxMeasure = Visitor::getMAX_MEASURE();
// $nbMeasure = count($measures);

ob_start();
?>
<div class="customize_measure-content">
    <?php require 'view/elements/popupMeasureManagerContent.php'; ?>
</div>
<?php
$popUpDatas["content"] = ob_get_clean();
$datas = [
    "datas" => $popUpDatas
];
echo $this->generateFile('view/elements/popup.php', $datas);
// require "view/elements/popup.php";
?>