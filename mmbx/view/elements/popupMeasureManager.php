<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build the measure manager pop up
 * @param Measure[] $measures list of Visitor's Measures
 * @param string[] $measureUnits db's MeasureUnits table in map format
 */
$popUpDatas[0]["windowId"] = "mange_measure_window";
$popUpDatas[0]["title"] = $translator->translateStation("US22");
$popUpDatas[0]["closeButtonId"] = "close_measure_manager";
$popUpDatas[0]["submitButtonId"] = "measure_select_button";
$popUpDatas[0]["submitButtonTxt"] = $translator->translateStation("US34");
$popUpDatas[0]["submitIsDesabled"] = true;
$popUpDatas[0]["submitClass"] = "green-arrow-desabled";
$popUpDatas[0]["laodingId"] = "measurePopUp_loading";

// $maxMeasure = Visitor::getMAX_MEASURE();
// $nbMeasure = count($measures);

ob_start();
?>
<div class="customize_measure-content">
    <?php require 'view/elements/popupMeasureManagerContent.php'; ?>
</div>
<?php
$popUpDatas[0]["content"] = ob_get_clean();

$popUpDatas[1]["windowId"] = "add_measure_window";
$popUpDatas[1]["title"] = $translator->translateStation("US36");
$popUpDatas[1]["closeButtonId"] = "measure_adder_close_button";
$popUpDatas[1]["submitButtonId"] = "save_measure_button";
$popUpDatas[1]["submitButtonTxt"] = $translator->translateStation("US37");
$popUpDatas[1]["submitIsDesabled"] = true;
$popUpDatas[1]["submitClass"] = "green-arrow-desabled";
$popUpDatas[1]["laodingId"] = "add_measurePopUp_loading";
$popUpDatas[1]["forFormId"] = "add_measure_form";
$popUpDatas[1]["submitButtonFunc"] = "saveMsr()";

// ob_start();

// $popUpDatas[1]["content"] = ob_get_clean();
$datas = [
    "measure" => null,
    "measureUnits" => $measureUnits
];
$popUpDatas[1]["content"] = $this->generateFile('view/elements/popupMeasureAdder.php', $datas);
require "view/elements/popup.php";
?>