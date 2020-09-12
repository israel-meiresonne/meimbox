<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Box[]|BasketProduct[] $basket list of element inside 
 * user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */
$datas = [];
// $datas["windowId"] = "";
$datas["title"] = "shopping bag";
$datas["closeButtonId"] = "basket_pop_close_button";
$datas["laodingId"] = "basket_pop_loading";
// $datas["submitButtonId"] = "box_manager_select_box";
// $datas["submitButtonTxt"] = $translator->translateStation("US34");
// $datas["submitIsDesabled"] = true;
// $datas["submitClass"] = "standard-button-desabled";

// $dad = ModelFunctionality::generateDateCode(25);
// $dadx = "#" . $dad;
// $brotherx = ModelFunctionality::generateDateCode(25);
// $sbtnx = "#" . $datas["submitButtonId"];
// $datas["submitButtonFunc"] = "addBoxProduct('" . $sbtnx . "', '" . '#box_manager_window' . "')";

// $boxDatas = [
//     "translator" => $translator,
//     "elements" => $boxes,
//     "country" => $country,
//     "currency" => $currency,
//     "dad" => $dad,
//     "dadx" => $dadx,
//     "brotherx" => $brotherx,
//     "sbtnx" => $sbtnx
// ];
// $cart = $this->generateFile('view/elements/cart.php', $boxDatas);

$contentDatas = [
    "basket" => $basket,
    "country" => $country,
    "currency" => $currency,
];
$datas["content"] = $this->generateFile('view/elements/popupBasketContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);
