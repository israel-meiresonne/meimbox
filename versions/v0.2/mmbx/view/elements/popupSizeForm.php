<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $formId id of the forrmular
 * @param Box|null $box box that contain the boxproduct
 * @param BoxProduct|BasketProduct $product Visitor's basket
 * @param int $nbMeasure the number of measure holds by Visitor
 */
$formId = "form_edit_prod_size";
$datas = [];
$datas["title"] = "size editor";
$datas["closeButtonId"] = "size_form_pop_close_button";
$datas["laodingId"] = "size_form_pop_loading";
$datas["submitButtonId"] = "update_size_btn";
$datas["submitButtonTxt"] = "change size";
$datas["submitIsDesabled"] = false;
$datas["submitButtonFunc"] = "console.log('update size')";

$contentDatas = [
    "formId" => $formId,
    "box" => $box,
    "product" => $product,
    "nbMeasure" => $nbMeasure,
    "conf" => Size::CONF_SIZE_EDITOR
];
$datas["content"] = $this->generateFile('view/elements/sizeFormContent.php', $contentDatas);
echo $this->generateFile('view/elements/popup.php', $datas);