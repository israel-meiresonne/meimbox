<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $formId id of the forrmular
 * @param BoxProduct|BasketProduct $product Visitor's basket
 * @param int $nbMeasure the number of measure holds by Visitor
 * @param string $conf configuation to determinate the layout
 */

/**
 * @var BoxProduct|BasketProduct
 */
$product = $product;
$prodID = $product->getProdID();
// $measures
?>
<div id="<?= $formId ?>">
    <input type="hidden" name="<?= Product::INPUT_PROD_ID ?>" value="<?= $prodID ?>">
    <div class="product-size-container product-data-line">
        <div class="product-size-inner">
            <?php
            if ($conf == Size::CONF_SIZE_EDITOR) : ?>
                <div class="product-quantity-container">
                    <div class="input-wrap">
                        <label class="input-label" for="filter_minPrice">quantity</label>
                        <input id="filter_minPrice" class="input-tag" type="number" name="quantity" value="5" placeholder="quantity">
                    </div>
                </div>
            <?php
            endif; ?>
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
                    "inputValue" => Size::SIZE_TYPE_ALPHANUM,
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
                            <div id="measurement_button_div" class="customize_choice-button-container">
                                <div class="custom_selected-container"></div>
                                <?php
                                $addMsrBtnTxt = $translator->translateStation("US21");
                                $managerBtnTxt = $translator->translateStation("US22");
                                // if (count($measures) > 0) :
                                if ($nbMeasure > 0) :
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
                            switch ($conf) {
                                case Size::CONF_SIZE_ADD_PROD:
                                    $checkedLabels = [Size::DEFAULT_CUT];
                                    break;
                                case Size::CONF_SIZE_EDITOR:
                                    $checkedLabels = [];
                                    break;
                            }
                            $datas = [
                                "title" => $title,
                                // "checkedLabels" => [Size::DEFAULT_CUT],
                                "checkedLabels" => $checkedLabels,
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
                        "inputValue" => Size::SIZE_TYPE_VALUE_MEASURE,
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
    if ($conf == Size::CONF_SIZE_ADD_PROD) :
        switch ($product->getType()):
            case BoxProduct::BOX_TYPE:
                $buttonTxt = $translator->translateStation("US24"); ?>
                <div class="add-button-container product-data-line">
                    <button id="select_size_for_box" class="green-button standard-button remove-button-default-att" onclick="checkBoxProductStock('#form_check_prod_stock')"><?= $buttonTxt ?></button>
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
    endif ?>
</div>