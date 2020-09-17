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
// $additional = (isset($additional)) ? $additional : "";
// $inputName = (isset($inputName)) ? $inputName : "";
// $isRadio = isset($isRadio);

$head = ModelFunctionality::generateDateCode(25);
$headx = "#" . $head;
$body = ModelFunctionality::generateDateCode(25);
$bodyx = "#" . $body;
?>

<div class="dropdown-wrap">
    <div class="dropdown-inner">
        <div id="<?= $head ?>" class="dropdown-head dropdown-arrow-close" onclick="animateDropdown('<?= $headx ?>', '<?= $bodyx ?>');">
            <span class="dropdown-title"><?= $title ?></span>
        </div>
        <div id="<?= $body ?>" class="dropdown-checkbox-list">
            <?php
            // $datas = [
            //     "title" => $title,
            //     "checkedLabels" => $checkedLabels,
            //     "labels" => $labels,
            //     "isRadio" => $isRadio,
            //     "inputName" => $inputName,
            //     // "additional" => $additional
            // ];
            // echo $this->generateFile('view/elements/dropdownInput.php', $datas);
            require 'view/elements/dropdownInput.php';
            ?>

        </div>
    </div>
</div>