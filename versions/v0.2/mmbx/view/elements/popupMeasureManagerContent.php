<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build cart element with measure
 * @param Measure[] $measures list of Visitor's Measures
 * @param string[] $measureUnits db's MeasureUnits table in map format
 * @param string $dad id of the dad
 * @param string $dadx selector of the dad
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother
 * @param string $sbtnx selector of the submit button
 */

$bustTranslate = $translator->translateStation("US39");
$hipTranslate = $translator->translateStation("US42");
$armTranslate = $translator->translateStation("US40");
$inseamTranslate = $translator->translateStation("US43");
$waistTranslate = $translator->translateStation("US41");
$editBtnTranslate = $translator->translateStation("US49");

?>
<div class="customize_measure-content">
    <div class="customize_measure-content-inner">
        <div class="customize_measure-info-div">
            <?php
            echo $this->generateFile('view/elements/popupMeasureManagerTitle.php', ["measures" => $measures]);
            ?>
        </div>
        <div class="cart-wrap">
            <ul id="<?= $dad ?>" class="remove-ul-default-att" data-sbtnx="<?= $sbtnx ?>">
                <?php
                foreach ($measures as $measure) :
                    $launch = ModelFunctionality::generateDateCode(25);
                    $launchx = "#" . $launch;

                    $flag = ModelFunctionality::generateDateCode(25);
                    $flagx = "#" . $flag;

                    $measure_id = $measure->getMeasureID();
                    $measureName = $measure->getMeasureName();
                    $bustVal = $measure->getbust()->getFormated();
                    $hipVal = $measure->gethip()->getFormated();
                    $armVal = $measure->getarm()->getFormated();
                    $inseamVal = $measure->getInseam()->getFormated();
                    $waistVal = $measure->getwaist()->getFormated();

                    $dataMeasure = [
                        Measure::KEY_MEASURE_ID => $measure_id
                    ];
                    $dataMeasure_json = json_encode($dataMeasure);

                    $measureSelector = 'onclick="selectMeasurement(\'' . $measure_id . '\')" data-measure_id="' . $measure_id . '"';

                    $removeBtnFunc = 'onclick="removeMsr(\'' . $measure_id . '\')" data-measure_id=\'' . $measure_id . '\' data-measure=\'' . $dataMeasure_json . '\'';

                    // $editBtnFunc = 'onclick="getMsrAdder(\'' . $measure_id . '\')" data-measure_id=\'' . $measure_id . '\' data-measure=\'' . $dataMeasure_json . '\'';
                ?>

                    <li class="li-cart-element-container remove-li-default-att">
                        <div id="<?= $flag ?>" class="cart-element-wrap" data-brotherx="<?= $brotherx ?>" data-submitdata='<?= $dataMeasure_json ?>'>
                            <div class="cart-element-inner">
                                <div class="cart-element-remove-button-block">
                                    <button <?= $removeBtnFunc ?> class="close_button-wrap remove-button-default-att">
                                        <div class="plus_symbol-wrap">
                                            <span class="plus_symbol-vertical"></span>
                                            <span class="plus_symbol-horizontal"></span>
                                        </div>
                                    </button>
                                </div>
                                <div id="<?= $launch ?>" class="cart-element-detail-block" onclick="selectPopUp('<?= $launchx ?>')" data-flagx="<?= $flagx ?>" data-dadx="<?= $dadx ?>">
                                    <div class="cart-element-property-set">
                                        <div class="manager-measure-property-set">
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
                                    </div>
                                </div>

                                <div class="cart-element-edit-block no_price_block">
                                    <div class="cart-element-edit-inner">
                                        <button class="cart-element-edit-button remove-button-default-att" onclick="getMsrAdder('<?= $measure_id ?>', () => {switchPopUp('#measure_manager','#measure_adder',()=>{},setUpdateMsr)})" data-measure_id="<?= $measure_id ?>" data-measure='<?= $dataMeasure_json ?>'><?= $editBtnTranslate ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div id="manager_add_measurement" class="popup-add-btn-div">
            <?php
            $datas = [
                "measures" => $measures
            ];
            echo $this->generateFile('view/elements/popupMeasureManagerAddBtn.php', $datas);
            ?>
        </div>
    </div>
</div>