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
                    <div id="add_prod_form" class="product-datas-block">
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
                                    /* ——————————————————————————————— SIZE CHAR & BRAND —————————————————————————————————————*/
                                    ob_start();
                                    ?>
                                    <div class="size-set-container">
                                        <?php
                                        $title = $translator->translateStation("US9");
                                        $labels = $product->getSizeValueToValue();
                                        $datas = [
                                            "title" => $title,
                                            "checkedLabels" => [],
                                            "labels" => $labels,
                                            "isRadio" => true,
                                            "inputName" => Size::INPUT_ALPHANUM_SIZE,
                                        ];
                                        echo $this->generateFile("view/elements/dropdownInput.php", $datas);
                                        ?>
                                    </div>
                                    <div class="brand-custom-container">
                                        <hr class="hr-summary">
                                        <div id="choose_brand" class="customize_choice-button-container">
                                            <p><?= $translator->translateStation("US18") ?></p>
                                            <div class="custom_selected-container"></div>
                                            <button id="choose_brand_button" class="green-button standard-button remove-button-default-att" onclick="openPopUp('#customize_brand_reference')"><?= $translator->translateStation("US20") ?></button>
                                        </div>
                                    </div>
                                    <?php
                                    $content = ob_get_clean();
                                    $titleId = "char_size";
                                    $title = $translator->translateStation("US9");
                                    $dataAttributs = "data-x='product-size-customize-block'";
                                    // $content = "mycontent";
                                    $datas = [
                                        "title" => $title,
                                        "titleId" => $titleId,
                                        "inputName" => Size::INPUT_SIZE_TYPE,
                                        "inputValue" => Size::INPUT_SIZE_TYPE_VALUE_ALPHANUM,
                                        "dataAttributs" => $dataAttributs,
                                        "isRadio" => true,
                                        "content" => $content
                                    ];
                                    echo $this->generateFile("view/elements/dropdownCheckbox.php", $datas);
                                    ?>
                                </div>
                                <div class="product-size-customize-container">
                                    <div class="product-size-customize-block">
                                        <?php
                                        /* ——————————————————————————————— MEASUREMENT —————————————————————————————————————*/
                                        ob_start() ?>
                                        <div class="customize_choice-block">
                                            <div class="customize_choice-measure-block">
                                                <div class="dropdown-checkbox-block">
                                                    <p><?= $translator->translateStation("US19") ?></p>
                                                </div>
                                            </div>
                                            <hr class="hr-summary">
                                            <div class="customize_choice-button-block">
                                                <?php


                                                ?>
                                                <div id="measurement_button_div" class="customize_choice-button-container">
                                                    <div class="custom_selected-container"></div>
                                                    <?php
                                                    $addMsrBtnTxt = $translator->translateStation("US21");
                                                    $managerBtnTxt = $translator->translateStation("US22");
                                                    if (count($measures) > 0) :
                                                    ?>
                                                        <button id="add_measurement_button" style="display:none;" class="green-button standard-button remove-button-default-att" onclick="openPopUp('#measure_adder')"><?= $addMsrBtnTxt ?></button>
                                                        <button id="manage_measurement_button" class="green-button standard-button remove-button-default-att" onclick="openPopUp('#measure_manager')"><?= $managerBtnTxt ?></button>
                                                    <?php
                                                    else : ?>
                                                        <button id="add_measurement_button" class="green-button standard-button remove-button-default-att" onclick="openPopUp('#measure_adder')"><?= $addMsrBtnTxt ?></button>
                                                        <button id="manage_measurement_button" style="display:none;" class="green-button standard-button remove-button-default-att" onclick="openPopUp('#measure_manager')"><?= $managerBtnTxt ?></button>
                                                    <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="customize_choice-block">
                                            <div class="customize-choice-cut">
                                                <?php
                                                $title = $translator->translateStation("US23");
                                                $labels = $product->getCutsValueToValue();
                                                $datas = [
                                                    "title" => $title,
                                                    "checkedLabels" => [Size::DEFAULT_CUT],
                                                    "labels" => $labels,
                                                    "isRadio" => true,
                                                    "inputName" => Size::INPUT_CUT
                                                ];
                                                echo $this->generateFile("view/elements/dropdown.php", $datas);
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        $content = ob_get_clean();
                                        $titleId = "customize_size";
                                        $title = $translator->translateStation("US17");
                                        $dataAttributs = "data-x='product-size-dropdown-container'";
                                        $datas = [
                                            "title" => $title,
                                            "titleId" => $titleId,
                                            "inputName" => Size::INPUT_SIZE_TYPE,
                                            "inputValue" => Size::INPUT_SIZE_TYPE_VALUE_MEASURE,
                                            "dataAttributs" => $dataAttributs,
                                            "isRadio" => true,
                                            "content" => $content
                                        ];
                                        echo $this->generateFile("view/elements/dropdownCheckbox.php", $datas);
                                        ?>
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
                                    <button id="select_size_for_box" class="green-button standard-button remove-button-default-att" onclick="checkBoxProductStock('#add_prod_form')"><?= $buttonTxt ?></button>
                                    <div id="add_prod_loading" class="btn-loading loading-img-wrap">
                                        <img src="content/brain/permanent/mini-loading.gif">
                                    </div>
                                </div>
                            <?php
                                break;
                            case BasketProduct::BASKET_TYPE:
                                $buttonTxt = $translator->translateStation("US25");
                            ?>
                                <div class="add-button-container product-data-line">
                                    <button id="select_size_for_cart" class="green-button standard-button remove-button-default-att"><?= $buttonTxt ?></button>
                                    <div id="add_prod_loading" class="btn-loading loading-img-wrap">
                                        <img src="content/brain/permanent/mini-loading.gif">
                                    </div>
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
        <div id="basket_pop" class="pricing-container pop_up-container">
            <?php
            $datas = [
                "basket" => $basket,
                "country" => $country,
                "currency" => $currency
            ];
            echo $this->generateFile('view/elements/popupBasket.php', $datas);
            ?>
        </div>
    </div>
</div>