<?php
$this->title = "shipping address";
$this->description = "select shipping address";

/**
 * @var Translator
 */
$translator = $translator;

/**
 * @var User|Client|Administrator
 */
$person = $this->person;
$language = $person->getLanguage();
$country = $person->getCountry();
$currency = $person->getCurrency();
$measures = $person->getMeasures();
$basket = $person->getBasket();
$addressMap = $person->getAddresses();
$this->head = $this->generateFile('view/Checkout/files/head.php', []);
?>

<div class="checkout_page-container">
    <div class="checkout_page-inner">
        <div class="directory-container">
            <div class="directory-wrap">
                <p>checkout</p>
            </div>
        </div>
        <div class="address_summary_cart-container">
            <div class="address_summary_cart-inner">
                <div class="address_connection-block">
                    <div class="address_connection-inner">
                        <div class="address-set-container">
                            <?php
                            $displaySet = ($person->hasCookie(Cookie::COOKIE_CLT) && (!empty($addressMap->getKeys())));
                            $Tagstyle = (!$displaySet) ? 'style="display: none;' : null;
                            ?>
                            <div class="address-set-recipient" <?= $Tagstyle ?>>
                                <?php
                                if ($displaySet) :
                                    echo $this->generateFile('view/Dashboard/files/addressSet.php', ["addressMap" => $addressMap]);
                                endif;
                                ?>
                            </div>
                            <div id="address_set_recipient_loading" class="loading-img-wrap">
                                <img src="<?= self::DIR_STATIC_FILES ?>loading.gif">
                            </div>
                        </div>
                        <div class="address-form-container">
                            <?php
                            if ($person->hasCookie(Cookie::COOKIE_CLT) && empty($addressMap->getKeys())) :
                                $datas = [
                                    "country" => $country,
                                    "conf" => Address::CONF_ADRS_FEED,
                                ];
                                echo $this->generateFile('view/elements/forms/formAddAddress.php', $datas);
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="summary_cart-block">
                    <div class="summary_cart-inner">
                        <div class="cart-block">
                            <div class="cart-inner">
                                <div class="form-title-block cart-title-block">
                                    <div class="form-title-div">
                                        <span class="form-title">cart</span>
                                    </div>
                                    <div class="summary-detail-arrow-button-div">
                                        <div class="arrow-element-container">
                                            <div class="arrow-element-wrap">
                                                <span class="arrow-span"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="checkout_cart">
                                    <hr class="hr-summary">
                                    <?php
                                    $boxDatas = [
                                        "containerId" => "checkout_cart",
                                        "elements" => $basket->getMerge(),
                                        "country" => $country,
                                        "currency" => $currency,
                                    ];
                                    echo $cart = $this->generateFile('view/elements/cart.php', $boxDatas);
                                    ?>
                                </div>
                            </div>
                            <hr class="hr-summary">
                            <div class="cart-discount-block">
                                <div class="form-title-block discount-title-block">
                                    <div class="form-title-div">
                                        <span class="form-title">discount codes</span>
                                    </div>
                                    <div class="summary-detail-arrow-button-div">
                                        <div class="arrow-element-container">
                                            <div class="arrow-element-wrap">
                                                <span class="arrow-span"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="discount_body" class="cart-discount-inner">
                                    <hr class="hr-summary">
                                    <div class="cart-discount-input-block">
                                        <div class="input_button_left-wrap">
                                            <div class="input_button_left-intput-block">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="cart_discount">discount code</label>
                                                    <input id="cart_discount" class="input-tag" type="text" name="discount" placeholder="discount code" value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                            <div class="input_button_left-button-block">
                                                <button class="green-button standard-button remove-button-default-att">apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr-summary">
                                    <div class="sticker-set">
                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="summary-block">
                            <?php
                            $datas = [
                                "basket" => $basket,
                                "country" => $country,
                            ];
                            echo $this->generateFile('view/Checkout/files/orderSummary.php', $datas);
                            ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>