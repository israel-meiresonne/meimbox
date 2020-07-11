<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $title name of the dropdown element
 * @param string[] $checkedLabels list of checked input label
 * @param string[] $labels list of input label that return the name of the input
 * $labels => [
 *          label => paramName
 *      ]
 * + label : used as displayed name and as input's value attribut
 * + paramName : used as input's name attribut
 * ——— RADIO PARAMS ———
 * @param boolean $isRadio indicate if the inputs are radio or just checkbox
 * + NOTE: set true if it radio else false
 * @param string $inputName the input's name
 */
?>

<div class="dropdown-wrap">
    <div class="dropdown-inner">
        <div class="dropdown-head dropdown-arrow-close">
            <span class="dropdown-title"><?= $title ?></span>
        </div>
        <div class="dropdown-checkbox-list">
            <?php
            $inputId = 0;
            $inputType = (isset($isRadio) && $isRadio) ? "radio" : "checkbox";
            foreach ($labels as $label => $paramName) : // box item
                $checkedAtt = in_array($label, $checkedLabels) ? 'checked="true"' : "";
                if ((isset($isRadio) && $isRadio)) {
                    $inputName = strtolower(str_replace(" ", "", $inputName));
                } else {
                    $inputName = $paramName . "_" . $inputId;
                    $inputId++;
                }
                // $inputName =  ? strtolower(str_replace(" ", "", $inputName)) : $paramName . "_" . $inputId;
                // $inputName = $paramName . "_" . $inputId; // X
            ?>
                <div class="dropdown-checkbox-block">
                    <label class="checkbox-label"><?= $translator->translateString($label) ?>
                        <input type="<?= $inputType ?>" name="<?= $inputName ?>" value="<?= $label ?>" <?= $checkedAtt ?>>
                        <span class="checkbox-checkmark"></span>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>