<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Box[] $boxes user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param string $conf indicate theconfiguration of the box manager
 * + addBoxproduct
 * + moveBoxProduct
 */
$datas = [];
// $datas["windowId"] = "";
$datas["title"] = "box manager";
$datas["closeButtonId"] = "box_manager_close_button";
$datas["laodingId"] = "box_manager_loading";
$datas["submitButtonId"] = "sumbit_box_manager";
$datas["submitButtonTxt"] = $translator->translateStation("US34");
$datas["submitIsDesabled"] = true;
$datas["submitClass"] = "standard-button-desabled";

// $dad = ModelFunctionality::generateDateCode(25);
// $dadx = "#" . $dad;
// $brotherx = ModelFunctionality::generateDateCode(25);
$sbtnx = "#" . $datas["submitButtonId"];

// switch($conf){
//     case Box::CONF_ADD_BXPROD:
        $datas["submitButtonFunc"] = "addBoxProduct('" . $sbtnx . "','" . '#box_manager_window' . "')";
        $msgStation = "US59";
//     break;
//     case Box::CONF_MV_BXPROD:
//         $datas["submitButtonFunc"] = "moveBoxProduct('$sbtnx')";
//         $msgStation = "US60";
//     break;
// }

// $boxDatas = [
//     "elements" => $boxes,
//     "country" => $country,
//     "currency" => $currency,
//     "dad" => $dad,
//     "dadx" => $dadx,
//     "brotherx" => $brotherx,
//     "sbtnx" => $sbtnx
// ];
// $cart = $this->generateFile('view/elements/cart.php', $boxDatas);

// $contentDatas = [
//     "instruction" => "select a box where to put your item:",
//     "content" => $cart,
//     "btnTxt" => "ajouter une box",
//     "btnId" => "box_manager_open_princing",
//     "btnFunc" => "switchPopUp('#box_manager_window','#box_pricing_window')"
//     // "btnDataAttr" => 
// ];
// $datas["content"] = $this->generateFile('view/elements/popupContent.php', $contentDatas);
$contentDatas = [
    "boxes" => $boxes,
    "country" => $country,
    "currency" => $currency,
    "msgStation" => $msgStation,
    "conf" => $conf
    // "dad" => $dad,
    // "dadx" => $dadx,
    // "brotherx" => $brotherx,
    // "sbtnx" => $sbtnx
];
$datas["content"] = $this->generateFile('view/elements/popupBoxManagerContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);
