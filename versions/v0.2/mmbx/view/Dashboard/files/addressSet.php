<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Map $addressMap User's addresses
 */

?>

<div class="address-set">
    <div class="address-set-head">
        <div class="form-title-block address-title-block">
            <div class="form-title-div">
                <span class="form-title">select a shipping address</span>
            </div>
        </div>
    </div>
    <hr class="hr-summary">
    <div class="address-set-body">
        <div id="addresses_set_dynamic" class="address-set-dynamic">
            <?php
            $dad = ModelFunctionality::generateDateCode(25);
            $brother = ModelFunctionality::generateDateCode(25);
            $brotherx = "#$brother";
            $sbtnid = ModelFunctionality::generateDateCode(25);;
            $sbtnx = "#$sbtnid";
            $datas = [
                "containerId" => "addresses_set_dynamic",
                "addressMap" => $addressMap,
                "dad" => $dad,
                "brotherx" => $brotherx,
                "sbtnx" => $sbtnx
            ];
            echo $this->generateFile('view/elements/cart/address/cartAddresses.php', $datas);
            ?>
        </div>
        <div class="address-set-static">
            <div class="center-btn-div">
                <button class="green-button standard-button remove-button-default-att" onclick="openPopUp('#address_adder_pop')">add new address</button>
            </div>
            <div class="loading-img-wrap">
                <img src="<?= self::DIR_STATIC_FILES ?>loading.gif">
            </div>
            <div class="pop_up-validate_button-div">
                <button id="<?= $sbtnid ?>" disabled=true class="green-arrow standard-button-desabled remove-button-default-att" onclick="selectAddress('<?= $sbtnx ?>')">select address</button>
            </div>
        </div>
    </div>
</div>