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
$datas["submitButtonId"] = "manager_add_box";
$datas["submitButtonTxt"] = $translator->translateStation("US34");
$datas["submitIsDesabled"] = true;
$datas["submitClass"] = "green-arrow-desabled";
// $datas["submitButtonFunc"] = "";
$boxDatas = [
    "translator" => $translator,
    "elements" => $boxes,
    "country" => $country,
    "currency" => $currency
];
$datas["content"] = $this->generateFile('view/elements/cart.php', $boxDatas);
echo $this->generateFile('view/elements/popup.php', $datas);
