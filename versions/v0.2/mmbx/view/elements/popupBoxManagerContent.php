<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Box[] $boxes user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param string $msgStation station from Translator of the instruction to display
 * @param string $conf indicate theconfiguration of the box manager
 */

$containerId = "box_manager_window"; // id of the tag that holds datas generated

$dad = ModelFunctionality::generateDateCode(25);
$dadx = "#" . $dad;
$brotherx = ModelFunctionality::generateDateCode(25);
$sbtnx = "#sumbit_box_manager";

switch($conf){
    case Box::CONF_ADD_BXPROD:
        // $datas["submitButtonFunc"] = "addBoxProduct('" . $sbtnx . "', '" . '#box_manager_window' . "')";
        $msgStation = "US59";
    break;
    case Box::CONF_MV_BXPROD:
        // $datas["submitButtonFunc"] = "moveBoxProduct('$sbtnx')";
        $msgStation = "US60";
    break;
}

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
    // "instruction" => "select a box where to put your item:",
    "msgStation" => $msgStation,
    "content" => $cart,
    "btnTxt" => "new box",
    "btnId" => "box_manager_open_princing",
    "btnFunc" => "switchPopUp('#box_manager_window','#box_pricing_window');evt('evt_cd_6');"
    // "btnDataAttr" => 
];
echo $this->generateFile('view/elements/popupContent.php', $contentDatas);