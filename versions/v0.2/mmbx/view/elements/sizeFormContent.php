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
$TagComment = "<p class='comment'></p>";

$quantityMinipop = new MiniPopUp(self::DIRECTION_BOTTOM, $TagComment);
$quantityMinipopID = $quantityMinipop->getId();

$alphaNumMinipop = new MiniPopUp(self::DIRECTION_TOP, $TagComment);
$alphaNumMinipopID = $alphaNumMinipop->getId();

$measureMinipop = new MiniPopUp(self::DIRECTION_TOP, $TagComment);
$measureMinipopID = $measureMinipop->getId();

$submitBtnID = ModelFunctionality::generateDateCode(25);
$dataError = " data-errorx='#$submitBtnID' data-errortype='" . self::ER_TYPE_COMMENT . "'";

// $typeRadioEvent = "onclick=\"evtInp(this, 'evt_cd_73')\"";
// $typeCheckBoxEvent = "onclick=\"evtCheck(this, 'evt_cd_73')\"";
// $typeInputEvent = "onblur=\"evtInp(this, 'evt_cd_43')\"";

switch ($conf) {
    case Size::CONF_SIZE_ADD_PROD:
        /** Event */
        $typeRadioEvent = "evtInp(this, 'evt_cd_75')";
        $typeCheckBoxEvent = "evtCheck(this, 'evt_cd_75')";

        $selectedSize = null;
        $sizeIsChecked = false;
        $measureIsChecked = false;
        $TagdisplayBrand = null;
        break;
    case Size::CONF_SIZE_EDITOR:
        /** Event */
        $typeRadioEvent = "evtInp(this, 'evt_cd_73')";
        $typeCheckBoxEvent = "evtCheck(this, 'evt_cd_73')";
        $typeInputEvent = "evtInp(this, 'evt_cd_74')";

        $selectedSize = $product->getSelectedSize();
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
    <div class="size_form_common_inner">
        <input type="hidden" name="<?= Product::INPUT_PROD_ID ?>" value="<?= $prodID ?>">
        <div class="product-size-container product-data-line">
            <div class="product-size-inner">
                <?php
                if ($conf == Size::CONF_SIZE_EDITOR) :
                    $qid = ModelFunctionality::generateDateCode(25);
                    $qidx = "#" . $qid;
                    $quantity = $product->getQuantity();
                    if (!empty($box)) : ?>
                        <input type="hidden" name="<?= Box::KEY_BOX_ID ?>" value="<?= $box->getBoxID() ?>">
                    <?php
                    endif; ?>
                    <input type="hidden" name="<?= Size::KEY_SEQUENCE ?>" value="<?= $selectedSize->getSequence() ?>">
                    <div class="product-quantity-container">
                        <div class="input-wrap">
                            <label class="input-label" for="<?= $qid ?>"><?= $translator->translateStation("US54") ?></label>
                            <input id="<?= $qid ?>" onblur="<?= $typeInputEvent ?>" data-errorx="#<?= $quantityMinipopID ?>" data-errortype="<?= self::ER_TYPE_MINIPOP ?>" class="input-tag" onchange="updateNumberInputValue('<?= $qidx ?>')" type="number" name="<?= Size::INPUT_QUANTITY ?>" value="<?= $quantity ?>" placeholder="<?= $translator->translateStation("US54") ?>">
                        </div>
                        <?= $quantityMinipop ?>
                    </div>
                <?php
                endif; ?>
                <div class="product-size-dropdown-container">
                    <?php
                    /* ——————————————————————————————— SIZE CHAR & BRAND —————————————————————————————————————*/
                    switch ($conf) {
                        case Size::CONF_SIZE_ADD_PROD:
                            $checkedSizes = [];
                            break;
                        case Size::CONF_SIZE_EDITOR:
                            $checkedSizes = ($sizeType == Size::SIZE_TYPE_ALPHANUM) ? [$selectedSize->getsize()] : [];
                            break;
                    }
                    echo $alphaNumMinipop;
                    ob_start();
                    ?>
                    <div class="size-set-container">
                        <?php
                        $brandCtnId = ModelFunctionality::generateDateCode(25);
                        $TagParams = " data-errorx='#$alphaNumMinipopID' data-errortype='" . self::ER_TYPE_MINIPOP . "'";
                        $title = null;
                        $inputMap = new Map();
                        $sizes = $product->getSizes();
                        foreach ($sizes as $size) {
                            $label = $size;
                            $isChecked = in_array($size, $checkedSizes);
                            $SizeInpAttribut = "onclick=\"$typeRadioEvent;$('#$brandCtnId').slideDown(TS);\"" . $TagParams;
                            $inputMap->put(Size::INPUT_ALPHANUM_SIZE, $label, Map::inputName);
                            $inputMap->put($size, $label, Map::inputValue);
                            $inputMap->put($isChecked, $label, Map::isChecked);
                            $inputMap->put($SizeInpAttribut, $label, Map::attribut);
                        }
                        $isRadio = true;
                        $isDisplayed = true;
                        $eventMap = new Map();
                        $alphanumDropdown = new DropDown($title, $inputMap, $isRadio, $isDisplayed, $eventMap);
                        echo $alphanumDropdown->getInputs();
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
                                    $setBrandPopFunc = "onclick=\"evt('evt_cd_87');openPopUp('#customize_brand_reference',setSelectBrandItemPage)\"";
                                    break;
                                case Size::CONF_SIZE_EDITOR:
                                    $setBrandPopFunc = "setSelectBrandSizeEditor";
                                    $setBrandPopFunc = "onclick=\"evt('evt_cd_86');switchPopUp('#size_editor_pop','#customize_brand_reference',setSelectBrandSizeEditor)\"";
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
                    $dataAttributs = "data-x='product-size-customize-block'" . $dataError;
                    $datas = [
                        "title" => $title,
                        "titleId" => $titleId,
                        "inputName" => Size::INPUT_SIZE_TYPE,
                        "inputValue" => Size::SIZE_TYPE_ALPHANUM,
                        "dataAttributs" => $dataAttributs,
                        "isRadio" => true,
                        "content" => $content,
                        "checked" => $sizeIsChecked,
                        "onclick" => $typeRadioEvent
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
                                    <?php
                                    echo $measureMinipop;
                                    $TagInput = "data-errorx='#$measureMinipopID' data-errortype='" . self::ER_TYPE_MINIPOP . "'";
                                    ?>
                                    <div name="<?= Measure::KEY_MEASURE_ID ?>" <?= $TagInput ?>></div>
                                    <div class="custom_selected-container">
                                        <?php
                                        if (!empty($measure)) :
                                            $datas = [
                                                "measure" => $measure,
                                                "TagInput" => $TagInput
                                            ];
                                            echo $this->generateFile('view/Item/itemFiles/stickerMeasure.php', $datas);
                                        else : ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                    switch ($conf) {
                                        case Size::CONF_SIZE_ADD_PROD:
                                            $addMeasureBtnFunc = "onclick=\"evt('evt_cd_100');openPopUp('#measure_adder')\"";
                                            $manageMeasureBtnFunc = "onclick=\"evt('evt_cd_93');openPopUp('#measure_manager',setSelectMeasureItemPage)\"";
                                            break;
                                        case Size::CONF_SIZE_EDITOR:
                                            $addMeasureBtnFunc = "onclick=\"evt('evt_cd_99');switchPopUp('#size_editor_pop','#measure_adder')\"";
                                            $manageMeasureBtnFunc = "onclick=\"evt('evt_cd_92');switchPopUp('#size_editor_pop','#measure_manager',setSelectMeasureSizeEditor)\"";
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
                                $cutDpdEventMap = new Map();
                                switch ($conf) {
                                    case Size::CONF_SIZE_ADD_PROD:
                                        $checkedCuts = [Size::DEFAULT_CUT];
                                        $cutInputName = Size::INPUT_CUT_ADDER;
                                        $cutDpdEventMap->put("evt_cd_78", Map::open);
                                        $cutDpdEventMap->put("evt_cd_79", Map::close);
                                        break;
                                    case Size::CONF_SIZE_EDITOR:
                                        $checkedCuts = ($sizeType == Size::SIZE_TYPE_MEASURE) ? [$selectedSize->getCut()] : [Size::DEFAULT_CUT];
                                        $cutInputName = Size::INPUT_CUT_EDITOR;
                                        $cutDpdEventMap->put("evt_cd_76", Map::open);
                                        $cutDpdEventMap->put("evt_cd_77", Map::close);
                                        break;
                                }
                                $title = $translator->translateStation("US23");
                                $inputMap = new Map();
                                $cuts = Size::getSupportedCuts();
                                foreach ($cuts as $cut) {
                                    $label = $cut;
                                    $isChecked = in_array($cut, $checkedCuts);
                                    $SizeInpAttribut = "onclick=\"$typeRadioEvent;\"";
                                    $inputMap->put($cutInputName, $label, Map::inputName);
                                    $inputMap->put($cut, $label, Map::inputValue);
                                    $inputMap->put($isChecked, $label, Map::isChecked);
                                    $inputMap->put($SizeInpAttribut, $label, Map::attribut);
                                }
                                $isRadio = true;
                                $isDisplayed = $measureIsChecked;
                                $cutDropdown = new DropDown($title, $inputMap, $isRadio, $isDisplayed, $cutDpdEventMap);
                                ?>
                                <?= $cutDropdown ?>
                            </div>
                        </div>
                        <?php
                        $content = ob_get_clean();
                        $titleId = "customize_size";
                        $title = $translator->translateStation("US17");
                        $dataAttributs = "data-x='product-size-dropdown-container'" . $dataError;
                        $datas = [
                            "title" => $title,
                            "titleId" => $titleId,
                            "inputName" => Size::INPUT_SIZE_TYPE,
                            "inputValue" => Size::SIZE_TYPE_MEASURE,
                            "dataAttributs" => $dataAttributs,
                            "isRadio" => true,
                            "content" => $content,
                            "checked" => $measureIsChecked,
                            "onclick" => $typeRadioEvent
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
                        <p id="<?= $submitBtnID ?>" class="comment"></p>
                    </div>
                <?php break;
                case BasketProduct::BASKET_TYPE:
                    $buttonTxt = $translator->translateStation("US24"); ?>
                    <div class="add-button-container product-data-line">
                        <button id="select_size_for_cart" class="green-button standard-button remove-button-default-att"><?= $buttonTxt ?></button>
                        <div id="add_prod_loading" class="btn-loading loading-img-wrap">
                            <img src="<?= self::$DIR_STATIC_FILES ?>mini-loading.gif">
                        </div>
                        <p id="<?= $submitBtnID ?>" class="comment"></p>
                    </div>
            <?php break;
            endswitch;
        elseif ($conf == Size::CONF_SIZE_EDITOR) : ?>
            <p id="<?= $submitBtnID ?>" class="comment"></p>
        <?php endif; ?>
    </div>
</div>