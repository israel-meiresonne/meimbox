<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $title name of the dropdown element
 * @param string[] $checkedLabels list of checked input label
 * @param string[] $labels list of input label that return a input value
 * $labels => [
 *          label => paramName
 *      ]
 * + label : used as displayed name and as input's value attribut
 * + paramName : used as input's name attribut
 * @param Translator $translator the View's translator. 
 * + NOTE: it's the only instance of this class in the whole system.
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
            foreach ($labels as $label => $paramName) : // box item
                $checkedAtt = in_array($label, $checkedLabels) ? 'checked="true"' : "";
                $inputName = $paramName . "_" . $inputId;
                $inputId++;
            ?>
                <div class="dropdown-checkbox-block">
                    <label class="checkbox-label"><?= $translator->translateString($label) ?>
                        <input type="checkbox" name="<?= $inputName ?>" value="<?= $label ?>" <?= $checkedAtt ?>>
                        <span class="checkbox-checkmark"></span>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>