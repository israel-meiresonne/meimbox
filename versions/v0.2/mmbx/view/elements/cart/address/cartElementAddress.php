<?php
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerId id of the tag that contain datas generated
 * @param string $elementId id of the element (allway given)
 * + this id is generated in file cart.php
 * @param Address $address User's Address
 * @param string $dadx selector of the dad (if set it activate the select fonctionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 */

/**
 * @var Address
 */
$address = $address;

$elementIdx = "#" . $elementId;
$containerIdx = "#" . $containerId;
$TagdeleteFunc = (!empty($deleteFunc)) ? 'onclick="' . $deleteFunc . '"' : "";

$TagEditFunc = (!empty($editFunc)) ? 'onclick="' . $editFunc . '"' : "";

if (!empty($dadx)) {
    $launch = ModelFunctionality::generateDateCode(25);
    $Taglaunch = "id='$launch'";
    $launchx = "#" . $launch;
    $TaglaunchxFunc = "onclick=\"selectPopUp('$launchx')\"";

    $Tagdadx = "data-dadx='$dadx'";
    $Tagbrotherx = "data-brotherx='$brotherx'";
    $Tagsubmitdata = 'data-submitdata="' . $submitdata . '"';

    $flag = ModelFunctionality::generateDateCode(25);
    $Tagflag = "id='$flag'";
    $flagx = "#" . $flag;
    $Tagflagx = "data-flagx='$flagx'";
} else {
    $Taglaunch = "";
    $TaglaunchxFunc = "";
    $Tagdadx = "";
    $Tagbrotherx = "";
    $Tagflag = "";
    $Tagflagx = "";
    $Tagsubmitdata = "";
}
?>
<div class="<?= $prodClass ?>">
    <div <?= $Tagflag ?> class="cart-element-wrap" <?= $Tagbrotherx ?> <?= $Tagsubmitdata ?>>
        <div class="cart-element-inner">
            <div class="cart-element-remove-button-block">
                <button class="close_button-wrap remove-button-default-att" <?= $TagdeleteFunc ?>>
                    <div class="plus_symbol-wrap">
                        <span class="plus_symbol-vertical"></span>
                        <span class="plus_symbol-horizontal"></span>
                    </div>
                </button>
            </div>
            <div <?= $Taglaunch ?> class="cart-element-detail-block" <?= $TaglaunchxFunc ?> <?= $Tagdadx ?> <?= $Tagflagx ?>>
                <!-- <div class="cart-element-img-div">
                    <img src="<?= "" //$pictureSrc 
                                ?>">
                </div> -->
                <div class="cart-element-property-set box-property-set">
                    <!-- <div class="cart-element-property-div">
                        <span><?= "" //$title 
                                ?></span>
                    </div> -->
                    <div class="cart-element-property-div">
                        <span class="cart-element-property"><?= "address" ?>: </span>
                        <span class="cart-element-value"><?= $address->getAddress() ?></span>
                    </div>
                    <?php
                    $appart = $address->getAppartement();
                    if (!empty($appart)) :
                    ?>
                        <div class="cart-element-property-div">
                            <span class="cart-element-property"><?= "detail" ?>: </span>
                            <span class="cart-element-value"><?= $appart ?></span>
                        </div>
                    <?php
                    endif;
                    ?>
                    <div class="cart-element-property-div">
                        <span class="cart-element-property"><?= "province" ?>: </span>
                        <span class="cart-element-value"><?= $address->getProvince() ?></span>
                    </div>
                    <div class="cart-element-property-div">
                        <span class="cart-element-property"><?= "city" ?>: </span>
                        <span class="cart-element-value"><?= $address->getCity() ?></span>
                    </div>
                    <div class="cart-element-property-div">
                        <span class="cart-element-property"><?= "country" ?>: </span>
                        <span class="cart-element-value"><?= $address->getCountry()->getCountryName() ?></span>
                    </div>
                    <div class="cart-element-property-div">
                        <span class="cart-element-property"><?= "zipcode" ?>: </span>
                        <span class="cart-element-value"><?= $address->getZipcode() ?></span>
                    </div>
                    <?php
                    $phone = $address->getPhone();
                    if (!empty($phone)) :
                    ?>
                        <div class="cart-element-property-div">
                            <span class="cart-element-property"><?= "phone" ?>: </span>
                            <span class="cart-element-value"><?= number_format($phone, 0, "", " ") ?></span>
                        </div>
                    <?php
                    endif;
                    ?>
                    <!-- <div class="cart-element-property-div cart-element-property-edit-div">
                        <div class="cart-element-edit-block">
                            <div class="cart-element-edit-inner">
                                <button class="cart-element-edit-button remove-button-default-att"><?= $translator->translateStation("US49") ?></button>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="cart-element-edit-block edit-block-external">
                <div class="cart-element-edit-inner">
                    <button class="cart-element-edit-button remove-button-default-att" <?= "" //$TagEditFunc 
                                                                                        ?>><?= $translator->translateStation("US49") ?></button>
                </div>
            </div>
        </div>
    </div>
</div>