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
 * @param boolean $isDisplayed set true to display content else set false or empty
 * @param string $dpdAttr attribut to place on dropdown
 */
$dpdAttr = (!empty($dpdAttr)) ? $dpdAttr : null;
// $additional = (isset($additional)) ? $additional : "";
// $inputName = (isset($inputName)) ? $inputName : "";
// $isRadio = isset($isRadio);

$head = ModelFunctionality::generateDateCode(25);
$headx = "#" . $head;
$body = ModelFunctionality::generateDateCode(25);
$bodyx = "#" . $body;

$Tagdisplay = (!empty($isDisplayed)) ? 'style="display:block;"' : null;
?>

<div class="dropdown-wrap">
    <div class="dropdown-inner">
        <div id="<?= $head ?>" <?= $dpdAttr ?> class="dropdown-head dropdown-arrow-close" onclick="animateDropdown('<?= $headx ?>', '<?= $bodyx ?>');">
            <span class="dropdown-title"><?= $title ?></span>
        </div>
        <div id="<?= $body ?>" class="dropdown-checkbox-list" <?= $Tagdisplay ?>>
            <?php require 'view/elements/dropdownInput.php'; ?>
        </div>
    </div>
</div>