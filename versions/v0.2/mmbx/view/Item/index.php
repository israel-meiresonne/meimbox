<?php
require_once 'model/boxes-management/Size.php';

/**
 * @var Translator
 */
$translator = $translator;

/**
 * @var BoxProduct|BasketProduct
 */
$product = $product;
$prodID = $product->getProdID();

/**
 * @var BoxProduct[]|BasketProduct[]
 */
$sliderProducts = $sliderProducts;

/**
 * @var Visitor|Client|Administrator
 */
$person = $person;
switch (get_class($person)) {
    case Visitor::CLASS_NAME:
        /**
         * @var Measure[]
         */
        $measures = $person->getMeasures();
        break;
    case Client::CLASS_NAME:
        /**
         * @var Measure[]
         */
        $measures = $person->getMeasures();
        break;
    case Administrator::CLASS_NAME:
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

/**
 * @var array
 */
$measureUnits = $measureUnits;

$this->title = "item";
$this->lang = $language->getIsoLang();
$this->description = "item page";
// ob_start();
// require 'itemFiles/head.php';
// $this->head = ob_get_clean();
$datas = [
    "prodID" => $prodID
];
$this->head = $this->generateFile('view/Item/itemFiles/head.php', $datas);
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
                    $pictures = $product->getPictures();
                    $elements = [];
                    foreach ($pictures as $index => $picture) {
                        $element = $this->generateFile("view/Item/itemFiles/sliderPicture.php", ["picture" => $picture]);
                        $elements[$index] = $element;
                    }
                    $sliderClass = "showed_product_slider";
                    $datas = [
                        "elements" => $elements,
                        "sliderClass" => $sliderClass
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
                            <h3><?= $product->getDisplayablePrice($country, $currency) ?></h3>
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
                                                <img src="content/brain/permanent/icons8-card-security-150.png">
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
                                                <img src="content/brain/permanent/icons8-headset-96.png">
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
                                                <img src="content/brain/permanent/return-box.png">
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
                                            <div class="collapse-title-div">
                                                <?php
                                                $descriptionTitle = $translator->translateStation("US29");
                                                $description = $product->getDescription();
                                                $shippingTitle = $translator->translateStation("US30");
                                                $shippingTxt = $translator->translateStation("US31");
                                                ?>
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
                                            <div class="collapse-title-div">
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

    <!-- <div id="full_screen_div" class="full_screen-block"> -->
    <div id="full_screen_div" class="full_screen-block">
        <div id="customize_brand_reference" class="customize-brand_reference-block pop_up-container">
            <?php
            $datas = ["brandsMeasures" => $brandsMeasures];
            echo $this->generateFile("view/elements/popupBrand.php", $datas);
            ?>
        </div>
        <div id="measure_manager" class="customize_measure-block pop_up-container">
            <?php
            $datas = [
                "measures" => $measures,
                "measureUnits" => $measureUnits
            ];
            echo $this->generateFile("view/elements/popupMeasureManager.php", $datas);
            ?>
        </div>
        <div id="measure_adder" class="customize_measure-block pop_up-container">
            <?php
            $datas = [
                "measureUnits" => $measureUnits
            ];
            echo $this->generateFile("view/elements/popupMeasureAdder.php", $datas);
            ?>
        </div>
        <div id="box_manager_window" class="box_manager-container pop_up-container">
            <?php
            $datas = [
                "boxes" => $basket->getBoxes(),
                "country" => $country,
                "currency" => $currency,
                "conf" => Box::CONF_ADD_BXPROD
            ];
            echo $this->generateFile('view/elements/popupBoxManager.php', $datas);
            ?>
        </div>
        <div id="box_pricing_window" class="pricing-container pop_up-container">
            <?php
            $datas = [
                "language" => $language,
                "country" => $country,
                "currency" => $currency
            ];
            echo $this->generateFile('view/elements/popupBoxPricing.php', $datas);
            ?>
        </div>
        <div id="basket_pop" class="pop_up-container">
            <?php
            $datas = [
                "basket" => $basket,
                "country" => $country,
                "currency" => $currency
            ];
            echo $this->generateFile('view/elements/popupBasket.php', $datas);
            ?>
        </div>
        <div id="size_editor_pop" class="pop_up-container">
            <?php
            $datas = [
                "formId" => "form_edit_prod_size",
                "product" => $product,
                "nbMeasure" => count($measures),
            ];
            echo $this->generateFile('view/elements/popupSizeForm.php', $datas);
            ?>
        </div>
    </div>
</div>