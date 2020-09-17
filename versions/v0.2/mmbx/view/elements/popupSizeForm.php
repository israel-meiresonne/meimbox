<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param BoxProduct|BasketProduct $product Visitor's basket
 * @param int $nbMeasure the number of measure holds by Visitor
 */
$datas = [];
$datas["title"] = "shopping bag";
$datas["closeButtonId"] = "size_form_pop_close_button";
$datas["laodingId"] = "size_form_pop_loading";
$datas["submitButtonId"] = "submitButtonId";
$datas["submitButtonTxt"] = "change size";
$datas["submitIsDesabled"] = true;
$datas["submitButtonFunc"] = "";

$contentDatas = [
    "product" => $product,
    "nbMeasure" => $nbMeasure,
];
$datas["content"] = $this->generateFile('view/elements/sizeFormContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);