<?php


/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Language $language the Visitor's language
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */

$datas = [];
// $datas["windowId"] = "";
$datas["title"] = "add new box";
$datas["closeButtonId"] = "box_pricing_close_button";
$datas["laodingId"] = "box_pricing_loading";
// $datas["submitButtonId"] = "box_pricing_add_box";
// $datas["submitButtonTxt"] = $translator->translateStation("US34");
// $datas["submitIsDesabled"] = true;
// $datas["submitClass"] = "standard-button-desabled";
// $datas["submitButtonFunc"] = "";

$pricingDatas = [
    "language" => $language,
    "country" => $country,
    "currency" => $currency
];
$pricingContent = $this->generateFile('view/elements/popupBoxPricingContent.php', $pricingDatas);

$msgStation = "US61";
$contentDatas = [
    // "instruction" => "choose the box that suits you:",
    "msgStation" => $msgStation,
    "content" => $pricingContent,
];
$datas["content"] = $this->generateFile('view/elements/popupContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);