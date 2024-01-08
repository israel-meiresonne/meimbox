<?php

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

/*————————————————————————————— Config View DOWN ————————————————————————————*/
$pageTitleTxt = $translator->translateStation("US121");
$this->title = $pageTitleTxt;
$this->description = $pageTitleTxt;
$this->head = $this->generateFile('view/Checkout/files/head.php', []);
/*————————————————————————————— Config View UP ——————————————————————————————*/
?>

<div class="checkout_page-container">
    <div class="checkout_page-inner">
        <div class="directory-container">
            <div class="directory-wrap">
                <!-- <p>checkout</p> -->
            </div>
        </div>
        <div class="address_summary_cart-container">
            <div class="address_summary_cart-inner">
                <div class="address_connection-block">
                    <?php
                    if (!$person->hasCookie(Cookie::COOKIE_CLT)) :
                    ?>
                        <div class="sign-container">
                            <div class="sign-container-inner">
                                <?php
                                echo $this->generateFile('view/elements/forms/fromSign.php', ["redirLink" => ControllerCheckout::extractController(ControllerCheckout::class)]);
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>

        </div>

    </div>
</div>