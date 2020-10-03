<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Country $country User's current Country
 */
$popDatas["title"] = "shipping address";
$popDatas["closeButtonId"] = "addaddress_form_close_pop";
$popDatas["laodingId"] = null;
$popDatas["laodingClass"] = "sign_form-loading";
$popDatas["submitButtonId"] = null;
$popDatas["submitButtonTxt"] = null;
$popDatas["submitIsDesabled"] = null;
$popDatas["submitClass"] = null;
$popDatas["submitButtonFunc"] = null;

$popDatas["content"] = '<div class="pop_form_border">';
$datas = [
    "country" => $country,
    "conf" => Address::CONF_ADRS_POP,
];
$popDatas["content"] .= $this->generateFile('view/elements/forms/formAddAddress.php', $datas);
$popDatas["content"] .= '</div>';
echo $this->generateFile('view/elements/popup.php', $popDatas);
