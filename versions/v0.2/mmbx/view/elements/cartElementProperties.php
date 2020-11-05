<?php
require_once 'model/tools-management/Measure.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string|null   $title       title property
 * @param string|null   $color       name of the color
 * @param string|null   $colorRGB    color's RGB code
 * + if $color is set this attribut must be setted to
 * @param string|null   $size        size proprty
 * @param string|null   $brand       size's brand reference
 * @param Measure|null  $measure     size's measure
 * @param string|null   $cut         measure's cut
 * @param int|null      $nbItem      number of different item property (used for boxes)
 * @param int|null      $max         max number of item in element (used for boxes)
 * @param int|null      $quantity    quantity of same item property (used for products)
 * @param string|null   $price       price property in a displayable format (with currency)
 * @param string|null $editFunc function for edit button
 * @param string|null $miniPopEdit mini pop up for edit button
 */
$TagEditFunc = (!empty($editFunc)) ? 'onclick="' . $editFunc . '"' : null;

if (isset($title)) :
?>
    <div class="cart-element-property-div">
        <span><?= $title ?></span>
    </div>
<?php
endif;
if (isset($color) && isset($colorRGB)) :
?>
    <div class="cart-element-property-div">
        <span class="cart-element-property"><?= $translator->translateStation("US10") ?>: </span>
        <span class="cart-element-value" style="color: <?= $colorRGB ?>;"><?= $color ?></span>
    </div>
<?php
endif;
if (isset($size)) :
?>
    <div class="cart-element-property-div">
        <span class="cart-element-property"><?= $translator->translateStation("US9") ?>: </span>
        <span class="cart-element-value"><?= $size ?></span>
    </div>
<?php
endif;
if (isset($brand)) :
?>
    <div class="cart-element-property-div">
        <span class="cart-element-property"><?= $translator->translateStation("US47") ?>: </span>
        <span class="cart-element-value"><?= $brand ?></span>
    </div>
<?php
endif;
if (isset($measure)) :
?>
    <div class="cart-element-property-div">
        <span class="cart-element-property"><?= $translator->translateStation("US48") ?>: </span>
        <span class="cart-element-value"><?= $measure->getMeasureName() ?></span>
    </div>
<?php
endif;
if (isset($cut)) :
?>
    <div class="cart-element-property-div">
        <span class="cart-element-property"><?= $translator->translateStation("US52") ?>: </span>
        <span class="cart-element-value"><?= $cut ?></span>
    </div>
<?php
endif;
if (isset($nbItem) && isset($max)) :
?>
    <div class="cart-element-property-div">
        <span class="cart-element-property"><?= $translator->translateStation("US53") ?>: </span>
        <span class="cart-element-value" data-basket="boxrate"><?= $nbItem ?>/<?= $max ?></span>
    </div>
<?php
endif;
if (isset($quantity)) :
?>
    <div class="cart-element-property-div">
        <span class="cart-element-property"><?= $translator->translateStation("US54") ?>: </span>
        <span class="cart-element-value"><?= $quantity ?></span>
    </div>
<?php
endif;
if (isset($price)) :
?>
    <div class="cart-element-property-div cart-element-property-price-div">
        <span class="cart-element-property"><?= $translator->translateStation("US11") ?>: </span>
        <span class="cart-element-value"><?= $price ?></span>
    </div>
<?php
endif;

if (isset($TagEditFunc)) :
?>
    <div class="cart-element-property-div cart-element-property-edit-div">
        <div class="cart-element-edit-block">
            <div class="cart-element-edit-inner">
                <button class="cart-element-edit-button remove-button-default-att" <?= $TagEditFunc ?> ><?= $translator->translateStation("US49") ?></button>
                <?= $miniPopEdit ?>
            </div>
        </div>
    </div>
<?php
endif;
?>