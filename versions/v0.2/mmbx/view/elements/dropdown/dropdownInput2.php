<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Map $inputMap map with all necessary datas to build a input
 * + $inputMap[label] =>[
 *          Map::inputName => string,
 *          Map::inputValue => string,
 *          Map::isChecked => boolean,  // set true to check input else false
 *          Map::inputFunc => string|null,   // function to place on the input
 *      ]
 * + 🚨only one input of $inputMap can has Map::isChecked = true
 * @param string $func function placed on all input
 * @param boolean $isRadio indicate if the inputs are radio or just checkbox
 * + NOTE: set true if it radio else false
 */

/**
 * @var Map
 */
$inputMap = $inputMap;
$labels = $inputMap->getKeys();

$inputType = ($isRadio) ? "radio" : "checkbox";
// if (!empty($func)) {
//     $Tagfunc = 'onclick="' . $func . ";" . $inputFunc . '";';
// } else if (!empty($inputFunc)) {
//     $Tagfunc = 'onclick="' . $inputFunc . '";';
// } else {
//     $Tagfunc = null;
// }
$Tagfunc = (!empty($func)) ? 'onclick="' . $func : null;
foreach ($labels as $label) :
    $Tagchecked = ($inputMap->get($label, Map::isChecked)) ? 'checked="true"' : null;
    $inputFunc = $inputMap->get($label, Map::inputFunc);

?>
    <div class="dropdown-checkbox-block">
        <label class="checkbox-label"><?= $translator->translateString($label) ?>
            <input <?= $Tagfunc . ';' . $inputFunc . ';"' ?> type="<?= $inputType ?>" name="<?= $inputMap->get($label, Map::inputName) ?>" value="<?= $inputMap->get($label, Map::inputValue) ?>" <?= $Tagchecked ?>>
            <span class="checkbox-checkmark"></span>
        </label>
    </div>
<?php
endforeach;
