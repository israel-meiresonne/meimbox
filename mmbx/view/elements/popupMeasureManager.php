<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build the measure manager pop up
 * @param Measure[] $measures list of Visitor's Measures
 * @param string[] $measureUnit db's MeasureUnits table in map format
 */
$popUpDatas[0]["windowId"] = "mange_measure_window";
$popUpDatas[0]["title"] = $translator->translateStation("US22");
$popUpDatas[0]["closeButtonId"] = "close_measure_manager";
$popUpDatas[0]["submitButtonId"] = "measure_select_button";
$popUpDatas[0]["submitButtonTxt"] = $translator->translateStation("US34");
$popUpDatas[0]["submitIsDesabled"] = true;
$popUpDatas[0]["submitClass"] = "green-arrow-desabled";
$popUpDatas[0]["laodingId"] = "measurePopUp_loading";

$maxMeasure = Visitor::getMAX_MEASURE();
$nbMeasure = count($measures);

$managerContentTitle = $translator->translateStation("US45");
$managerAddMeasureBtn = $translator->translateStation("US44");

$measureRation = " ($nbMeasure/$maxMeasure)";
$maxMeasureAlert = $translator->translateStation("ER7") . $measureRation;
$btnAction = ($nbMeasure >= Visitor::getMAX_MEASURE()) ? 'onclick="popAlert(\'' . $maxMeasureAlert . '\')"' : 'onclick="managerSwitchMeasure()"';

// $elements[View::TITLE_KEY] = '<p>' . $managerContentTitle . $measureRation . ':</p>';
// $elements[View::BUTTON_KEY] = '<button id="manager_add_measurement_button" ' . $btnAction . ' class="green-button remove-button-default-att">' . $managerAddMeasureBtn . '</button>';
ob_start();
?>
<div class="customize_measure-content">
    <div class="customize_measure-content-inner">
        <div class="customize_measure-info-div">
            <p><?= $managerContentTitle . $measureRation ?>:</p>
        </div>
        <?php
        // $datas = ["measures" => $measures];
        // $cartDatas = $this->generateFile('view/elements/popupMeasureManagerContent.php', $datas);
        require 'view/elements/popupMeasureManagerContent.php';

        $datas = ["cartDatas" => $cartDatas];
        echo $this->generateFile('view/elements/cart.php', $datas); ?>

        <div id="manager_add_measurement" class="manager_add_measurement">
            <button id="manager_add_measurement_button" <?= $btnAction ?> class="green-button remove-button-default-att"><?= $managerAddMeasureBtn ?></button>
        </div>
    </div>
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

ob_start();
?>
<div class="customize_measure-content">
    <?php
    $supportedUnits = MeasureUnit::getSUPPORTED_UNIT();

    $bustTranslate = $translator->translateStation("US39");
    $armTranslate = $translator->translateStation("US40");
    $waistTranslate = $translator->translateStation("US41");
    $hipTranslate = $translator->translateStation("US42");
    $inseamTranslate = $translator->translateStation("US43");
    $measurreNameTranslate = $translator->translateStation("US16");
    $contentTitle = $translator->translateStation("US38");

    if (!empty($measure)) {
        $measureName = "value='" . $measure->getMeasureName() . "'";
        $bustVal = "value=" . $measure->getbust()->getValue();
        $hipVal = "value=" . $measure->gethip()->getValue();
        $armVal = "value=" . $measure->getarm()->getValue();
        $inseamVal = "value=" . $measure->getInseam()->getValue();
        $waistVal = "value=" . $measure->getwaist()->getValue();
        $unitNameObj = $measure->getwaist()->getUnitName();
        $getUnitSymbol = $measure->getwaist()->getUnit();

        $measure_id = $measure->getMeasureID();
        $inputMeasureID = '<input type="hidden" name="' . Measure::MEASURE_ID_KEY . '" value="' . $measure_id . '">';

        // $dataMeasure = [
        // Measure::MEASURE_ID_KEY => $measure->getMeasureID()
        // ];
        // $dataMeasure_json = json_encode($dataMeasure);
        // $dataMeasureAttr = 'data-measure=\'' . $dataMeasure_json . '\'';
    } else {
        $measureName = null;
        $bustVal = null;
        $hipVal = null;
        $armVal = null;
        $inseamVal = null;
        $waistVal = null;
        $unitNameObj = null;
        $inputMeasureID = null;
        $getUnitSymbol = null;
    }
    ?>
    <div class="customize_measure-content-inner">
        <div class="customize_measure-info-div">
            <p><?= $contentTitle ?></p>
        </div>

        <div class="customize_measure-input-block">
            <div class="measure_body-img-container">
                <img src="content/brain/permanent/body-measure-women.png">
            </div>
            <div class="measure_input-container">
                <div class="measure_input-container-inner">
                    <form id="add_measure_form">
                        <?= $inputMeasureID ?>
                        <div class="measure_input-div">
                            <div class="measure_input-checkbox-conatiner">
                                <div class="checkbox_set-wrap">
                                    <div class="checkbox_set-content-div">
                                        <?php
                                        $addMeasureCheckbox = "";
                                        foreach ($supportedUnits as $unitName) :
                                            $measureUnit = $measureUnits[$unitName]["measureUnit"];
                                            $unitNameChecked = ((!empty($unitNameObj) && $unitName == $unitNameObj)) ? "checked=true" : "";
                                        ?>
                                            <div class="checkbox-container">
                                                <label class="checkbox-label" for="measure_unit_<?= $unitName ?>"><?= $measureUnit ?>
                                                    <input id="measure_unit_<?= $unitName ?>" data-unit="<?= $measureUnit ?>" type="radio" name="<?= MeasureUnit::INPUT_MEASURE_UNIT ?>" value="<?= $unitName ?>" <?= $unitNameChecked ?>>
                                                    <span class="checkbox-checkmark"></span>
                                                </label>
                                            </div>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>
                                    <div class="checkbox_error-div">
                                        <p class="comment"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="measure_input-div">
                                <div class="input-container">
                                    <div class="input-wrap">
                                        <label class="input-label" for=""><?= $measurreNameTranslate ?></label>
                                        <span class="input-unit"></span>
                                        <input class="input-tag" type="text" <?= $measureName ?> name="<?= Measure::INPUT_MEASURE_NAME ?>" placeholder="<?= $measurreNameTranslate ?>">
                                        <p class="comment"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="measure_input-input-group">
                                <div class="input-container">
                                    <div class="input-wrap">
                                        <label class="input-label" for=""><?= $bustTranslate ?></label>
                                        <span class="input-unit"><?= $getUnitSymbol ?></span>
                                        <input class="input-tag" type="text" <?= $bustVal ?> name="<?= Measure::INPUT_BUST ?>" placeholder="<?= $bustTranslate ?>">
                                        <p class="comment"></p>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <div class="input-wrap">
                                        <label class="input-label" for=""><?= $armTranslate ?></label>
                                        <span class="input-unit"><?= $getUnitSymbol ?></span>
                                        <input class="input-tag" type="text" <?= $armVal ?> name="<?= Measure::INPUT_ARM ?>" placeholder="<?= $armTranslate ?>">
                                        <p class="comment"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="measure_input-div">
                            <div class="measure_input-input-group">
                                <div class="input-container">
                                    <div class="input-wrap">
                                        <label class="input-label" for=""><?= $waistTranslate ?></label>
                                        <span class="input-unit"><?= $getUnitSymbol ?></span>
                                        <input class="input-tag" type="text" <?= $waistVal ?> name="<?= Measure::INPUT_WAIST ?>" placeholder="<?= $waistTranslate ?>">
                                        <p class="comment"></p>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <div class="input-wrap">
                                        <label class="input-label" for=""><?= $hipTranslate ?></label>
                                        <span class="input-unit"><?= $getUnitSymbol ?></span>
                                        <input class="input-tag" type="text" <?= $hipVal  ?> name="<?= Measure::INPUT_HIP ?>" placeholder="<?= $hipTranslate ?>">
                                        <p class="comment"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="measure_input-div">
                            <div class="input-container">
                                <div class="input-wrap">
                                    <label class="input-label" for=""><?= $inseamTranslate ?></label>
                                    <span class="input-unit"><?= $getUnitSymbol ?></span>
                                    <input class="input-tag" type="text" <?= $inseamVal ?> name="<?= Measure::INPUT_INSEAM ?>" placeholder="<?= $inseamTranslate ?>">
                                    <p class="comment"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$popUpDatas[1]["content"] = ob_get_clean(); 
require "view/elements/popup.php";
?>