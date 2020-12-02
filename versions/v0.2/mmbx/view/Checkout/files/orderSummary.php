<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $conf sommary's configuration
 * + View::CONF_SOMMARY_CHECKOUT,...
 * @param Basket $basket Visitor's basket
 * @param Country $country Visitor's current Country
 * @param boolean $showArrow set true to show the arrow and animate sommary else false
 * @param Address $address|null User's shipping addresses  (only for conf = CONF_SOMMARY_CHECKOUT)
 */

/**
 * @var Basket */
$basket = $basket;
/**
 * @var Country */
$country = $country;
/**
 * @var Address */
$address = (!empty($address)) ? $address : null;
?>

<div class="summary-wrap">
    <div class="summary-detail-block">
        <div class="summary-detail-title-block">
            <?php
            if ($showArrow) {
                $bodyid = ModelFunctionality::generateDateCode(25);
                $bodyx = "#$bodyid";
                $Tagbodyid = "id='$bodyid'";
                $arraowid = ModelFunctionality::generateDateCode(25);
                $arraowx = "#$arraowid";
                $Tagarraowid = "id='$arraowid'";
                $TAGtoggleShutter =  "onclick=\"toggleShutter('$bodyx','$arraowx')\"";
            } else {
                $Tagbodyid =  null;
                $Tagarraowid =  null;
                $TAGtoggleShutter = null;
            }
            ?>
            <div class="summary-detail-title-div" <?= $TAGtoggleShutter ?>>
                <span class="summary-title">Order Summary</span>
            </div>
            <?php
            if ($showArrow) :
            ?>
                <div class="summary-detail-arrow-button-div">
                    <div class="arrow-element-container">
                        <div <?= $Tagarraowid ?> class="arrow-element-wrap">
                            <span class="arrow-span"></span>
                        </div>
                    </div>
                </div>
            <?php
            endif;
            ?>
        </div>
        <div <?= $Tagbodyid ?> data-evtopen="evt_cd_17" data-evtclose="evt_cd_18" class="summary-detail-inner">
            <hr class="hr-summary">
            <div class="summary-detail-property-div">
                <ul class="summary-detail-property-lu remove-ul-default-att">
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="summary-detail-property-shipping-div">
                            <?php
                            switch ($conf):
                                case self::CONF_SOMMARY_SHOPBAG
                            ?>
                                <div class="summary-detail-property-country">
                                    <?php
                                    $frmId = ModelFunctionality::generateDateCode(25);
                                    $frmIdx = "#$frmId";

                                    $countriesMap = Country::getCountriesPriced();
                                    $isoCountries = $countriesMap->getKeys();
                                    $inputMap = new Map();
                                    foreach ($isoCountries as $isoCountry) {
                                        $label = $countriesMap->get($isoCountry, Map::countryName);
                                        if ($label != $country->getCountryNameDefault()) {
                                            $isChecked = ($country->getIsoCountry() == $isoCountry);
                                            $inputMap->put(Country::INPUT_ISO_COUNTRY_VISITOR, $label, Map::inputName);
                                            $inputMap->put($isoCountry, $label, Map::inputValue);
                                            $inputMap->put($isChecked, $label, Map::isChecked);
                                            $inputJson = htmlentities(json_encode([Country::KEY_ISO_CODE => $isoCountry]));
                                            $inputAttr = "onclick=\"evt('evt_cd_21', '$inputJson');updateCountry('$frmIdx', getBasketPop);\"";
                                            $inputMap->put($inputAttr, $label, Map::attribut);
                                        }
                                    }
                                    $title = $translator->translateStation("US65");
                                    $isRadio = true;
                                    $isDisplayed = false;
                                    $eventMap = new Map();
                                    $eventMap->put("evt_cd_19", Map::open);
                                    $eventMap->put("evt_cd_20", Map::close);
                                    $countryDpd = new DropDown($title, $inputMap, $isRadio, $isDisplayed, $eventMap);
                                    ?>
                                    <div id="<?= $frmId ?>" class="dropdown-container">
                                        <?= $countryDpd ?>
                                    </div>
                                </div>
                            <?php
                                    break;
                                case self::CONF_SOMMARY_CHECKOUT:
                            ?>
                                <div id="order_summary_address" class="summary-detail-address">
                                    <?php
                                    $title = "your shipping address:";
                                    $datas = [
                                        "containerId" => "order_summary_address",
                                        "elementId" => ModelFunctionality::generateDateCode(25),
                                        "title" => $title,
                                        "address" => $address,
                                        "showButon" => false,
                                        "dadx" => null,
                                        "brotherx" => null,
                                        "submitdata" => null
                                    ];
                                    echo $this->generateFile('view/elements/cart/address/cartElementAddress.php', $datas);
                                    ?>
                                </div>
                        <?php
                                    break;
                                default:
                                    break;
                            endswitch;
                        ?>
                        <div class="summary-detail-property-shipping-div">
                            <div class="data-key_value-opposite-wrap">
                                <span class="data-key_value-key">shipping: </span>
                                <span class="data-key_value-value" data-basket="shipping"><?= $basket->getShipping()->getFormated() ?></span>
                            </div>
                        </div>
                        </div>
                    </li>
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key">
                                <span style="text-transform: uppercase;">VAT</span>
                                <span style="text-transform: lowercase">(<?= $country->getVatDisplayable() ?>): </span>
                            </span>
                            <span class="data-key_value-value" data-basket="vat"><?= $basket->getVatAmount()->getFormated(); ?></span>
                        </div>
                    </li>
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key">subtotal: </span>
                            <span class="data-key_value-value" data-basket="subtotal"><?= $basket->getSubTotal()->getFormated(); ?></span>
                        </div>
                    </li>
                    <hr class="hr-summary">
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key">total: </span>
                            <span class="data-key_value-value" data-basket="total"><?= $basket->getTotal()->getFormated(); ?></span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="summary-detail-button-div">
                <?php
                switch ($conf) {
                    case self::CONF_SOMMARY_CHECKOUT:
                        $sbtnid = ModelFunctionality::generateDateCode(25);
                        $sbtnx = "#$sbtnid";
                        $brotCls = ModelFunctionality::generateDateCode(25);
                        $brotx = ".$brotCls";
                        $lid = ModelFunctionality::generateDateCode(25);
                        $lx = "#$lid";
                ?>
                        <div class="summary-detail-button-inner">
                            <button id="<?= $sbtnid ?>" class="<?= $brotCls ?> green-button standard-button remove-button-default-att" data-loadingx="<?= $lx ?>" data-brotherx="<?= $brotx ?>" onclick="checkout('card', '<?= $sbtnx ?>')">checkout</button>
                            <div id="<?= $lid ?>" class="btn-loading loading-img-wrap">
                                <img src="<?= self::$DIR_STATIC_FILES ?>mini-loading.gif">
                            </div>
                        </div>
                    <?php
                        break;
                    case self::CONF_SOMMARY_SHOPBAG:
                    ?>
                        <div class="summary-detail-button-inner">
                            <a href="<?= ControllerCheckout::extractController(ControllerCheckout::class) ?>">
                                <button class="green-button standard-button remove-button-default-att"><?= $translator->translateStation("US102") ?></button>
                            </a>
                            <div class="btn-loading loading-img-wrap">
                                <img src="<?= self::$DIR_STATIC_FILES ?>mini-loading.gif">
                            </div>
                        </div>
                <?php
                        break;
                }
                ?>
            </div>
            <div class="summary-payement">
                <ul class="payement-ul remove-ul-default-att">
                    <li class="payement-li remove-li-default-att">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>visa-logo.png">
                            </div>
                            <span class="img-text-span">visa</span>
                        </div>
                    </li>
                    <li class="payement-li remove-li-default-att">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>apple-pay-logo.png">
                            </div>
                            <span class="img-text-span">pay</span>
                        </div>
                    </li>
                    <li class="payement-li remove-li-default-att">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>paypal.png">
                            </div>
                            <span class="img-text-span">paypal</span>
                        </div>
                    </li>
                    <li class="payement-li remove-li-default-att">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>master-card.png">
                            </div>
                            <span class="img-text-span">masterCard</span>
                        </div>
                    </li>
                    <li class="payement-li remove-li-default-att">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>maestro.png">
                            </div>
                            <span class="img-text-span">maestro</span>
                        </div>
                    </li>
                    <li class="payement-li remove-li-default-att">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>amex.png">
                            </div>
                            <span class="img-text-span">american express</span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="summary-detail-safe_info-div">
                <div class="summary-detail-safe_info-inner">
                    <div class="safe_info-wrap">
                        <ul class="safe_info-ul remove-ul-default-att">
                            <li class="safe_info-li remove-li-default-att">
                                <div class="img_text_down-wrap">
                                    <div class="img_text_down-img-div">
                                        <div class="img_text_down-img-inner">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-card-security-150.png">
                                        </div>
                                    </div>
                                    <div class="img_text_down-text-div">
                                        <span>3D secure & <br>SSL encrypted payement</span>
                                    </div>
                                </div>
                            </li>
                            <li class="safe_info-li remove-li-default-att">
                                <div class="img_text_down-wrap">
                                    <div class="img_text_down-img-div">
                                        <div class="img_text_down-img-inner">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-van-96.png">
                                        </div>
                                    </div>
                                    <div class="img_text_down-text-div">
                                        <span>Track your<br> orders online</span>
                                    </div>
                                </div>
                            </li>
                            <li class="safe_info-li remove-li-default-att">
                                <div class="img_text_down-wrap">
                                    <div class="img_text_down-img-div">
                                        <div class="img_text_down-img-inner">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>return-box.png">
                                        </div>
                                    </div>
                                    <div class="img_text_down-text-div">
                                        <span>free & <br>easy return</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="summary-detail-collapse-div">
                <div class="summary-detail-collapse-inner">
                    <div class="collapse-wrap">
                        <ul class="remove-ul-default-att">
                            <li class="remove-li-default-att">
                                <div class="collapse-div">
                                    <div class="collapse-title-div" data-evtopen="evt_cd_23" data-evtclose="evt_cd_24">
                                        <div class="collapse-title">contact us</div>
                                        <div class="collapse-symbol">
                                            <div class="plus_symbol-container">
                                                <div class="plus_symbol-wrap">
                                                    <span class="plus_symbol-vertical"></span>
                                                    <span class="plus_symbol-horizontal"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse-text-div collapse-text-hidded">
                                        <div class="collapse-text-inner">
                                            <ul class="contact-ul remove-ul-default-att">
                                                <li class="contact-li remove-li-default-att">
                                                    <div class="img-text-wrap">
                                                        <div class="img-text-img">
                                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-phone-100.png">
                                                        </div>
                                                        <span class="img-text-span">+472 13 13 24</span>
                                                    </div>
                                                </li>
                                                <li class="contact-li remove-li-default-att">
                                                    <div class="img-text-wrap">
                                                        <div class="img-text-img">
                                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-secured-letter-100.png">
                                                        </div>
                                                        <span class="img-text-span">email@monsite.com</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>