<?php

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $https_webroot https://mydomain.com + webroot
 * @param string $dir_email_files https://mydomain.com + webroot + {dir to email files}
 * @param Map $company info about the company sending this email
 * @param string $firstname the firstname of the recipient of this email
 * @param string $lastname the lastname of the recipient of this email
 * @param Order $order the oder of the recipient of this email
 */

$prod_https_dir = $https_webroot . $dir_prod_files;

/**
 * @var Translator */
$translator = $translator;

/**
 * @var Order */
$order = $order;
$basketOrdered = $order->getBasketOrdered();    //🔋
/**
 * @var BasketOrdered*/
// $basketOrdered = $order;         //🚨to delete cause delivery addres is  already in order

/**
 * @var AddressDelivery */
$address = $order->getDelivery();   //🔋
// $address = $address;             //🚨to delete cause delivery addres is  already in order
$appartement = (!empty($address->getAppartement())) ? " (" . $address->getAppartement() . ")" : null;
$province = ", " . $address->getProvince();
$zipcode = ", " . $address->getZipcode();
$city = " " . $address->getCity();
$adrsCountry = ", " . $address->getCountry()->getCountryName();
$fullAddress = $address->getAddress() . $appartement . strtoupper($zipcode) . $city . $province . $adrsCountry;

/**
 * @var Map*/
$company = $company;
$brand = $company->get(Map::brand);

$zipcode = $company->get(Map::address, Map::zipcode);
$city = " " . $company->get(Map::address, Map::city);
$state = ", " . $company->get(Map::address, Map::state);
$CompanyCountry = " " . $company->get(Map::address, Map::country);
$companyAddress = $zipcode . $city . $state . $CompanyCountry;

$medias = $company->get(Map::media);
?>
<html>

<head>
</head>

<body>
    <style>
        <?php
        $tags = [
            self::FONT_FAM_SPARTAN
        ];
        foreach ($tags as $tag) {
            $link = $this->extractLink($tag);
            echo file_get_contents($link);
        }
        ?>
    </style>
    <table class="main_content">
        <tr class="main_content-head main_content-child">
            <td>
                <table class="head_content">
                    <tr>
                        <td class="head_content-brand">
                            <h1><a href="<?= $https_webroot ?>" class="remove-a-default-att" target="_blank"><?=strtoupper($brand) ?></a></h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="">
                            <table class="head_content-picture">
                                <tr>
                                    <td class="nada_20"></td>
                                    <td class="head_content-picture-td">
                                        <img src="<?= $dir_email_files ?>Mama_Bakery.png" alt="order in preparation">
                                    </td>
                                    <td class="nada_20"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="head_content-paragraph">
                                <tr>
                                    <td>
                                        <h1>
                                            <span class="sentence"><?= $translator->translateStation("US70") ?> <?= $firstname ?>,</span>
                                            <br>
                                            <span><?= ucfirst($translator->translateStation("US71")) ?></span>
                                        </h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3 class="inter_line_low no_margin unbold_field">
                                            <span><?= ucfirst($translator->translateStation("US72")) ?></span>.
                                            <span><?= ucfirst($translator->translateStation("US73")) ?>. </span>
                                            <br>
                                            <span><?= ucfirst($translator->translateStation("US74")) ?>. </span>
                                            <br>
                                            <span><?= ucfirst($translator->translateStation("US75")) ?> <a href="" target="_blank"><?= $translator->translateStation("US76") ?></a>.</span>
                                        </h3>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="table_separator-td-space"></div>
                <div class="table_separator-td-space"></div>
                <div class="table_separator-td-space"></div>
            </td>
        </tr>
        <tr>
            <td>
                <table class="main_content_secondary">
                    <tr class="main_content-body main_content-child">
                        <td>
                            <table class="body_content">
                                <tr>
                                    <td>
                                        <table class="body_content-info body_content-child">
                                            <tr>
                                                <td class="body_content-info-address body_content-info-td">
                                                    <h2 class="sentence"><?= $firstname . " " . $lastname ?></h2>
                                                    <p class="secondary_field_dark sentence">
                                                        <?= $fullAddress ?>
                                                    </p>
                                                </td>
                                                <td class="body_content-info-td">
                                                    <table class="body_content-info-delivery">
                                                        <tr>
                                                            <td>
                                                                <h2 class="delivery_label unbold_field">
                                                                    <span class="sentence"><?= $translator->translateStation("US77") ?>:</span>
                                                                </h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h4 class="delivery_date unbold_field secondary_field_dark no_margin">
                                                                    20-22 september
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="body_content-body body_content-child">
                                            <tr>
                                                <td class="body_content-body-number body_content-body-td">
                                                    <table class="table_default">
                                                        <tr>
                                                            <td>
                                                                <p class="secondary_field_dark"><?= ucfirst($translator->translateStation("US78")) ?>:</p>
                                                            </td>
                                                            <td>
                                                                <span><?= $basketOrdered->getQuantity() ?></span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <?php
                                            $boxes = $basketOrdered->getBoxes();
                                            foreach ($boxes as $box) :
                                                $boxDatas = [
                                                    "https_webroot" => $https_webroot,
                                                    "box" => $box,
                                                ];
                                                echo $this->generateFile('view/EmailTemplates/orderConfirmation/files/boxElement.php', $boxDatas);
                                                $boxProducts = $box->getProducts();
                                                foreach ($boxProducts as $boxProduct) {
                                                    $boxProdDatas = [
                                                        "https_webroot" => $https_webroot,
                                                        "product" => $boxProduct,
                                                    ];
                                                    echo $this->generateFile('view/EmailTemplates/orderConfirmation/files/productElement.php', $boxProdDatas);
                                                } ?>
                                                <tr>
                                                    <td>
                                                        <div class="table_separator-td-space"></div>
                                                        <div class="table_separator-td-space"></div>
                                                    </td>
                                                </tr>
                                            <?php
                                            endforeach;
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="body_content-summary body_content-child">
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark"><?= $translator->translateStation("US79") ?></td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field"><?= $basketOrdered->getShipping()->getFormated() ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark"><?= strtoupper($translator->translateStation("US80")) ?></td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field"><?= $basketOrdered->getVatAmount()->getFormated() ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark"><?= $translator->translateStation("US81") ?></td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field"><?= $basketOrdered->getSubTotal()->getFormated() ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence"><?= $translator->translateStation("US82") ?></td>
                                                <td class="nada_60"></td>
                                                <td class="price_field"><?= $basketOrdered->getTotal()->getFormated() ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <td>
                                    <table class="body_content-footer">
                                        <tr class="body_content-info-button">
                                            <td class="nada_33"></td>
                                            <td>
                                                <div>
                                                    <a href="" target="_blank">
                                                    <button class="green-button-reverse standard-button"><?= $translator->translateStation("US83") ?></button>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="nada_33"></td>
                                        </tr>
                                    </table>
                                </td>
                            </table>
                        </td>
                    </tr>
                    <tr class="main_content-footer main_content-child">
                        <td>
                            <table class="footer_content">
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="footer_content-thanks">
                                            <tr>
                                                <td>
                                                    <?php
                                                    $replacementsMap = new Map();
                                                    $replacementsMap->put(strtoupper($brand), Map::brand);
                                                    $translation = $translator->translateStation("US85", $replacementsMap);
                                                    ?>
                                                    <span class="sentence"><?= $translator->translateStation("US84") ?>❤️,</span>
                                                    <br>
                                                    <span class="sentence"><?= $translation ?></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="footer_content-contact">
                                            <tr>
                                                <td class="footer_content-contact-td">
                                                    <table class="footer_content-contact-support">
                                                        <tr class="footer_content-contact-support-title">
                                                            <td>
                                                                <h3 class="sentence"><?= $translator->translateStation("US86") ?></h3>
                                                            </td>
                                                        </tr>
                                                        <tr class="support_address mini_text">
                                                            <td>
                                                                <address class="secondary_field_clear sentence">
                                                                    <?= $brand . ", " . $companyAddress ?>
                                                                </address>
                                                            </td>
                                                        </tr>
                                                        <tr class="support_unsuscribe">
                                                            <td>
                                                                <table class="table_default mini_text">
                                                                    <tr>
                                                                        <td>
                                                                            <span class="secondary_field_clear">
                                                                                <span><?= ucfirst($translator->translateStation("US87")) ?>:</span>
                                                                        </td>
                                                                        <td>
                                                                            <a href="" target="_blank"><?= $translator->translateStation("US88") ?></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-barre"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="footer_content-contact-td">
                                                    <table class="footer_content-contact-media">
                                                        <tr class="footer_content-contact-media-title">
                                                            <td>
                                                                <h3 class="sentence"><?= $translator->translateStation("US89") ?></h3>
                                                            </td>
                                                        </tr>
                                                        <tr class="footer_content-contact-media-message mini_text">
                                                            <td>
                                                                <p class="secondary_field_clear inter_line_low">
                                                                    <?= ucfirst($translator->translateStation("US90")) ?>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="table_separator-td-space"></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table class="footer_content-contact-media-logo">
                                                                    <tr>
                                                                        <?php
                                                                        foreach ($medias as $mediaName => $datas) : ?>
                                                                            <td>
                                                                                <a href="<?= $datas[Map::link] ?>" target="_blank">
                                                                                    <img src="<?= $dir_email_files . $datas[Map::logo] ?>" alt="<?= $mediaName ?>">
                                                                                </a>
                                                                            </td>
                                                                        <?php endforeach; ?>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
<script>

</script>

</html>