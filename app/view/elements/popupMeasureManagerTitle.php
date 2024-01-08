<?php
require_once 'model/users-management/Visitor.php';
/**
 * Build measure manager's title
 * @param Measure[] $measures list of Visitor's Measures
 */
$maxMeasure = Visitor::getMAX_MEASURE();
$nbMeasure = count($measures);

$managerContentTitle = $translator->translateStation("US45");

$measureRation = " ($nbMeasure/$maxMeasure)";
?>
<p><?= $managerContentTitle . $measureRation ?>:</p>