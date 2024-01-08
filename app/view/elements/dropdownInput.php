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
 * @param string|null $func function for input
 * @param string|null $TagParams additional params to place on input tag
 * + i.e.: "data-mydate='value' myFunction='newFunction()'"
 * ——— RADIO PARAMS ———
 * @param boolean $isRadio indicate if the inputs are radio or just checkbox
 * + NOTE: set true if it radio else false
 * @param string $inputName the input's name (needed only if $isRadio = true)
 */
$TagParams = (!empty($TagParams)) ? $TagParams : null;
$inputId = 0;
$inputType = (isset($isRadio) && $isRadio) ? "radio" : "checkbox";
$Tagfunc = (!empty($func)) ? 'onclick="'.$func.'";' : null;
foreach ($labels as $label => $paramName) : // box item
    $checkedAt = in_array($label, $checkedLabels) ? 'checked="true"' : "";
    if ((isset($isRadio) && $isRadio)) {
        $inputName = strtolower(str_replace(" ", "", $inputName));
    } else {
        $inputName = $paramName . "_" . $inputId;
        $inputId++;
    }
?>
    <div class="dropdown-checkbox-block">
        <label class="checkbox-label"><?= $translator->translateString($label) ?>
            <input <?= $checkedAt ?> <?= $Tagfunc ?> <?= $TagParams ?> type="<?= $inputType ?>" name="<?= $inputName ?>" value="<?= $label ?>">
            <span class="checkbox-checkmark"></span>
        </label>
    </div>
<?php
endforeach;
