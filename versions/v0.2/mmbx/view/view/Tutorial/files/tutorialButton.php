<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $tutoID    id of the Tutorial in database
 * @param string $eventCode Tutorial's event code
 * @param string $id        id of the current step
 * @param string $nextId    id of the next step
 * @param string $type      type of the button
 * @param string $name      name of the step
 * @param string $position  position of the step
 * @param string $nbStep    total number of steps
 */
/**
 * @var Translator */
$translator = $translator;

$datas = [
    Tutorial::NAME_K => $name,
    Tutorial::STEP_POSITION_K => $position,
    Tutorial::STEP_TOT_K => $nbStep,
    Tutorial::STEP_ACTION_K => $type
];
$json = htmlentities(json_encode($datas));

switch ($type):
    case Tutorial::TYPE_SKIP: ?>
        <button onclick="displayFadeOut('#<?= $id ?>');evtTuto('<?= $tutoID ?>','<?= $type ?>','<?= $eventCode ?>','<?= $json ?>')" class="tutorial_butttons-container-button tutorial_butttons-skip"><?= ucfirst($translator->translateStation("US151")) ?></button>
    <?php break;
    case Tutorial::TYPE_NEXT: ?>
        <button onclick="switchTuto('#<?= $id ?>','#<?= $nextId ?>');evtTuto('<?= $tutoID ?>','<?= $type ?>','<?= $eventCode ?>','<?= $json ?>')" class="tutorial_butttons-container-button tutorial_butttons-next green-arrow remove-button-default-att"><?= ucfirst($translator->translateStation("US152")) ?></button>
    <?php break;
    case Tutorial::TYPE_CLOSE: ?>
        <button onclick="displayFadeOut('#<?= $id ?>');evtTuto('<?= $tutoID ?>','<?= $type ?>','<?= $eventCode ?>','<?= $json ?>')" class="tutorial_butttons-container-button tutorial_butttons-close"><?= ucfirst($translator->translateStation("US31")) ?></button>
<?php break;
    default:
        throw new Exception("Unkow Tutorial's button type '$type'");
        break;
endswitch;
?>