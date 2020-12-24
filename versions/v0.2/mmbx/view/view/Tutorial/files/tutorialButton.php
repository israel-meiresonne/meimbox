<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $id       id of the current step
 * @param string $nextId   id of the next step
 * @param string $type     type of the button
 */
/**
 * @var Translator */
$translator = $translator;
switch ($type):
    case Tutorial::TYPE_SKIP: ?>
        <button onclick="displayFadeOut('#<?= $id ?>')" class="tutorial_butttons-container-button tutorial_butttons-skip"><?= ucfirst($translator->translateStation("US151")) ?></button>
    <?php break;
    case Tutorial::TYPE_NEXT: ?>
        <button onclick="switchTuto('#<?= $id ?>','#<?= $nextId ?>')" class="tutorial_butttons-container-button tutorial_butttons-next green-arrow remove-button-default-att"><?= ucfirst($translator->translateStation("US152")) ?></button>
    <?php break;
    case Tutorial::TYPE_CLOSE: ?>
        <button onclick="displayFadeOut('#<?= $id ?>')" class="tutorial_butttons-container-button tutorial_butttons-close"><?= ucfirst($translator->translateStation("US31")) ?></button>
<?php break;
    default:
        throw new Exception("Unkow Tutorial's button type '$type'");
        break;
endswitch;
?>