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
$sbtnx = "#" . $datas["submitButtonId"];
$datas["submitButtonFunc"] = "addBoxProduct('" . $sbtnx . "','" . '#box_manager_window' . "')";
$msgStation = "US59";

$contentDatas = [
    "boxes" => $boxes,
    "country" => $country,
    "currency" => $currency,
    "msgStation" => $msgStation,
    "conf" => $conf
];
$datas["content"] = $this->generateFile('view/elements/popupBoxManagerContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);
