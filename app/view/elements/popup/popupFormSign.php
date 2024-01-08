<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 */
$popDatas["title"] = "sign form";
$popDatas["closeButtonId"] = "sign_form_close_button";
$popDatas["laodingId"] = null;
$popDatas["laodingClass"] = "sign_form-loading";
$popDatas["submitButtonId"] = null;
$popDatas["submitButtonTxt"] = null;
$popDatas["submitIsDesabled"] = null;
$popDatas["submitClass"] = null;
$popDatas["submitButtonFunc"] = null;

$popDatas["content"] = '<div class="form_sign_file">';
$popDatas["content"] .= $this->generateFile('view/elements/forms/fromSign.php', []);
$popDatas["content"] .= '</div>';
echo $this->generateFile('view/elements/popup.php', $popDatas);
