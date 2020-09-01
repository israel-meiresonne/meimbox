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
$maxMeasureAlert = $translator->translateStation("ER7") . $measureRation;
$btnAction = ($nbMeasure >= $maxMeasure) ? 'onclick="popAlert(\'' . $maxMeasureAlert . '\')"' : 'onclick="managerSwitchMeasure()"';
?>
<button id="manager_add_measurement_button" <?= $btnAction ?> class="green-button remove-button-default-att"><?= $managerAddMeasureBtn ?></button>