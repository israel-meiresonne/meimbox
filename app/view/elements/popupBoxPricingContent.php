<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Language $language the Visitor's language
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */

/**
 * @var Translator
 */
$translator = $translator;

/** Translations */
$remplacements = ["basket_translate" => $translator->translateStation("US25")];
$adderBtnTxt = $translator->translateStation("US24", new Map($remplacements));

/**
 * List of boxes supported ordered by price from lower to bigger
 * @var Box[]
 */
$boxes = Box::getSamples($language, $country, $currency);
?>
<div class="box_princing-content">
    <div class="box_price-box-set">
        <ul class="box_price-box-set-ul remove-ul-default-att">
            <?php
            foreach ($boxes as $box) :
                $popx = "#box_pricing_window";
                $sbtn = ModelFunctionality::generateDateCode(25);
                $sbtnx = "#" . $sbtn;

                $boxColor = $box->getColor();
                $boxEventJson = htmlentities(json_encode([Box::KEY_BOX_COLOR => $boxColor])); ?>
                <li class="box_price-box-set-li remove-li-default-att">
                    <div class="pricing-wrap">
                        <div class="pricing-wrap-inner">
                            <div class="product-pricing-block">
                                <div class="product_image-block">
                                    <div class="img-text-down-container">
                                        <div class="img_text_down-wrap">
                                            <div class="img_text_down-img-div">
                                                <div class="img_text_down-img-inner">
                                                    <img src="<?= $box->getPictureSource() ?>">
                                                </div>
                                            </div>
                                            <div class="img_text_down-text-div">
                                                <h4>
                                                    <span class="box-color-name"><?= ucfirst($boxColor) ?></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_add-button-block">
                                    <button id="<?= $sbtn ?>" class="submit_btn_cls green-button standard-button remove-button-default-att" onclick="evt('evt_cd_51','<?= $boxEventJson ?>');addBox('<?= $box->getColorCode() ?>','<?= $popx ?>','<?= $sbtnx ?>')">
                                        <?= $adderBtnTxt ?>
                                    </button>
                                </div>
                                <div class="product_detail-block">
                                    <div class="product_detail-info">
                                        <h3 class="product_detail-info-first-title">
                                            <p><?= $box->getPriceFormated() ?><span class="fraction-span">/<?= $translator->translateStation("US55") ?></span></p>
                                        </h3>
                                        <div class="checked-wrap">
                                            <div class="symbol-container">
                                                <div class="v_symbol-wrap">
                                                    <span class="v_symbol-vertical"></span>
                                                    <span class="v_symbol-horizontal"></span>
                                                </div>
                                            </div>
                                            <h4 class="checked-wrap-content">
                                                <p>
                                                    <?= $box->getSizeMax() ?> <?= $translator->translateStation("US53") ?><span class="fraction-span">/box</span>
                                                    <?php /* ≈<?= str_replace(' ', '', $box->getPricePerItem()) ?><span class="fraction-span">/<?= $translator->translateStation("US53") ?></span> */ ?>
                                                </p>
                                            </h4>
                                        </div>
                                        <div class="checked-wrap">
                                            <div class="symbol-container">
                                                <div class="v_symbol-wrap">
                                                    <span class="v_symbol-vertical"></span>
                                                    <span class="v_symbol-horizontal"></span>
                                                </div>
                                            </div>
                                            <div class="checked-wrap-content">
                                                <span>
                                                    <?php
                                                    $shipping = $box->getShipping();
                                                    if ($shipping->getPrice() <= 0) :
                                                        echo ucfirst($translator->translateStation("US142"));
                                                    else : ?>
                                                        <?= ucfirst($translator->translateStation("US66")) ?>: <b><?= str_replace(' ', '', $box->getShipping()->getFormated()) ?></b>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <ul class="remove-ul-default-att">
                                            <?php
                                            $maxShip = $shipping->getMaxTime();
                                            $replacementsMap = new Map([Map::time => $maxShip]);
                                            $advStations = $box->getAdvantages();
                                            $drawStations = $box->getDrawbacks();
                                            foreach ($advStations as $advStation) : ?>
                                                <li class="remove-li-default-att">
                                                    <div class="checked-wrap">
                                                        <div class="symbol-container">
                                                            <div class="v_symbol-wrap">
                                                                <span class="v_symbol-vertical"></span>
                                                                <span class="v_symbol-horizontal"></span>
                                                            </div>
                                                        </div>
                                                        <div class="checked-wrap-content">
                                                            <p><?= ucfirst($translator->translateStation($advStation, $replacementsMap)) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php
                                            endforeach;
                                            foreach ($drawStations as $drawStation) :
                                            ?>
                                                <li class="remove-li-default-att">
                                                    <div class="checked-wrap">
                                                        <div class="symbol-container">
                                                            <div class="o_symbol-wrap">
                                                                <div class="o_symbol"></div>
                                                            </div>
                                                        </div>
                                                        <div class="checked-wrap-content">
                                                            <p><?= ucfirst($translator->translateStation($drawStation, $replacementsMap)) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php
                                            endforeach;
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </div>
</div>