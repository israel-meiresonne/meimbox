<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Translator $translator to translate
 * @param Box[] $boxes user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */
$datas = [];
// $datas["windowId"] = "";
$datas["title"] = "box manager";
$datas["closeButtonId"] = "box_manager_close_button";
$datas["laodingId"] = "box_manager_loading";
$datas["submitButtonId"] = "box_manager_select_box";
$datas["submitButtonTxt"] = $translator->translateStation("US34");
$datas["submitIsDesabled"] = true;
$datas["submitClass"] = "standard-button-desabled";

$dad = ModelFunctionality::generateDateCode(25);
$dadx = "#" . $dad;
$brotherx = ModelFunctionality::generateDateCode(25);
$sbtnx = "#" . $datas["submitButtonId"];
$datas["submitButtonFunc"] = "addBoxProduct('" . $sbtnx . "', '" . '#box_manager_window' . "')";
$boxDatas = [
    "translator" => $translator,
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
    "btnTxt" => "ajouter une box",
    "btnId" => "box_manager_open_princing",
    "btnFunc" => "switchPopUp('#box_manager_window','#box_pricing_window')"
    // "btnDataAttr" => 
];
$datas["content"] = $this->generateFile('view/elements/popupContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);
