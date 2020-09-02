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
 * @param boolean $showRow set true to display the row else set false
 */
$showRow = (isset($showRow)) ? $showRow : true; // show alway except if false
?>
<!-- <div class="cart-element-wrap" style="box-shadow: var(--box-shadow);"> -->
<div class="cart-element-wrap">
    <div class="cart-element-inner">
        <div class="cart-element-remove-button-block">
            <button class="close_button-wrap remove-button-default-att">
                <div class="plus_symbol-wrap">
                    <span class="plus_symbol-vertical"></span>
                    <span class="plus_symbol-horizontal"></span>
                </div>
            </button>
        </div>
        <div class="cart-element-detail-block">
            <div class="cart-element-img-div">
                <!-- <img src="content/brain/permanent/box-gold-128.png"> -->
                <img src="<?= $pictureSrc ?>">
            </div>
            <div class="cart-element-property-set box-property-set">
                <?php echo $properties ?>
                <!-- <div class="box-property-set-inner">
                    <div class="cart-element-property-div">
                        <span>golden box</span>
                    </div>
                    <div class="cart-element-property-div">
                        <span class="cart-element-property">item: </span>
                        <span class="cart-element-value">3</span>
                    </div>
                    <div class="cart-element-property-div cart-element-property-price-div">
                        <span class="cart-element-property">price: </span>
                        <span class="cart-element-value">$52.50 usd</span>
                    </div>
                    <div class="cart-element-property-div cart-element-property-edit-div">
                        <div class="cart-element-edit-block">
                            <div class="cart-element-edit-inner">
                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                            </div>
                        </div>
                    </div>
                </div> -->
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
        if ($showRow) :
        ?>
            <div class="cart-element-arrow-block">
                <div class="cart-element-arrow-inner">
                    <button class="cart-element-arrow-button remove-button-default-att">
                        <div class="arrow-element-wrap">
                            <span class="arrow-span"></span>
                        </div>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>