<?php
$this->title = "checkout";
$this->description = "checkout";

/**
 * @var Translator
 */
$translator = $translator;

/**
 * @var User|Client|Administrator
 */
$person = $this->person;

/**
 * @var Address
 */
$address = $address;

$language = $person->getLanguage();
$country = $person->getCountry();
$currency = $person->getCurrency();
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
                            <?php
                            // $cart = $this->generateFile('view/elements/forms/formDiscount.php', []);
                            ?>
                        </div>
                        <div class="summary-block">
                            <?php
                            $datas = [
                                "conf" => self::CONF_SOMMARY_CHECKOUT,
                                "basket" => $basket,
                                "country" => $country,
                                "showArrow" => false,
                                "address" => $address
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