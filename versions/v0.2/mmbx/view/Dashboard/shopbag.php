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

$this->head = $this->generateFile('view/Dashboard/files/head.php', []);
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
                        echo $this->generateFile('view/elements/cart.php', $boxDatas);
                        ?>
                    </div>
                    <div class="basket_pop_loading loading-img-wrap">
                        <img src="<?= self::DIR_STATIC_FILES ?>loading.gif">
                    </div>
                </div>
                <div class="cart_summary-div-container">
                    <?php
                    $datas = [
                        "conf" => self::CONF_SOMMARY_SHOPBAG,
                        "basket" => $basket,
                        "country" => $country,
                        "showArrow" => true
                    ];
                    echo $this->generateFile('view/Checkout/files/orderSummary.php', $datas);
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>