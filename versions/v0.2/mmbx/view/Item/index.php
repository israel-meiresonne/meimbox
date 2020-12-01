<?php

/**
 * @var array
 */
$measureUnits = $measureUnits;

$this->title = "item";
$this->description = "item page";
/**
 * @var Translator
 */
$translator = $translator;

/**
 * @var BoxProduct|BasketProduct
 */
$product = $product;
$prodID = $product->getProdID();

$datas = ["prodID" => $prodID];
$this->head = $this->generateFile('view/Item/itemFiles/head.php', $datas);

/**
 * @var BoxProduct[]|BasketProduct[]
 */
$sliderProducts = $sliderProducts;

/**
 * @var Visitor|Client|Administrator
 */
$person = $person;
switch (get_class($person)) {
    case Visitor::class:
        /**
         * @var Measure[]
         */
        $measures = $person->getMeasures();
        break;
    case Client::class:
        /**
         * @var Measure[]
         */
        $measures = $person->getMeasures();
        break;
    case Administrator::class:
        /**
         * @var Measure[]
         */
        $measures = [];
        break;
}

$language = $person->getLanguage();
$country = $person->getCountry();
$currency = $person->getCurrency();
$measures = $person->getMeasures();
$basket = $person->getBasket();

/**
 * @var array
 */
$brandsMeasures = $brandsMeasures;
?>

<div class="item_page-inner">
    <div class="directory-wrap">
        <p>women \ collection \ coat \ essential double coat</p>
    </div>
    <div class="product-block">
        <div class="product-block-inner">
            <div class="product-pictures-div">
                <div class="product-pictures-inner">
                    <?php
                    // $pictures = $product->getPictures();
                    $pictures = $product->getPictureSources();
                    $elements = [];
                    foreach ($pictures as $index => $picture) {
                        $element = $this->generateFile("view/Item/itemFiles/sliderPicture.php", ["picture" => $picture]);
                        $elements[$index] = $element;
                    }
                    $sliderClass = "showed_product_slider";
                    $buttonDatasMap = new Map();

                    $datas = [
                        "elements" => $elements,
                        "sliderClass" => $sliderClass,
                        "name" => "product pictures"
                    ];
                    echo $this->generateFile("view/elements/slider.php", $datas);
                    ?>
                </div>
            </div>
            <div class="product-details-div">
                <div class="product-details-inner">
                    <!-- <div id="form_check_prod_stock" class="product-datas-block"> -->
                    <div class="product-datas-block">
                        <div class="product-name-div product-data-line">
                            <h3>
                                <span><?= $translator->translateString($product->getProdName()) ?> | <span style="color:<?= $product->getColorRGBText() ?>;"><?= $product->getColorName() ?></span></span>
                            </h3>
                        </div>
                        <div class="product-price-div product-data-line">
                            <h3><?= $product->getFormatedPrice() ?></h3>
                        </div>
                        <div class="detail-color-div product-data-line">
                            <ul class="remove-ul-default-att">
                                <?php
                                $products = $product->getSameProducts();
                                $products[$prodID] = $product;
                                ksort($products);
                                $maxCube = count($products);
                                $datas = [
                                    "products" => $products,
                                    "maxCube" => null,
                                    "prodID" => $prodID
                                ];
                                echo $this->generateFile("view/elements/productCube.php", $datas);
                                ?>
                            </ul>
                        </div>
                        <div class="size-form-container">
                            <?php
                            $datas = [
                                "formId" => "form_check_prod_stock",
                                "product" => $product,
                                "nbMeasure" => count($measures),
                                "conf" => Size::CONF_SIZE_ADD_PROD
                            ];
                            echo $this->generateFile("view/elements/sizeFormContent.php", $datas);
                            ?>
                        </div>
                    </div>
                    <div class="product-safe_info-block">
                        <div class="safe_info-wrap">
                            <ul class="safe_info-ul remove-ul-default-att">
                                <li class="safe_info-li remove-li-default-att">
                                    <div class="img_text_down-wrap">
                                        <div class="img_text_down-img-div">
                                            <div class="img_text_down-img-inner">
                                                <img src="<?= self::$DIR_STATIC_FILES ?>icons8-card-security-150.png">
                                            </div>
                                        </div>
                                        <div class="img_text_down-text-div">
                                            <?php
                                            $secureInfo = $translator->translateStation("US26");
                                            $customerServInfo = $translator->translateStation("US27");
                                            $deliveryInfo = $translator->translateStation("US28");
                                            ?>
                                            <span><?= $secureInfo ?></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="safe_info-li remove-li-default-att">
                                    <div class="img_text_down-wrap">
                                        <div class="img_text_down-img-div">
                                            <div class="img_text_down-img-inner">
                                                <img src="<?= self::$DIR_STATIC_FILES ?>icons8-headset-96.png">
                                            </div>
                                        </div>
                                        <div class="img_text_down-text-div">
                                            <span><?= $customerServInfo ?></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="safe_info-li remove-li-default-att">
                                    <div class="img_text_down-wrap">
                                        <div class="img_text_down-img-div">
                                            <div class="img_text_down-img-inner">
                                                <img src="<?= self::$DIR_STATIC_FILES ?>return-box.png">
                                            </div>
                                        </div>
                                        <div class="img_text_down-text-div">
                                            <span><?= $deliveryInfo ?></span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-description-block">
                        <div class="product-description-inner">
                            <div class="collapse-wrap">
                                <ul class="remove-ul-default-att">
                                    <li class="remove-li-default-att">
                                        <div class="collapse-div">
                                            <?php
                                            $descriptionTitle = $translator->translateStation("US29");
                                            $description = $product->getDescription();
                                            $eventJson = htmlentities(json_encode(["prodID" => $prodID]));
                                            $shippingTitle = $translator->translateStation("US30");
                                            $shippingTxt = $translator->translateStation("US31");
                                            ?>
                                            <div class="collapse-title-div" data-evtopen="evt_cd_11" data-evtclose="evt_cd_12" data-evtj="<?= $eventJson ?>">
                                                <div class="collapse-title"><?= $descriptionTitle ?></div>
                                                <div class="collapse-symbol">
                                                    <div class="plus_symbol-container">
                                                        <div class="plus_symbol-wrap">
                                                            <span class="plus_symbol-vertical"></span>
                                                            <span class="plus_symbol-horizontal"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse-text-div collapse-text-hidded">
                                                <div class="collapse-text-inner">
                                                    <?= $description ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="remove-li-default-att">
                                        <div class="collapse-div">
                                            <div class="collapse-title-div" data-evtopen="evt_cd_13" data-evtclose="evt_cd_14">
                                                <div class="collapse-title"><?= $shippingTitle ?></div>
                                                <div class="collapse-symbol">
                                                    <div class="plus_symbol-container">
                                                        <div class="plus_symbol-wrap">
                                                            <span class="plus_symbol-vertical"></span>
                                                            <span class="plus_symbol-horizontal"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse-text-div collapse-text-hidded">
                                                <div class="collapse-text-inner">
                                                    <?= $shippingTxt ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="suggest-block">
        <?php
        $elements = [];
        foreach ($sliderProducts as $index => $product) {
            // $product->CompleteProperties($language, $country, $currency);
            $datas = [
                "product" => $product,
                "country" => $country,
                "currency" => $currency
            ];
            $element = $this->generateFile("view/elements/product.php", $datas);
            $elements[$index] = $element;
        }

        $datas = [
            "title" => $translator->translateStation("US32"),
            "elements" => $elements,
            "sliderClass" => null
        ];
        echo $this->generateFile("view/elements/sliderSuggest.php", $datas);
        ?>
    </div>

</div>