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
// $popUpDatas["submitClass"] = "standard-button-desabled";
$popUpDatas["laodingId"] = "measurePopUp_loading";

$dad = ModelFunctionality::generateDateCode(25);
$dadx = "#" . $dad;
$brotherx = ModelFunctionality::generateDateCode(25);
$sbtnx = "#". $popUpDatas["submitButtonId"];
$popUpDatas["submitButtonFunc"] = "selectMeasure('". $sbtnx ."')";
// ob_start();
?>
    <?php //require 'view/elements/popupMeasureManagerContent.php'; ?>
<?php
    // $popUpDatas["content"] = ob_get_clean();
$datas = [
    "measures" => $measures,
    "measureUnits" => $measureUnits,
    "dad" => $dad,
    "dadx" => $dadx,
    "brotherx" => $brotherx,
    "sbtnx" => $sbtnx
];
$popUpDatas["content"] = $this->generateFile('view/elements/popupMeasureManagerContent.php', $datas);

$datas = [
    "datas" => $popUpDatas
];
echo $this->generateFile('view/elements/popup.php', $datas);
// require "view/elements/popup.php";
?>