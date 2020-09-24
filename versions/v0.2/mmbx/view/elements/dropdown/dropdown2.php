<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $title name of the dropdown element
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
 * @param boolean $isDisplayed set true to display content else set false
 */

$head = ModelFunctionality::generateDateCode(25);
$headx = "#" . $head;
$body = ModelFunctionality::generateDateCode(25);
$bodyx = "#" . $body;

$Tagdisplay = (!empty($isDisplayed)) ? 'style="display:block;"' : null;
?>

<div class="dropdown-wrap">
    <div class="dropdown-inner">
        <div id="<?= $head ?>" class="dropdown-head dropdown-arrow-close" onclick="animateDropdown('<?= $headx ?>', '<?= $bodyx ?>');">
            <span class="dropdown-title"><?= $title ?></span>
        </div>
        <div id="<?= $body ?>" class="dropdown-checkbox-list" <?= $Tagdisplay ?>>
            <?php 
            $datas = [
                "inputMap" => $inputMap,
                "func" => $func,
                "isRadio" => $isRadio
            ];
            echo $this->generateFile('view/elements/dropdown/dropdownInput2.php', $datas); 
            ?>
        </div>
    </div>
</div>