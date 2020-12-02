<?php
// require_once 'model/orders-management/payement/stripe/StripeAPI.php';
$this->title = "checkout";
$this->description = "checkout";
$pk = Configuration::get(Configuration::STRIPE_PK);

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
$datas = [
    "additionals" => ['<script src="https://js.stripe.com/v3/"></script>']
];
$this->head = $this->generateFile('view/Checkout/files/head.php', $datas);
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
                                <div id="checkout_cart" data-evtopen="evt_cd_29" data-evtclose="evt_cd_30">
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

<script type="text/javascript">
    var stripe = Stripe('<?= $pk ?>');
    const KEY_STRP_MTD = '<?= CheckoutSession::KEY_STRP_MTD ?>';
    const QR_NW_CHCKT_SS = '<?= ControllerCheckout::QR_NW_CHCKT_SS ?>';
    checkout = (mtd, sbtnx) => {
        var brotx = $(sbtnx).attr(databrotherx);
        var lx = $(sbtnx).attr(datalx);
        var map = {
            [KEY_STRP_MTD]: mtd
        }
        var params = mapToParam(map);
        evt('evt_cd_31', json_encode(map));
        var d = {
            "a": QR_NW_CHCKT_SS,
            "d": params,
            "r": checkoutRSP,
            "l": lx,
            // "x": cbtnx,
            "sc": () => {
                displayFlexOn(d.l);
                disable(brotx)
            },
            "rc": () => {
                displayFlexOff(d.l);
                enable(brotx);
            }
        };
        SND(d);
    }
    const checkoutRSP = (r) => {
        if (r.isSuccess) {
            // console.log("success");
            lunchCheckout(r.results[QR_NW_CHCKT_SS]);
        } else {
            // console.log("error");
            handleErr(r);
        }
    }


    const lunchCheckout = (id) => {
        stripe.redirectToCheckout({
            sessionId: id
        }).then(function(result) {
            console.log(result.error.message);
        });
    };
</script>