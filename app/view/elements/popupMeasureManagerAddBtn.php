<?php
require_once 'model/users-management/Visitor.php';
/**
 * Build measure manager's add button
 * @param Measure[] $measures list of Visitor's Measures
 */
$maxMeasure = Visitor::getMAX_MEASURE();
$nbMeasure = count($measures);

$managerAddMeasureBtn = $translator->translateStation("US44");

$measureRation = " ($nbMeasure/$maxMeasure)";
$maxMeasureAlert = $translator->translateStation("ER8") . $measureRation;
$func = ($nbMeasure >= $maxMeasure) ? "popAlert('$maxMeasureAlert');" : "evt('evt_cd_101');switchPopUp('#measure_manager', '#measure_adder', setAddMsr);";
?>
<button id="manager_add_measurement_button" onclick="<?= $func ?>" class="green-button standard-button remove-button-default-att"><?= $managerAddMeasureBtn ?></button>