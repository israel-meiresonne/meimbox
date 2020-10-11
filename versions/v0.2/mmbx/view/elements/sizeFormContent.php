<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $formId id of the forrmular
 * @param Box|null $box box that contain the boxproduct
 * @param BoxProduct|BasketProduct $product Visitor's basket
 * @param int $nbMeasure the number of measure holds by Visitor
 * @param string $conf configuation to determinate the layout
 */

/**
 * @var BoxProduct|BasketProduct
 */
$product = $product;

/**
 * @var Translator
 */
$translator = $translator;

$prodID = $product->getProdID();

// /**
//  * @var Box
//  */
// $box = $box;

switch ($conf) {
    case Size::CONF_SIZE_ADD_PROD:
        $selectedSize = null;
        $sizeIsChecked = false;
        $measureIsChecked = false;
        $TagdisplayBrand = null;
        break;
    case Size::CONF_SIZE_EDITOR:
        $selectedSize = $product->getSelectedSize();
        // $selectedSize = new Size("null-null-0jj2g3rj131923p1560b90d01-fit", "2020-09-17 20:57:22");
        $sizeType = $selectedSize->getType();
        $brandName = $selectedSize->getbrandName();
        $measure = $selectedSize->getmeasure();
        switch ($sizeType) {
            case Size::SIZE_TYPE_ALPHANUM:
                $sizeIsChecked = true;
                $measureIsChecked = false;
                $TagdisplayBrand = (!empty($brandName)) ? 'style="display:block;"' : null;
                break;
            case Size::SIZE_TYPE_MEASURE:
                $sizeIsChecked = false;
                $measureIsChecked = true;
                $TagdisplayBrand = null;
                break;
        }
        break;
}

?>
<div id="<?= $formId ?>">
    <input type="hidden" name="<?= Product::INPUT_PROD_ID ?>" value="<?= $prodID ?>">
    <div class="product-size-container product-data-line">
        <div class="product-size-inner">
            <?php
            if ($conf == Size::CONF_SIZE_EDITOR) :
                $qid = ModelFunctionality::generateDateCode(25);
                $qidx = "#" . $qid;
                $quantity = $product->getQuantity();
                if (!empty($box)) :
            ?>
                    <input type="hidden" name="<?= Box::KEY_BOX_ID ?>" value="<?= $box->getBoxID() ?>">
                <?php
                endif; ?>
                <input type="hidden" name="<?= Size::KEY_SEQUENCE ?>" value="<?= $selectedSize->getSequence() ?>">
                <div class="product-quantity-container">
                    <div class="input-wrap">
                        <label class="input-label" for="<?= $qid ?>"><?= $translator->translateStation("US54") ?></label>
                        <input id="<?= $qid ?>" class="input-tag" onchange="updateNumberInputValue('<?= $qidx ?>')" type="number" name="<?= Size::INPUT_QUANTITY ?>" value="<?= $quantity ?>" placeholder="<?= $translator->translateStation("US54") ?>">
                    </div>
                </div>
            <?php
            endif; ?>
            <div class="product-size-dropdown-container">
                <?php
                /* ——————————————————————————————— SIZE CHAR & BRAND —————————————————————————————————————*/
                switch ($conf) {
                    case Size::CONF_SIZE_ADD_PROD:
                        $checkedLabels = [];
                        break;
                    case Size::CONF_SIZE_EDITOR:
                        $checkedLabels = ($sizeType == Size::SIZE_TYPE_ALPHANUM) ? [$selectedSize->getsize()] : [];
                        break;
                }
                ob_start();
                ?>
                <div class="size-set-container">
                    <?php
                    $brandCtnId = ModelFunctionality::generateDateCode(25);
                    $title = $translator->translateStation("US9");
                    $sizes = $product->getSizes();
                    $labels = array_combine($sizes, $sizes);
                    $datas = [
                        "title" => $title,
                        // "checkedLabels" => [],
                        "checkedLabels" => $checkedLabels,
                        "labels" => $labels,
                        "isRadio" => true,
                        "inputName" => Size::INPUT_ALPHANUM_SIZE,
                        "func" => "$('#". $brandCtnId ."').slideDown(TS);"
                    ];
                    echo $this->generateFile("view/elements/dropdownInput.php", $datas);
                    ?>
                </div>
                <div id="<?= $brandCtnId ?>" class="brand-custom-container" <?= $TagdisplayBrand ?>>
                    <hr class="hr-summary">
                    <div id="choose_brand" class="customize_choice-button-container">
                        <p><?= $translator->translateStation("US18") ?></p>
                        <div class="custom_selected-container">
                            <?php
                            if (!empty($brandName)) {
                                $datas = [
                                    "brandName" => $brandName
                                ];
                                echo $this->generateFile('view/Item/itemFiles/stickerBrand.php', $datas);
                            }
                            ?>
                        </div>
                        <?php
                        switch ($conf) {
                            case Size::CONF_SIZE_ADD_PROD:
                                $setBrandPopFunc = "onclick=\"openPopUp('#customize_brand_reference',setSelectBrandItemPage)\"";
                                break;
                            case Size::CONF_SIZE_EDITOR:
                                $setBrandPopFunc = "setSelectBrandSizeEditor";
                                $setBrandPopFunc = "onclick=\"switchPopUp('#size_editor_pop','#customize_brand_reference',setSelectBrandSizeEditor)\"";
                                break;
                        }
                        ?>
                        <button class="choose-brand-button green-button standard-button remove-button-default-att" <?= $setBrandPopFunc ?>><?= $translator->translateStation("US20") ?></button>
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
                    "content" => $content,
                    "checked" => $sizeIsChecked
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
                                <div class="custom_selected-container">
                                    <?php
                                    if (!empty($measure)) {
                                        $datas = [
                                            "measure" => $measure
                                        ];
                                        echo $this->generateFile('view/Item/itemFiles/stickerMeasure.php', $datas);
                                    }
                                    ?>
                                </div>
                                <?php
                                switch ($conf) {
                                    case Size::CONF_SIZE_ADD_PROD:
                                        $addMeasureBtnFunc = "onclick=\"openPopUp('#measure_adder')\"";
                                        $manageMeasureBtnFunc = "onclick=\"openPopUp('#measure_manager',setSelectMeasureItemPage)\"";
                                        break;
                                    case Size::CONF_SIZE_EDITOR:
                                        $addMeasureBtnFunc = "onclick=\"switchPopUp('#size_editor_pop','#measure_adder')\"";
                                        $manageMeasureBtnFunc = "onclick=\"switchPopUp('#size_editor_pop','#measure_manager',setSelectMeasureSizeEditor)\"";
                                        break;
                                }
                                $addMsrBtnTxt = $translator->translateStation("US21");
                                $managerBtnTxt = $translator->translateStation("US22");

                                if ($nbMeasure > 0) {
                                    $displayNoMeasure = 'style="display:none;"';
                                    $displayMeasureEditor = null;
                                } else {
                                    $displayNoMeasure = null;
                                    $displayMeasureEditor = 'style="display:none;"';
                                } ?>
                                <button id="add_measurement_button" <?= $displayNoMeasure ?> class="green-button standard-button remove-button-default-att" <?= $addMeasureBtnFunc ?>><?= $addMsrBtnTxt ?></button>
                                <button id="manage_measurement_button" <?= $displayMeasureEditor ?> class="green-button standard-button remove-button-default-att" <?= $manageMeasureBtnFunc ?>><?= $managerBtnTxt ?></button>
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
                                    $checkedLabels = ($sizeType == Size::SIZE_TYPE_MEASURE) ? [$selectedSize->getCut()] : [Size::DEFAULT_CUT];
                                    break;
                            }
                            $datas = [
                                "title" => $title,
                                // "checkedLabels" => [Size::DEFAULT_CUT],
                                "checkedLabels" => $checkedLabels,
                                "labels" => $labels,
                                "isRadio" => true,
                                "inputName" => Size::INPUT_CUT,
                                "isDisplayed" => $measureIsChecked,
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
                        "inputValue" => Size::SIZE_TYPE_MEASURE,
                        "dataAttributs" => $dataAttributs,
                        "isRadio" => true,
                        "content" => $content,
                        "checked" => $measureIsChecked
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
                        <img src="<?= self::$DIR_STATIC_FILES ?>mini-loading.gif">
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
                        <img src="<?= self::$DIR_STATIC_FILES ?>mini-loading.gif">
                    </div>
                </div>
    <?php
                break;
        endswitch;
    endif ?>
</div>