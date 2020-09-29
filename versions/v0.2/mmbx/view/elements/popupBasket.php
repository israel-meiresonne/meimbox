<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Basket $basket Visitor's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */
$datas = [];
// $datas["windowId"] = "";
$datas["title"] = "shopping bag";
$datas["closeButtonId"] = "basket_pop_close_button";
// $datas["laodingId"] = "basket_pop_loading";
// $datas["laodingClass"] = "basket_pop_loading";

$contentDatas = [
    "basket" => $basket,
    "country" => $country,
    "currency" => $currency,
];
$datas["content"] = $this->generateFile('view/elements/popupBasketContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);
