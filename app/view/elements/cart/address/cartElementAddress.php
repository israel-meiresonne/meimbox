<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerId id of the tag that contain datas generated
 * @param string $elementId id of the element (allway given)
 * + this id is generated in file cart.php
 * @param string $title title of the element
 * @param Address $address User's Address
 * @param boolean $showButon set true to show edit and remove button else false
 * @param string $dadx selector of the dad (if set it activate the select fonctionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 */

/**
 * @var Address
 */
$address = $address;

/** Event */
// $eventDatas = [
//     Address::INPUT_ADDRESS => $address->getAddress(),
//     Address::INPUT_ZIPCODE => $address->getZipcode(),
//     Country::KEY_ISO_CODE => $address->getCountry()->getCountryName()
// ];
$eventDatas = [Address::KEY_ADRS_SEQUENCE => $address->getSequence()];
$eventJson = htmlentities(json_encode($eventDatas));


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
<!-- <div class=""> -->
<div <?= $Tagflag ?> class="cart-element-wrap" <?= $Tagbrotherx ?> <?= $Tagsubmitdata ?>>
    <div class="cart-element-inner">
        <?php
        if ($showButon) :
        ?>
            <div class="cart-element-remove-button-block">
                <button class="close_button-wrap remove-button-default-att" <?= $TagdeleteFunc ?>>
                    <div class="plus_symbol-wrap">
                        <span class="plus_symbol-vertical"></span>
                        <span class="plus_symbol-horizontal"></span>
                    </div>
                </button>
            </div>
        <?php
        endif;
        ?>
        <div <?= $Taglaunch ?> class="cart-element-detail-block" data-evtcd="evt_cd_26" data-evtj="<?= $eventJson ?>" <?= $TaglaunchxFunc ?> <?= $Tagdadx ?> <?= $Tagflagx ?>>
            <div class="cart-element-property-set box-property-set">
                <?php
                if (!empty($title)) :
                ?>
                    <div class="cart-element-property-div">
                        <span><?= $title ?></span>
                    </div>
                <?php
                endif;
                ?>
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
            </div>
        </div>
        <?php
        if ($showButon) :
        ?>
            <div class="cart-element-edit-block edit-block-external">
                <div class="cart-element-edit-inner">
                    <button class="cart-element-edit-button remove-button-default-att" <?= "" //$TagEditFunc 
                                                                                        ?>>
                        <img src="<?= self::$DIR_STATIC_FILES ?>vertical-three-dot.png">
                    </button>
                </div>
            </div>
        <?php
        endif;
        ?>
    </div>
</div>
<!-- </div> -->