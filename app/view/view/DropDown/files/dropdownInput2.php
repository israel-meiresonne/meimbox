<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Map $inputMap map with all necessary datas to build a input
 *                      + $inputMap[label][Map::inputName]  =>  string,
 *                      + $inputMap[label][Map::inputValue] =>  string,
 *                      + $inputMap[label][Map::isChecked]  =>  boolean,    // set true to check input else false
 *                      + $inputMap[label][Map::attribut]   =>  string|null // attribut to add on input tag (can place function, data-* etc...)
 *                      + 🚨only one input of $inputMap can has Map::isChecked = true
 * @param boolean $isRadio indicate if the inputs are radio or just checkbox
 * + NOTE: set true if it radio else false
 */

/**
 * @var Map
 */
$inputMap = $inputMap;
$labels = $inputMap->getKeys();

$inputType = ($isRadio) ? "radio" : "checkbox";
foreach ($labels as $label) :
    $Tagchecked = ($inputMap->get($label, Map::isChecked)) ? 'checked="true"' : null;
    $TagAttr = $inputMap->get($label, Map::attribut);
    $inpid = ModelFunctionality::generateDateCode(25);
?>
    <div class="dropdown-checkbox-block">
        <label class="checkbox-label" for="<?= $inpid ?>"><?= $label ?>
            <input id="<?= $inpid ?>" <?= $Tagchecked ?> <?= $TagAttr ?> type="<?= $inputType ?>" name="<?= $inputMap->get($label, Map::inputName) ?>" value="<?= $inputMap->get($label, Map::inputValue) ?>">
            <span class="checkbox-checkmark"></span>
        </label>
    </div>
<?php
endforeach;
