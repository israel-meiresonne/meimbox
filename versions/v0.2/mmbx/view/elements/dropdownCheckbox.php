<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $titleId the id of the checkbox input in the head
 * @param string $title the dropdown title
 * @param string $inputName the name attribut of the head's checkbox
 * @param string $inputValue the value of the head's checkbox
 * @param string $dataAttributs input in head's data attributs
 * @param string $isRadio indicate if the checkbox in the  head are radio or just checkbox
 * + NOTE: set true if it radio else false
 * @param string $content the content of the dropdown
 */

$inputType = (isset($isRadio) && $isRadio) ? "radio" : "checkbox";
$inp = ModelFunctionality::generateDateCode(25);
$inpx = "#" . $inp;
$body = ModelFunctionality::generateDateCode(25);
$bodyx = "#" . $body;
?>
<div class="dropdown_checkbox-wrap">
    <div class="dropdown_checkbox-head">
        <label class="checkbox-label" for="<?= $inp ?>"><?= $title ?>
            <input id="<?= $inp ?>" onclick="animateDropdownCheckbox('<?= $inpx ?>', '<?= $bodyx ?>');" type="<?= $inputType ?>" name="<?= $inputName ?>" value="<?= $inputValue ?>" <?= $dataAttributs ?>>
            <span class="checkbox-checkmark"></span>
        </label>
    </div>
    <div id="<?= $body ?>" data-headid="<?= $inp ?>" data-inputname="<?= $inputName ?>" class="dropdown_checkbox-checkbox-list">
        <?= $content ?>
    </div>
</div>