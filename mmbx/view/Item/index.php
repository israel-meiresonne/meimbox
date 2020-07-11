<?php

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
$this->head = $this->generateFile('view/Item/itemFiles/head.php', []);
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
                    echo $this->generateFile("view/elements/slider.php", $datas)
                    ?>
                </div>
            </div>
            <div class="product-details-div">
                <div class="product-details-inner">
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
                        <div class="product-size-container product-data-line">
                            <div class="product-size-inner">
                                <div class="product-size-dropdown-container">
                                    <?php
                                    $title = $translator->translateStation("US9");
                                    $labels = $product->getSizeValueToValue();
                                    $datas = [
                                        "title" => $title,
                                        "checkedLabels" => [],
                                        "labels" => $labels,
                                        "isRadio" => true,
                                        "inputName" => Size::SIZE
                                    ];
                                    echo $this->generateFile("view/elements/dropdown.php", $datas);
                                    ?>
                                </div>
                                <div class="product-size-customize-container">
                                    <div class="product-size-customize-block">

                                        <div class="dropdown_checkbox-wrap">
                                            <div class="dropdown_checkbox-inner">
                                                <div class="dropdown_checkbox-head">
                                                    <div class="dropdown_checkbox-title">
                                                        <div class="dropdown_checkbox-checkbox-block">
                                                            <label class="checkbox-label" for="customize_size"><?= $translator->translateStation("US17") ?>
                                                                <input id="customize_size" type="checkbox" name="customize_size">
                                                                <span class="checkbox-checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="customize-price-block">
                                                            <?php $customDpPrice = (new Price(0, $currency))->getFormated(); ?>
                                                            <span class="customize-price-span"><?= $customDpPrice ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown_checkbox-checkbox-list">
                                                    <div class="customize_choice-block">
                                                        <div class="customize_choice-measure-block">
                                                            <div class="dropdown-checkbox-block">
                                                                <label class="checkbox-label" for="measurement_brand"><?= $translator->translateStation("US18") ?>
                                                                    <input id="measurement_brand" type="radio" name="size_measurement" value="choose_brand" checked>
                                                                    <span class="checkbox-checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="dropdown-checkbox-block">
                                                                <label class="checkbox-label" for="measurement_own"><?= $translator->translateStation("US19") ?>
                                                                    <input id="measurement_own" type="radio" name="size_measurement" value="measurement_button_div">
                                                                    <span class="checkbox-checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <hr class="hr-summary">
                                                        <div class="customize_choice-button-block">
                                                            <div id="choose_brand" class="customize_choice-button-container">
                                                                <div class="custom_selected-container"></div>
                                                                <button id="choose_brand_button" class="green-button remove-button-default-att"><?= $translator->translateStation("US20") ?></button>
                                                            </div>
                                                            <?php
                                                            if (count($measures) > 0) :
                                                                $addMsrBtnTxt = $translator->translateStation("US21");
                                                                $managerBtnTxt = $translator->translateStation("US22");
                                                            ?>
                                                                <div id="measurement_button_div" class="customize_choice-button-container">
                                                                    <div class="custom_selected-container"></div>
                                                                    <button id="add_measurement_button" style="display:none;" class="green-button remove-button-default-att"><?= $addMsrBtnTxt ?></button>
                                                                    <button id="manage_measurement_button" class="green-button remove-button-default-att"><?= $managerBtnTxt ?></button>
                                                                </div>
                                                            <?php
                                                            else :
                                                                $addMsrBtnTxt = $translator->translateStation("US21");
                                                                $managerBtnTxt = $translator->translateStation("US22");
                                                            ?>
                                                                <div id="measurement_button_div" class="customize_choice-button-container">
                                                                    <div class="custom_selected-container"></div>
                                                                    <button id="add_measurement_button" class="green-button remove-button-default-att"><?= $addMsrBtnTxt ?></button>
                                                                    <button id="manage_measurement_button" style="display:none;" class="green-button remove-button-default-att"><?= $managerBtnTxt ?></button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="customize_choice-block">
                                                        <div class="customize-choice-cut">
                                                            <?php
                                                            $title = $translator->translateStation("US23");
                                                            $labels = $product->getCutsValueToValue();
                                                            $datas = [
                                                                "title" => $title,
                                                                "checkedLabels" => [],
                                                                "labels" => $labels,
                                                                "isRadio" => true,
                                                                "inputName" => Size::CUT
                                                            ];
                                                            echo $this->generateFile("view/elements/dropdown.php", $datas);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        switch ($product->getType()):
                            case BoxProduct::BOX_TYPE:
                                $buttonTxt = $translator->translateStation("US24");
                        ?>
                                <div class="add-button-container product-data-line">
                                    <button id="add_to_box" class="green-button remove-button-default-att"><?= $buttonTxt ?></button>
                                </div>
                            <?php
                                break;
                            case BasketProduct::BASKET_TYPE:
                                $buttonTxt = $translator->translateStation("US25");
                            ?>
                                <div class="add-button-container product-data-line">
                                    <button id="add_to_cart" class="green-button remove-button-default-att"><?= $buttonTxt ?></button>
                                </div>
                        <?php
                                break;
                        endswitch;
                        ?>
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
        foreach($sliderProducts as $index => $product){
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
    <div class="full_screen-block">
        <div class="size_customizer-block">
            <div class="product-size-customize-block">
                <div id="customize_brand_reference" class="customize-brand_reference-block">
                    <?php
                    $datas = ["brandsMeasures" => $brandsMeasures];
                    echo $this->generateFile("view/elements/popupBrand.php", $datas);
                    ?>
                </div>
                <div id="customize_measure" class="customize_measure-block">
                    <?php
                    $datas = [
                        "measures" => $measures,
                        "measureUnits" => $measureUnits
                    ];
                    echo $this->generateFile("view/elements/popupMeasureManager.php", $datas);
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>