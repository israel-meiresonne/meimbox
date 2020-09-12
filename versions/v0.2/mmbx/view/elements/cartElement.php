<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $properties html tags to put in as content
 * + use class 'cart-element-property-div' to build properties set
 *      <div class="cart-element-property-div">
 *          <span class="cart-element-property">item: </span>
 *          <span class="cart-element-value">3</span>
 *      </div>
 * @param string $pictureSrc the source of the picture of the cart element's 
 * + the picture conatin all the directory like my/file/is/here/$picture
 * @param string|null $price price property in a displayable format (with currency)
 * @param boolean $showArrow set true to display the arow else set false
 * @param string $dadx selector of the dad (if set it activate the selectPopUp functionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 */
$showArrow = (isset($showArrow)) ? $showArrow : true; // show alway except if false

if (!empty($dadx)) {
    $launch = ModelFunctionality::generateDateCode(25);
    $Taglaunch = "id='$launch'";
    $launchx = "#" . $launch;
    $TaglaunchxFunc = "onclick=\"selectPopUp('$launchx')\"";

    $Tagdadx = "data-dadx='$dadx'";
    $Tagbrotherx = "data-brotherx='$brotherx'";
    $Tagsubmitdata = "data-submitdata='$submitdata'";

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
<!-- <div class="cart-element-wrap" style="box-shadow: var(--box-shadow);"> -->
<div <?= $Tagflag ?> class="cart-element-wrap" <?= $Tagbrotherx ?> <?= $Tagsubmitdata ?> >
    <div class="cart-element-inner">
        <div class="cart-element-remove-button-block">
            <button class="close_button-wrap remove-button-default-att">
                <div class="plus_symbol-wrap">
                    <span class="plus_symbol-vertical"></span>
                    <span class="plus_symbol-horizontal"></span>
                </div>
            </button>
        </div>
        <div <?= $Taglaunch ?> class="cart-element-detail-block" <?= $TaglaunchxFunc ?> <?= $Tagdadx ?> <?= $Tagflagx ?> >
            <div class="cart-element-img-div">
                <img src="<?= $pictureSrc ?>">
            </div>
            <div class="cart-element-property-set box-property-set">
                <?php echo $properties ?>
            </div>
        </div>
        <div class="cart-element-edit-block edit-block-external">
            <div class="cart-element-edit-inner">
                <button class="cart-element-edit-button remove-button-default-att"><?= $translator->translateStation("US49") ?></button>
            </div>
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
            $arrowIdx = "#".$arrowId;
        ?>
            <div class="cart-element-arrow-block">
                <div class="cart-element-arrow-inner">
                    <button id="<?= $arrowId ?>" class="cart-element-arrow-button remove-button-default-att" onclick="animateBox('<?= $arrowIdx ?>')">
                        <div class="arrow-element-wrap">
                            <span class="arrow-span"></span>
                        </div>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>