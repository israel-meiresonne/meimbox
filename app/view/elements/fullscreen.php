<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @var Visitor|User|Client|Administrator $person the current user
 */
$person = $person;
$brandsMeasures = $person->getBrandMeasures();
$measures = $person->getMeasures();
$measureUnits = $person->getUnits();
$basket = $person->getBasket();
$country = $person->getCountry();
$currency = $person->getCurrency();
$language = $person->getLanguage();
?>

<div id="full_screen_div" class="full_screen-block back_blur">
    <div id="full_screen_loading">
        <img src="<?= self::$DIR_STATIC_FILES ?>mini-loading.gif">
    </div>
    <div id="customize_brand_reference" class="customize-brand_reference-block pop_up-container" data-evtclose="evt_cd_88">
        <?php
        $datas = ["brandsMeasures" => $brandsMeasures];
        echo $this->generateFile("view/elements/popupBrand.php", $datas);
        ?>
    </div>
    <div id="measure_manager" class="customize_measure-block pop_up-container" data-evtclose="evt_cd_104">
        <?php
        $datas = [
            "measures" => $measures,
            "measureUnits" => $measureUnits
        ];
        echo $this->generateFile("view/elements/popupMeasureManager.php", $datas);
        ?>
    </div>
    <div id="measure_adder" class="customize_measure-block pop_up-container" data-evtclose="evt_cd_111">
        <?php
        $datas = [
            "measureUnits" => $measureUnits,
            "language" => $person->getLanguage()
        ];
        echo $this->generateFile("view/elements/popupMeasureAdder.php", $datas);
        ?>
    </div>
    <div id="box_manager_window" class="box_manager-container pop_up-container" data-evtclose="evt_cd_72">
        <?php
        $datas = [
            "boxes" => $basket->getBoxes(),
            "country" => $country,
            "currency" => $currency,
            "conf" => Box::CONF_ADD_BXPROD
        ];
        echo $this->generateFile('view/elements/popupBoxManager.php', $datas);
        ?>
    </div>
    <div id="box_pricing_window" class="pricing-container pop_up-container" data-evtclose="evt_cd_53">
        <?php
        $datas = [
            "language" => $language,
            "country" => $country,
            "currency" => $currency
        ];
        echo $this->generateFile('view/elements/popupBoxPricing.php', $datas);
        ?>
    </div>
    <div id="basket_pop" class="pop_up-container" data-evtclose="evt_cd_70">
        <?php
        $datas = [
            "basket" => $basket,
            "country" => $country,
            "currency" => $currency
        ];
        echo $this->generateFile('view/elements/popupBasket.php', $datas);
        ?>
    </div>
    <div id="size_editor_pop" class="pop_up-container" data-evtclose="evt_cd_112">
    </div>
    <?php
    if (!$person->hasCookie(Cookie::COOKIE_CLT)) :
    ?>
        <div id="sign_form_pop" class="pop_up-container" data-evtclose="evt_cd_50">
            <?= $this->generateFile('view/elements/popup/popupFormSign.php', []); ?>
        </div>
    <?php
    endif;
    ?>
    <?php
    if ($person->hasCookie(Cookie::COOKIE_CLT) && (!empty($person->getAddresses()))) :
    ?>
        <div id="address_adder_pop" class="pop_up-container" data-evtclose="evt_cd_33">
            <?= $this->generateFile('view/elements/popup/popupFormAddAddress.php', ["country" => $country]); ?>
        </div>
    <?php
    endif;
    ?>
</div>