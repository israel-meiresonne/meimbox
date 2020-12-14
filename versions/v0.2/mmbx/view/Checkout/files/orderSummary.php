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
 * @var Translator */
$translator = $translator;
/**
 * @var Basket */
$basket = $basket;
/**
 * @var Country */
$country = $country;
/**
 * @var Currency */
$currency = $basket->getCurrency();
/**
 * @var Address */
$address = (!empty($address)) ? $address : null;

$lockTime = Order::getLockTime() / 60;
$lockTime = number_format($lockTime, 0, "", "");

/** Prices */
$shippingObj = $basket->getShipping();
$shipping = $shippingObj->getFormated();
$reductShip = $basket->getDiscountShipping();
$sumProdsObj = $basket->getSumProducts();
$sumProds = $sumProdsObj->getFormated();
$subtotal = $basket->getSubTotal()->getFormated();
$reductSumProd = $basket->getDiscountSumProducts();
$finalPice = $basket->getTotal()->getFormated();

/** Translation */
$orderSummaryTxt = ucfirst($translator->translateStation("US137"));
$contactUsTxt = $translator->translateStation("US86");

/* Files */
$safeInfos = $this->generateFile('view/elements/safeInfos.php', []);
$supportMail = (new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY)))->get(Map::email, Map::support, Map::email);

/** Delivery */
$minTime = $shippingObj->getMinTime();
$maxTime = $shippingObj->getMaxTime();
$dayConv = 3600 * 24;
$date = View::getDateDisplayable($translator, time() + $minTime * $dayConv, time() + $maxTime * $dayConv);
/** Free shipping */
$freeShipCode = DiscountCode::getCodeForCountry($country, DiscountCode::KEY_FREE_SHIPPING);
$freeShipCodeObj = $basket->getDiscountCode($freeShipCode);
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
                $TAGtoggleShutter =  "onclick=\"toggleShutter(this, '$bodyx','$arraowx')\"";
            } else {
                $Tagbodyid =  null;
                $Tagarraowid =  null;
                $TAGtoggleShutter = null;
            }
            ?>
            <div class="summary-detail-title-div" <?= $TAGtoggleShutter ?> data-evtopen="evt_cd_17" data-evtclose="evt_cd_18">
                <span class="summary-title"><?= $orderSummaryTxt ?></span>
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
        <div <?= $Tagbodyid ?> class="summary-detail-inner">
            <hr class="hr-summary">
            <div class="summary-detail-property-div">
                <ul class="summary-detail-property-lu remove-ul-default-att">
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key"><?= $translator->translateStation("US77") ?>: </span>
                            <span class="data-key_value-value" style="text-transform: inherit;" data-basket="delivery"><?= $date ?></span>
                        </div>
                    </li>
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="summary-detail-property-shipping-div">
                            <?php
                            switch ($conf):
                                case self::CONF_SOMMARY_SHOPBAG ?>
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
                            <?php break;
                                case self::CONF_SOMMARY_CHECKOUT: ?>
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
                        <?php break;
                                default:
                                    break;
                            endswitch; ?>
                        </div>
                    </li>
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key"><?= $translator->translateStation("US118") ?>: </span>
                            <span class="data-key_value-value" data-basket="sum_prods"><?= $sumProds ?></span>
                        </div>
                    </li>
                    <?php
                    $style = ($reductSumProd->getPrice() == 0) ? 'style="display: none;"' : null;
                    $reductSumProdValue = $reductSumProd->getReverse()->getFormated();
                    $dad = ModelFunctionality::generateDateCode(25);
                    ?>
                    <li id="<?= $dad ?>" class="summary-detail-property-li remove-li-default-att" <?= $style ?>>
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key"><?= $translator->translateStation("US116") ?>: </span>
                            <span class="data-key_value-value" data-dadx="#<?= $dad ?>" data-basket="prod_discount"><?= $reductSumProdValue ?></span>
                        </div>
                    </li>
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key"><?= $translator->translateStation("US81") ?>: </span>
                            <span class="data-key_value-value" data-basket="subtotal"><?= $subtotal ?></span>
                        </div>
                    </li>
                    <hr class="hr-summary">
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="summary-detail-property-shipping-div">
                            <div class="data-key_value-opposite-wrap">
                                <span class="data-key_value-key"><?= $translator->translateStation("US79") ?>: </span>
                                <span class="data-key_value-value" data-basket="shipping"><?= $shipping ?></span>
                            </div>
                        </div>
                    </li>
                    <?php
                    $style = ($reductShip->getPrice() == 0) ? 'style="display: none;"' : null;
                    $reductShipValue = $reductShip->getReverse()->getFormated();
                    $dad = ModelFunctionality::generateDateCode(25);
                    ?>
                    <li id="<?= $dad ?>" class="summary-detail-property-li remove-li-default-att" <?= $style ?>>
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key"><?= $translator->translateStation("US115") ?>: </span>
                            <span class="data-key_value-value" data-dadx="#<?= $dad ?>" data-basket="ship_discount"><?= $reductShipValue ?></span>
                        </div>
                    </li>
                    <hr class="hr-summary">
                    <li class="summary-detail-property-li remove-li-default-att">
                        <div class="data-key_value-opposite-wrap">
                            <span class="data-key_value-key"><?= $translator->translateStation("US82") ?>: </span>
                            <span class="data-key_value-value" data-basket="total"><?= $finalPice ?></span>
                        </div>
                    </li>
                    <?php
                    $style = 'style="display: none;"';
                    $minPrice = -1;
                    if ((!empty($freeShipCodeObj)) && ($basket->getSubTotal()->getPrice() < $freeShipCodeObj->getMinAmount())) {
                        $minAmount = $freeShipCodeObj->getMinAmount();
                        $minPrice = (new Price($minAmount, $currency))->getFormated();
                        $style = null;
                    }
                    $dad = ModelFunctionality::generateDateCode(25);
                    ?>
                    <li id="<?= $dad ?>" class="summary-detail-property-li remove-li-default-att" <?= $style ?>>
                        <div class="summary-detail-button-notifs">
                            <div class="summary-detail-button-notif">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>i-logo-100-2.png">
                                    </div>
                                    <p class="img-text-span" style="color: var(--color-red);" data-dadx="#<?= $dad ?>" data-basket="free_shipping"><?= $translator->translateStation("US117", (new Map(["price" => $minPrice]))) ?></p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="summary-detail-button-div">
                <?php
                switch ($conf):
                    case self::CONF_SOMMARY_CHECKOUT:
                        $sbtnid = ModelFunctionality::generateDateCode(25);
                        $sbtnx = "#$sbtnid";
                        $brotCls = ModelFunctionality::generateDateCode(25);
                        $brotx = ".$brotCls";
                        $lid = ModelFunctionality::generateDateCode(25);
                        $lx = "#$lid"; ?>
                        <div class="summary-detail-button-inner">
                            <button id="<?= $sbtnid ?>" class="<?= $brotCls ?> green-button standard-button remove-button-default-att" data-loadingx="<?= $lx ?>" data-brotherx="<?= $brotx ?>" onclick="checkout('card', '<?= $sbtnx ?>')"><?= $translator->translateStation("US102") ?></button>
                            <div id="<?= $lid ?>" class="btn-loading loading-img-wrap">
                                <img src="<?= self::$DIR_STATIC_FILES ?>mini-loading.gif">
                            </div>
                        </div>
                        <div class="summary-detail-button-notifs">
                            <div class="summary-detail-button-notif">
                                <div class="img-text-wrap">
                                    <div class="img-text-img" style="background: var(--color-shadow-08);">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>padlock-outline-96.png">
                                    </div>
                                    <p class="img-text-span"><?= $translator->translateStation("US104", (new Map(["time" => $lockTime]))) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php break;
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
                <?php break;
                endswitch; ?>
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
                                <img src="<?= self::$DIR_STATIC_FILES ?>google-pay-logo.png">
                            </div>
                            <span class="img-text-span">google pay</span>
                        </div>
                    </li>
                    <?php
                    /*
                    <li class="payement-li remove-li-default-att">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>paypal.png">
                            </div>
                            <span class="img-text-span">paypal</span>
                        </div>
                    </li>
                    */
                    ?>
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
                    <?= $safeInfos ?>
                    <!-- <div class="safe_info-wrap">
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
                    </div> -->
                </div>
            </div>

            <div class="summary-detail-collapse-div">
                <div class="summary-detail-collapse-inner">
                    <div class="collapse-wrap">
                        <ul class="remove-ul-default-att">
                            <li class="remove-li-default-att">
                                <div class="collapse-div">
                                    <div class="collapse-title-div" data-evtopen="evt_cd_23" data-evtclose="evt_cd_24">
                                        <div class="collapse-title"><?= $contactUsTxt ?></div>
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
                                                <?php
                                                /*
                                                <li class="contact-li remove-li-default-att">
                                                    <div class="img-text-wrap">
                                                        <div class="img-text-img">
                                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-phone-100.png">
                                                        </div>
                                                        <span class="img-text-span">+472 13 13 24</span>
                                                    </div>
                                                </li>
                                                */
                                                ?>
                                                <li class="contact-li remove-li-default-att">
                                                    <div class="img-text-wrap">
                                                        <div class="img-text-img">
                                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-secured-letter-100.png">
                                                        </div>
                                                        <span class="img-text-span">
                                                            <?= $supportMail ?>
                                                        </span>
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