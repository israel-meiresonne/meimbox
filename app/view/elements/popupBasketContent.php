<?php
require_once 'controller/ControllerDashboard.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Basket $basket Visitor's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */

$containerId = "basket_pop"; // id of the tag that holds datas generated
/**
 * @var Translator */
$translator = $translator;
/**
 * @var Basket
 */
$basket = $basket;
$boxDatas = [
    "containerId" => $containerId,
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
                <a href="<?= ControllerDashboard::QR_SHOPBAG ?>">
                    <button class="blue-button standard-button remove-button-default-att"><?= $translator->translateStation("US25") ?></button>
                </a>
            </li>
            <li class="remove-li-default-att">
                <a href="<?= ControllerCheckout::extractController(ControllerCheckout::class) ?>">
                    <button class="green-button standard-button remove-button-default-att"><?= $translator->translateStation("US102") ?></button>
                </a>
            </li>
        </ul>
    </div>
</div>