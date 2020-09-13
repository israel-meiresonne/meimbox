<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Box[]|BasketProduct[] $basket list of element inside
 * user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */

/**
 * @var Basket
 */
$basket = $basket;
$boxDatas = [
    "elements" => $basket->getMerge(),
    "country" => $country,
    "currency" => $currency,
];
echo $cart = $this->generateFile('view/elements/cart.php', $boxDatas);
?>
<div class="basketpop-resume">
    <div class="basketpop-resume-inner">
        <div class="basketpop-resume-labels">
            <div class="data-key_value-opposite-wrap">
                <span class="data-key_value-key"><?= $translator->translateStation("US57") ?>:</span>
                <span class="data-key_value-value" data-basket="total"><?= $basket->getTotal()->getFormated() ?></span>
            </div>
        </div>
        <ul class="basketpop-resume-buttons remove-ul-default-att">
            <li class="remove-li-default-att">
                <a href="">
                    <button class="grey-button standard-button remove-button-default-att">view bag details</button>
                </a>
            </li>
            <li class="remove-li-default-att">
                <a href="">
                    <button class="green-button standard-button remove-button-default-att">checkout</button>
                </a>
            </li>
        </ul>
    </div>
</div>