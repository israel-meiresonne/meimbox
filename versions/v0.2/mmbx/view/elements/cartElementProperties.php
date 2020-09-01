<?php
require_once 'model/tools-management/Measure.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string|null $title title property
 * @param string|null $color name of the color
 * @param string|null $colorRGB color's RGB code
 * + if $color is set this attribut must be setted to
 * @param string|null $size size proprty
 * @param string|null $brand size's brand reference
 * @param Measure|null $measure size's measure
 * @param int|null $item number of different item property (used for boxes)
 * @param int|null $max max number of item in element (used for boxes)
 * @param int|null $quantity quantity of same item property (used for products)
 * @param string|null $price price property in a displayable format (with curreency)
 */
if(isset($title)):
?>
<div class="cart-element-property-div">
    <span>golden box</span>
</div>
<?php
endif;
if(isset($color)):
?>
<div class="cart-element-property-div">
    <span class="cart-element-property">color: </span>
    <span class="cart-element-value" style="color: #AF3134;">red</span>
</div>
<?php
endif;
if(isset($size)):
?>
<div class="cart-element-property-div">
    <span class="cart-element-property">size: </span>
    <span class="cart-element-value">s</span>
</div>
<?php
endif;
if(isset($brand)):
?>
<div class="cart-element-property-div">
    <span class="cart-element-property">brand: </span>
    <span class="cart-element-value"><?= $brand ?></span>
</div>
<?php
endif;
if(isset($measure)):
?>
<div class="cart-element-property-div">
    <span class="cart-element-property">measure: </span>
    <span class="cart-element-value"><?= $measure->getMeasureName() ?></span>
</div>
<?php
endif;
if(isset($item)):
?>
<div class="cart-element-property-div">
    <span class="cart-element-property">item: </span>
    <span class="cart-element-value">3/<?= $max ?></span>
</div>
<?php
endif;
if(isset($quantity)):
?>
<div class="cart-element-property-div">
    <span class="cart-element-property">quantity: </span>
    <span class="cart-element-value">2</span>
</div>
<?php
endif;
if(isset($price)):
?>
<div class="cart-element-property-div cart-element-property-price-div">
    <span class="cart-element-property">price: </span>
    <span class="cart-element-value">$52.50 usd</span>
</div>
<?php
endif;
?>
<div class="cart-element-property-div cart-element-property-edit-div">
    <div class="cart-element-edit-block">
        <div class="cart-element-edit-inner">
            <button class="cart-element-edit-button remove-button-default-att"><?= $translator->translateStation("US49") ?></button>
        </div>
    </div>
</div>