<?php
$this->title = "shopping bag";
$this->description = "shopping bag";

/**
 * @var Translator
 */
$translator = $translator;

/**
 * @var Visitor|Client|Administrator
 */
$person = $this->person;
$language = $person->getLanguage();
$country = $person->getCountry();
$currency = $person->getCurrency();
$measures = $person->getMeasures();
$basket = $person->getBasket();

$datas = [];
$this->head = $this->generateFile('view/Dashboard/files/head.php', $datas);
?>


<div class="cart_page-container">
    <div class="cart_page-inner">
        <div class="directory-wrap">
            <p>dashboard \ shopping bag</p>
        </div>
        <div class="cart-cart_summary-block">
            <div class="cart-cart_summary-inner">
                <div class="cart-div-container">
                    <div id="shopping_bag" class="cart-div-inner">
                        <?php
                        $boxDatas = [
                            // "containerId" => $containerId,
                            "containerId" => "shopping_bag",
                            "elements" => $basket->getMerge(),
                            "country" => $country,
                            "currency" => $currency,
                        ];
                        echo $cart = $this->generateFile('view/elements/cart.php', $boxDatas);
                        ?>
                    </div>
                </div>

                <div class="cart_summary-div-container">
                    <div class="summary-wrap">
                        <div class="summary-detail-block">
                            <div class="summary-detail-title-block">
                                <div class="summary-detail-title-div">
                                    <span class="summary-title">Order Summary</span>
                                </div>
                                <div class="summary-detail-arrow-button-div">
                                    <div class="summary-detail-arrow-button-inner">
                                        <button class="summary-detail-arrow-button remove-button-default-att">
                                            <div class="arrow-element-wrap">
                                                <span class="arrow-span"></span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="summary-detail-inner">
                                <hr class="hr-summary">
                                <div class="summary-detail-property-div">
                                    <ul class="summary-detail-property-lu remove-ul-default-att">
                                        <li class="summary-detail-property-li remove-li-default-att">
                                            <div class="data-key_value-opposite-wrap">
                                                <span class="data-key_value-key">total: </span>
                                                <span class="data-key_value-value" data-basket="total"><?= $basket->getTotal()->getFormated(); ?></span>
                                            </div>
                                        </li>
                                        <li class="summary-detail-property-li remove-li-default-att">
                                            <div class="summary-detail-property-shipping-div">

                                                <div class="summary-detail-property-country">
                                                    <div class="dropdown-container">
                                                        <?php
                                                        $countriesMap = Country::getCountries();
                                                        $labels = $countriesMap->getKeys();
                                                        $inputMap = new Map();
                                                        // var_dump($countriesMap);
                                                        foreach ($labels as $label) {
                                                            if ($label != $country->getCountryNameDefault()) {
                                                                $isoCountry = $countriesMap->get($label, Map::isoCountry);
                                                                $isChecked = ($country->getIsoCountry() == $isoCountry);
                                                                $inputMap->put(Country::KEY_ISO_CODE, $label, Map::inputName);
                                                                $inputMap->put($isoCountry, $label, Map::inputValue);
                                                                $inputMap->put($isChecked, $label, Map::isChecked);
                                                                $inputMap->put(null, $label, Map::inputFunc);
                                                            }
                                                        }
                                                        $datas = [
                                                            "title" => $translator->translateStation("US65"),
                                                            "inputMap" => $inputMap,
                                                            "func" => null,
                                                            "isRadio" => true,
                                                            "isDisplayed" => false
                                                        ];
                                                        echo $this->generateFile('view/elements/dropdown/dropdown2.php', $datas);
                                                        ?>
                                                        <!-- <div class="dropdown-wrap">
                                                            <div class="dropdown-inner">
                                                                <div class="dropdown-head dropdown-arrow-close">
                                                                    <span class="dropdown-title">country</span>
                                                                </div>
                                                                <div class="dropdown-checkbox-list">
                                                                    <div class="dropdown-checkbox-block">
                                                                        <label class="checkbox-label">belgium
                                                                            <input type="radio" name="country">
                                                                            <span class="checkbox-checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="dropdown-checkbox-block">
                                                                        <label class="checkbox-label">france
                                                                            <input type="radio" name="country">
                                                                            <span class="checkbox-checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="dropdown-checkbox-block">
                                                                        <label class="checkbox-label">switzerland
                                                                            <input type="radio" name="country">
                                                                            <span class="checkbox-checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>

                                                <div class="summary-detail-property-shipping-div">
                                                    <div class="data-key_value-opposite-wrap">
                                                        <span class="data-key_value-key">shipping: </span>
                                                        <!-- <span class="info-style data-key_value-value">(Select a country)</span> -->
                                                        <span class="data-key_value-value" data-basket="shipping"><?= $basket->getShipping()->getFormated() ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="summary-detail-property-li remove-li-default-att">
                                            <div class="data-key_value-opposite-wrap">
                                                <span class="data-key_value-key">
                                                    <span style="text-transform: uppercase;">VAT</span>
                                                    <!-- <span style="text-transform: lowercase">(included): </span> -->
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
                                    </ul>
                                </div>
                                <div class="summary-detail-button-div">
                                    <div class="summary-detail-button-inner">
                                        <button class="green-button standard-button remove-button-default-att">checkout</button>
                                    </div>
                                </div>

                                <div class="summary-detail-safe_info-div">
                                    <div class="summary-detail-safe_info-inner">
                                        <div class="safe_info-wrap">
                                            <ul class="safe_info-ul remove-ul-default-att">
                                                <li class="safe_info-li remove-li-default-att">
                                                    <div class="img_text_down-wrap">
                                                        <div class="img_text_down-img-div">
                                                            <div class="img_text_down-img-inner">
                                                                <img src="<?= self::DIR_STATIC_FILES ?>icons8-card-security-150.png">
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
                                                                <img src="<?= self::DIR_STATIC_FILES ?>icons8-headset-96.png">
                                                            </div>
                                                        </div>
                                                        <div class="img_text_down-text-div">
                                                            <span>customer service 24h/7 <br> response in 1h</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="safe_info-li remove-li-default-att">
                                                    <div class="img_text_down-wrap">
                                                        <div class="img_text_down-img-div">
                                                            <div class="img_text_down-img-inner">
                                                                <img src="<?= self::DIR_STATIC_FILES ?>return-box.png">
                                                            </div>
                                                        </div>
                                                        <div class="img_text_down-text-div">
                                                            <span>free & <br>easy return</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="safe_info-li remove-li-default-att">
                                                    <div class="img_text_down-wrap">
                                                        <div class="img_text_down-img-div">
                                                            <div class="img_text_down-img-inner">
                                                                <img src="<?= self::DIR_STATIC_FILES ?>icons8-van-96.png">
                                                            </div>
                                                        </div>
                                                        <div class="img_text_down-text-div">
                                                            <span>Track your<br> orders online</span>
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
                                                        <div class="collapse-title-div">
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
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>icons8-phone-100.png">
                                                                            </div>
                                                                            <span class="img-text-span">+472 13 13 24</span>
                                                                        </div>

                                                                    </li>
                                                                    <li class="contact-li remove-li-default-att">

                                                                        <div class="img-text-wrap">
                                                                            <div class="img-text-img">
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>icons8-secured-letter-100.png">
                                                                            </div>
                                                                            <span class="img-text-span">email@monsite.com</span>
                                                                        </div>

                                                                    </li>
                                                                </ul>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="collapse-div">
                                                        <div class="collapse-title-div">
                                                            <div class="collapse-title">payement options</div>
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

                                                                <ul class="payement-ul remove-ul-default-att">
                                                                    <li class="payement-li remove-li-default-att">
                                                                        <div class="img-text-wrap">
                                                                            <div class="img-text-img">
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>visa-logo.png">
                                                                            </div>
                                                                            <span class="img-text-span">visa</span>
                                                                        </div>
                                                                    </li>
                                                                    <li class="payement-li remove-li-default-att">
                                                                        <div class="img-text-wrap">
                                                                            <div class="img-text-img">
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>apple-pay-logo.png">
                                                                            </div>
                                                                            <span class="img-text-span">pay</span>
                                                                        </div>
                                                                    </li>
                                                                    <li class="payement-li remove-li-default-att">
                                                                        <div class="img-text-wrap">
                                                                            <div class="img-text-img">
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>paypal.png">
                                                                            </div>
                                                                            <span class="img-text-span">paypal</span>
                                                                        </div>
                                                                    </li>
                                                                    <li class="payement-li remove-li-default-att">
                                                                        <div class="img-text-wrap">
                                                                            <div class="img-text-img">
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>master-card.png">
                                                                            </div>
                                                                            <span class="img-text-span">masterCard</span>
                                                                        </div>
                                                                    </li>
                                                                    <li class="payement-li remove-li-default-att">
                                                                        <div class="img-text-wrap">
                                                                            <div class="img-text-img">
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>maestro.png">
                                                                            </div>
                                                                            <span class="img-text-span">maestro</span>
                                                                        </div>
                                                                    </li>
                                                                    <li class="payement-li remove-li-default-att">
                                                                        <div class="img-text-wrap">
                                                                            <div class="img-text-img">
                                                                                <img src="<?= self::DIR_STATIC_FILES ?>amex.png">
                                                                            </div>
                                                                            <span class="img-text-span">american express</span>
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
                </div>

            </div>

        </div>
    </div>
</div>