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
                                <img src="<?= self::$DIR_STATIC_FILES ?>loading.gif">
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
            </div>

        </div>

    </div>
</div>