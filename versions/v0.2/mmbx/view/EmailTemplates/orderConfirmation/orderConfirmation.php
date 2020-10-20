<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $https_webroot https://mydomain.com + webroot
 * @param string $dir_email_files https://mydomain.com + webroot + {dir to email files}
 * @param Map $company info about the company sending this email
 * @param string $firstname the firstname of the recipient of this email
 * @param string $lastname the lastname of the recipient of this email
 * @param Order $order the oder of the recipient of this email
 */

$styles = [
    $this->getCSS_ORDER_CONFIRMATION()
];
$templateDatas = [
    "https_webroot" => $https_webroot,
    "dir_email_files" => $dir_email_files,
    "company" => $company,
    "firstname" => $firstname,
    "lastname" => $lastname,
    "order" => $order,
    // "address" => $address   //🚨to delete cause delivery addres is  already in order
];

$html = $this->generateFile('view/EmailTemplates/orderConfirmation/template.php', $templateDatas);

$datas = [
    "styles" => $styles,
    "html" => $html
];
echo $this->generateFile('view/EmailTemplates/htmlToEmail.php', $datas);