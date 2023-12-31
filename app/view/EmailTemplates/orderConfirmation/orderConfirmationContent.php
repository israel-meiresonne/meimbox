<?php

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Map $company info about the company sending this email
 * @param string $firstname the firstname of the recipient of this email
 * @param string $lastname the lastname of the recipient of this email
 * @param Order $order the oder of the recipient of this email
 */

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
$province = $address->getProvince();
$zipcode = $address->getZipcode();
$city = $address->getCity();
$adrsCountry = $address->getCountry()->getCountryName();

$fullAddress = $address->getAddress() . $appartement . ", " . strtoupper($zipcode) . " " . $city . ", " . $province . ", " . $adrsCountry;

/**
 * @var Map*/
$company = $company;
$brand = $company->get(Map::brand);

$zipcode = $company->get(Map::address, Map::zipcode);
$city = " " . $company->get(Map::address, Map::city);
$state = ", " . $company->get(Map::address, Map::state);
$CompanyCountry = " " . $company->get(Map::address, Map::country);
$companyAddress = $zipcode . $city . $state . $CompanyCountry;
/** Company */
$medias = $company->get(Map::media);

/** Prices */
$sumProd = $basketOrdered->getSumProducts()->getFormated();
$discSumProd = $basketOrdered->getDiscountSumProducts();
$vat = $basketOrdered->getCountry()->getVatDisplayable();
$vatAmount = $basketOrdered->getVat()->getFormated();
$subTotal = $basketOrdered->getSubTotal()->getFormated();
$shippingObj = $basketOrdered->getShipping();
$shipping = $shippingObj->getFormated();
$minTime = $shippingObj->getMinTime();
$maxTime = $shippingObj->getMaxTime();
$discShip = $basketOrdered->getDiscountShipping();
$total = $basketOrdered->getTotal()->getFormated();

$dayConv = 3600 * 24;
$date = View::getDateDisplayable($translator, time() + $minTime * $dayConv, time() + $maxTime * $dayConv);

/** Link */
$trackUrl = self::$URL_DOMAIN_WEBROOT . ControllerSecure::generateActionPath(ControllerDashboard::class, ControllerDashboard::ACTION_ORDERS);
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
                            <h1><a href="<?= self::$URL_DOMAIN_WEBROOT ?>" class="remove-a-default-att" target="_blank"><?= strtoupper($brand) ?></a></h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="">
                            <table class="head_content-picture">
                                <tr>
                                    <td class="nada_20"></td>
                                    <td class="head_content-picture-td">
                                        <img src="<?= self::$PATH_EMAIL ?>Mama_Bakery.png" alt="order in preparation">
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
                                            <span><?= ucfirst($translator->translateStation("US75")) ?> <a href="<?= $trackUrl ?>" target="_blank"><?= $translator->translateStation("US76") ?></a>.</span>
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
                                                        <?= $address->getAddress() . $appartement . "<br>" ?>
                                                        <?= strtoupper($zipcode) . "<br>" ?>
                                                        <?= $city . "<br>" ?>
                                                        <?= $province . "<br>" ?>
                                                        <?= $adrsCountry ?>
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
                                                                    <?= $date ?>
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
                                                    // "https_webroot" => $https_webroot,
                                                    "box" => $box,
                                                ];
                                                echo $this->generateFile('view/EmailTemplates/orderConfirmation/files/boxElement.php', $boxDatas);
                                                $boxProducts = $box->getProducts();
                                                foreach ($boxProducts as $boxProduct) {
                                                    $boxProdDatas = [
                                                        // "https_webroot" => $https_webroot,
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
                                                <td class="sentence secondary_field_dark"><?= $translator->translateStation("US118") ?></td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field"><?= $sumProd ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <?php
                                            if ($discSumProd->getPrice() > 0) :
                                                $copyDiscSumProd = $discSumProd->getReverse()->getFormated();
                                            ?>
                                                <tr class="body_content-summary-price">
                                                    <td class="sentence secondary_field_dark"><?= $translator->translateStation("US116") ?></td>
                                                    <td class="nada_60"></td>
                                                    <td class="secondary_field_dark price_field"><?= $copyDiscSumProd ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="table_separator-td-space"></div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark"><?= $translator->translateStation("US81") ?></td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field"><?= $subTotal ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark"><?= strtoupper($translator->translateStation("US80")) . "($vat)" ?></td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field"><?= $vatAmount ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark"><?= $translator->translateStation("US79") ?></td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field"><?= $shipping ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <?php
                                            if ($discShip->getPrice() > 0) :
                                                $copyDiscShip = $discShip->getReverse()->getFormated(); ?>
                                                <tr class="body_content-summary-price">
                                                    <td class="sentence secondary_field_dark"><?= $translator->translateStation("US115") ?></td>
                                                    <td class="nada_60"></td>
                                                    <td class="secondary_field_dark price_field"><?= $copyDiscShip ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="table_separator-td-space"></div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
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
                                                    <a href="<?= $trackUrl ?>" target="_blank">
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
                                                                            <a href="<?= self::$URL_DOMAIN_WEBROOT ?>" target="_blank"><?= $translator->translateStation("US88") ?></a>
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
                                                                                    <img src="<?= self::$PATH_EMAIL . $datas[Map::logo] ?>" alt="<?= $mediaName ?>">
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