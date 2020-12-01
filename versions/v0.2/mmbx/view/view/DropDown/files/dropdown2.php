<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $title name of the dropdown element
 * @param Map       $inputMap   map with all necessary datas to build a input
 *                              + $inputMap[label][Map::inputName]    => string,
 *                              + $inputMap[label][Map::inputValue]   => string,
 *                              + $inputMap[label][Map::isChecked]    => boolean,     // set true to check input else false
 *                              + $inputMap[label][Map::attribut]     => string|null  // attribut to add on input tag
 *                              + 🚨only one input of $inputMap can has Map::isChecked = true
 * @param boolean   $isRadio    indicate if the inputs are radio or just checkbox
 *                              + NOTE: set true if it radio else false
 * @param boolean   $isDisplayed set true to display content else set false
 * @param Map|null  $eventMap   set true to display content else set false
 */
if(!empty($eventMap)){
    $evenCodeOpen = $eventMap->get(Map::open);
    $evenCodeClise = $eventMap->get(Map::close);
} else {
    $evenCodeOpen = null;
    $evenCodeClise = null;
}

$head = ModelFunctionality::generateDateCode(25);
$headx = "#" . $head;
$body = ModelFunctionality::generateDateCode(25);
$bodyx = "#" . $body;

$Tagdisplay = (!empty($isDisplayed)) ? 'style="display:block;"' : null;
?>

<div class="dropdown-wrap">
    <div class="dropdown-inner">
        <div id="<?= $head ?>" data-evtopen="<?= $evenCodeOpen ?>" data-evtclose="<?= $evenCodeClise ?>" class="dropdown-head dropdown-arrow-close" onclick="animateDropdown('<?= $headx ?>', '<?= $bodyx ?>');">
            <span class="dropdown-title"><?= $title ?></span>
        </div>
        <div id="<?= $body ?>" class="dropdown-checkbox-list" <?= $Tagdisplay ?>>
            <?php 
            $datas = [
                "inputMap" => $inputMap,
                "isRadio" => $isRadio
            ];
            echo $this->generateFile('view/view/DropDown/files/dropdownInput2.php', $datas); 
            ?>
        </div>
    </div>
</div>