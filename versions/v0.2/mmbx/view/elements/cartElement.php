<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $elementId id of the element (allway given)
 * + this id is generated in file cart.php
 * @param string $deleteFunc onclick function to delete element
 * + i.e: $deleteFunc = "slideSomething('param1','param2');jumpFrom('param1','param2')"
 * @param string $pictureSrc the source of the picture of the cart element's 
 * @param string $properties html tags to put in as content
 * + use class 'cart-element-property-div' to build properties set
 *      <div class="cart-element-property-div">
 *          <span class="cart-element-property">item: </span>
 *          <span class="cart-element-value">3</span>
 *      </div>
 * + the picture conatin all the directory like my/file/is/here/$picture
 * @param string|null $editFunc function for edit button
 * @param string|null $miniPopEdit mini pop up for edit button
 * @param string|null $price price property in a displayable format (with currency)
 * @param boolean $showArrow set true to display the arrow else set false
 * @param string $boxBodyId id of the box's content holder
 * ——————————————————————————————— ID & DATA DOWN —————————————————————————————————————
 * @param string $dadx selector of the dad (if set it activate the selectPopUp functionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 * @param array $eventDatas
 * @param string $detailAttr  attribut to place on tag that contain element's properties
 */
$showArrow = (isset($showArrow)) ? $showArrow : true; // show alway except if false
$TagdeleteFunc = (!empty($deleteFunc)) ? 'onclick="' . $deleteFunc . '"' : "";

$TagEditFunc = (!empty($editFunc)) ? 'onclick="' . $editFunc . '"' : null;

/** Event */
$eventJson = htmlentities(json_encode($eventDatas));
$detailAttr = (!empty($detailAttr)) ? $detailAttr : null;

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
        <div <?= $Taglaunch ?> class="cart-element-detail-block" <?= $detailAttr ?> <?= $TaglaunchxFunc ?> <?= $Tagdadx ?> <?= $Tagflagx ?>>
            <div class="cart-element-img-div">
                <img src="<?= $pictureSrc ?>">
            </div>
            <div class="cart-element-property-set box-property-set">
                <?= $properties ?>
            </div>
        </div>
        <div class="cart-element-edit-block edit-block-external">
            <?php
            if (!empty($TagEditFunc)) : ?>
                <div class="cart-element-edit-inner">
                    <button class="cart-element-edit-button remove-button-default-att" <?= $TagEditFunc ?>>
                        <img src="<?= self::$DIR_STATIC_FILES ?>vertical-three-dot.png">
                    </button>
                    <?= $miniPopEdit ?>
                </div>
            <?php
            endif; ?>
        </div>
        <?php if (isset($price)) : ?>
            <div class="cart-element-price-block">
                <div class="cart-element-price-inner">
                    <span><?= $price ?></span>
                </div>
            </div>
        <?php
        endif;
        if ($showArrow) :
            $arrowId = ModelFunctionality::generateDateCode(25);
            $arrowx = "#" . $arrowId;
            $boxBodyx = "#" . $boxBodyId;
        ?>
            <div class="cart-element-arrow-block">
                <div class="cart-element-arrow-inner">
                    <button class="cart-element-arrow-button remove-button-default-att" data-evtopen="evt_cd_59" data-evtclose="evt_cd_60" data-evtj="<?= $eventJson ?>" onclick="toggleShutter(this,'<?= $boxBodyx ?>', '<?= $arrowx ?>')">
                        <div id="<?= $arrowId ?>" class="arrow-element-wrap">
                            <span class="arrow-span"></span>
                        </div>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>