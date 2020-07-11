<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build cart element with measure
 * @param Measure[] $measures list of Visitor's Measures
 */

$bustTranslate = $translator->translateStation("US39");
$hipTranslate = $translator->translateStation("US42");
$armTranslate = $translator->translateStation("US40");
$inseamTranslate = $translator->translateStation("US43");
$waistTranslate = $translator->translateStation("US41");
$editBtnTranslate = $translator->translateStation("US49");

$cartDatas = [];

foreach ($measures as $measure) {
    $measure_id = $measure->getMeasureID();
    $measureName = $measure->getMeasureName();
    $bustVal = $measure->getbust()->getFormated();
    $hipVal = $measure->gethip()->getFormated();
    $armVal = $measure->getarm()->getFormated();
    $inseamVal = $measure->getInseam()->getFormated();
    $waistVal = $measure->getwaist()->getFormated();

    $dataMeasure = [
        Measure::MEASURE_ID_KEY => $measure_id
    ];
    $dataMeasure_json = json_encode($dataMeasure);

    $measureSelector = 'onclick="selectMeasurement(\'' . $measure_id . '\')" data-measure_id="' . $measure_id . '"';

    $removeBtnFunc = 'onclick="removeMsr(\'' . $measure_id . '\')" data-measure_id=\'' . $measure_id . '\' data-measure=\'' . $dataMeasure_json . '\'';

    $editBtnFunc = 'onclick="getMsrAdder(\'' . $measure_id . '\')" data-measure_id=\'' . $measure_id . '\' data-measure=\'' . $dataMeasure_json . '\'';
    ob_start();
?>
    <div class="manager-measure-property-set" <?= $measureSelector ?> data-measure="<?= $dataMeasure_json ?>">
        <div class="measure-property-title cart-element-property-div">
            <span><?= $measureName ?></span>
        </div>
        <div class="double-flex-50-parent">
            <div class="cart-element-property-div double-flex-50-child">
                <span class="cart-element-property"><?= $bustTranslate ?>: </span>
                <span class="cart-element-value"><?= $bustVal ?></span>
            </div>
            <div class="cart-element-property-div double-flex-50-child">
                <span class="cart-element-property"><?= $hipTranslate ?>: </span>
                <span class="cart-element-value"><?= $hipVal ?></span>
            </div>
        </div>
        <div class="double-flex-50-parent">
            <div class="cart-element-property-div double-flex-50-child">
                <span class="cart-element-property"><?= $armTranslate ?>: </span>
                <span class="cart-element-value"><?= $armVal ?></span>
            </div>
            <div class="cart-element-property-div double-flex-50-child">
                <span class="cart-element-property"><?= $inseamTranslate ?>: </span>
                <span class="cart-element-value"><?= $inseamVal ?></span>
            </div>
        </div>
        <div class="double-flex-50-parent">
            <div class="cart-element-property-div">
                <span class="cart-element-property"><?= $waistTranslate ?>: </span>
                <span class="cart-element-value"><?= $waistVal ?></span>
            </div>
        </div>
    </div>
    <?php
    $cartContent = ob_get_clean();

    ob_start(); ?>

    <button <?= $removeBtnFunc ?> class="close_button-wrap remove-button-default-att">
        <div class="plus_symbol-wrap">
            <span class="plus_symbol-vertical"></span>
            <span class="plus_symbol-horizontal"></span>
        </div>
    </button>
<?php
    $removeBtn = ob_get_clean();

    $editBtn = '<button class="cart-element-edit-button remove-button-default-att" ' . $editBtnFunc . ' >' . $editBtnTranslate . '</button>';

    $key = $measure->getDateInSec();
    $cartDatas[$key]["content"] = $cartContent;
    $cartDatas[$key]["removeBtn"] = $removeBtn;
    $cartDatas[$key]["editBtn"] = $editBtn;
}
// return $cartDatas;
?>