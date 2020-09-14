<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Box[] $boxes user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */

$containerId = "box_manager_window"; // id of the tag that holds datas generated

$dad = ModelFunctionality::generateDateCode(25);
$dadx = "#" . $dad;
$brotherx = ModelFunctionality::generateDateCode(25);
$sbtnx = "#box_manager_select_box";
// $datas["submitButtonFunc"] = "addBoxProduct('" . $sbtnx . "', '" . '#box_manager_window' . "')";

$boxDatas = [
    "containerId" => $containerId,
    "elements" => $boxes,
    "country" => $country,
    "currency" => $currency,
    "dad" => $dad,
    "dadx" => $dadx,
    "brotherx" => $brotherx,
    "sbtnx" => $sbtnx
];
$cart = $this->generateFile('view/elements/cart.php', $boxDatas);

$contentDatas = [
    "instruction" => "select a box where to put your item:",
    "content" => $cart,
    "btnTxt" => "new box",
    "btnId" => "box_manager_open_princing",
    "btnFunc" => "switchPopUp('#box_manager_window','#box_pricing_window')"
    // "btnDataAttr" => 
];
echo $this->generateFile('view/elements/popupContent.php', $contentDatas);