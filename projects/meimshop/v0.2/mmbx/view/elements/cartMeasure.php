<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build a cart with a set of cart element passed
 * @param string[] $cartDatas property content of cart element
 *      $cartDatas = [
 *           index => [
 *               "content" => string,
 *               "removeBtn" => string,
 *               "priceBlockContent" => string,
 *               "editBtn" => string
 *           ]
 *      ]
 */
$editBtnTranslate = $translator->translateStation("US49");

?>
<div class="cart-wrap">
    <ul class="remove-ul-default-att">
        <?php
        foreach ($cartDatas as $datas) :

            //————
            if (!empty($datas["priceBlockContent"])) :
                ob_start(); ?>
                <div class="cart-element-price-block">
                    <div class="cart-element-price-inner">
                        <?= $datas["priceBlockContent"] ?>
                    </div>
                </div>
            <?php
                $priceBlock = ob_get_clean();
            else :
                $priceBlock = "";
                $editBlockClass = "no_price_block";
            endif;

            //————
            if (!empty($datas["removeBtn"])) :
                $removeBtn = $datas["removeBtn"];
            else :
                ob_start(); ?>
                <button class="close_button-wrap remove-button-default-att">
                    <div class="plus_symbol-wrap">
                        <span class="plus_symbol-vertical"></span>
                        <span class="plus_symbol-horizontal"></span>
                    </div>
                </button>
            <?php
                $removeBtn = ob_get_clean();
            endif;

            if (!empty($datas["editBtn"])) :
                $editBtn = $datas["editBtn"];
            else :
                ob_start(); ?>
                <button class="cart-element-edit-button remove-button-default-att"><?= $editBtnTranslate ?></button>';
            <?php
                $editBtn = ob_get_clean();
            endif; ?>

            <li class="li-cart-element-container remove-li-default-att">
                <div class="cart-element-wrap">
                    <div class="cart-element-inner">
                        <div class="cart-element-remove-button-block">
                            <?= $removeBtn ?>
                        </div>
                        <div class="cart-element-detail-block">
                            <div class="cart-element-property-set">
                                <?= $datas["content"] ?>
                            </div>
                        </div>
                        <div class="cart-element-edit-block <?= $editBlockClass ?>">
                            <div class="cart-element-edit-inner">
                                <?= $editBtn ?>
                            </div>
                        </div>
                        <?= $priceBlock ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>