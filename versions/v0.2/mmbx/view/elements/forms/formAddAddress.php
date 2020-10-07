<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Country $country User's current Country
 * @param string $conf to configure the behavior when the add of the new address succed
 * + Address::CONF_ADRS_POP
 * + Address::CONF_ADRS_FEED
 */
?>

<div class="form-wrap">
    <div class="form-title-block address-title-block">
        <div class="form-title-div">
            <span class="form-title">add new shipping address</span>
        </div>
    </div>
    <hr class="hr-summary">
    <div class="form-wrap-inner address-wrap-inner">
        <?php
        $formid  = ModelFunctionality::generateDateCode(25);
        $formx  = "#$formid";
        $sbtnid = ModelFunctionality::generateDateCode(25);
        $sbtnx = "#$sbtnid";
        ?>
        <div id="<?= $formid ?>" class="address-form-tag">
            <div class="form-input-block form-double-input-block">
                <div class="form-input-container">
                    <?php
                    $datas = [
                        "inpId" => ModelFunctionality::generateDateCode(25),
                        "inpType" => Map::text,
                        "inpName" => Address::INPUT_ADDRESS,
                        "inpTxt" => "address",
                        "errortype" => self::ER_TYPE_COMMENT,
                    ];
                    echo $this->generateFile('view/elements/inputs/input.php', $datas);
                    ?>
                </div>
                <div class="form-input-container">
                    <?php
                    $datas = [
                        "inpId" => ModelFunctionality::generateDateCode(25),
                        "inpType" => Map::text,
                        "inpName" => Address::INPUT_APPARTEMENT,
                        "inpTxt" => "apartment, suite, etc. (optional)",
                        "errortype" => self::ER_TYPE_COMMENT,
                    ];
                    echo $this->generateFile('view/elements/inputs/input.php', $datas);
                    ?>
                </div>
            </div>
            <div class="form-input-block form-double-input-block">
                <div class="form-input-container">
                    <?php
                    $datas = [
                        "inpId" => ModelFunctionality::generateDateCode(25),
                        "inpType" => Map::text,
                        "inpName" => Address::INPUT_PROVINCE,
                        "inpTxt" => "state, province, region etc...",
                        "errortype" => self::ER_TYPE_COMMENT,
                    ];
                    echo $this->generateFile('view/elements/inputs/input.php', $datas);
                    ?>
                </div>
                <div class="form-input-container">
                    <?php
                    $datas = [
                        "inpId" => ModelFunctionality::generateDateCode(25),
                        "inpType" => Map::text,
                        "inpName" => Address::INPUT_CITY,
                        "inpTxt" => "city",
                        "errortype" => self::ER_TYPE_COMMENT,
                    ];
                    echo $this->generateFile('view/elements/inputs/input.php', $datas);
                    ?>
                </div>
            </div>
            <div class="form-input-block form-double-input-block">
                <div class="form-input-container">
                    <div class="form-input-dropdown-container">
                        <?php
                        $countriesMap = Country::getCountries();
                        $isoCountries = $countriesMap->getKeys();
                        $inputMap = new Map();
                        foreach ($isoCountries as $isoCountry) {
                            $label = $countriesMap->get($isoCountry, Map::countryName);
                            if ($label != $country->getCountryNameDefault()) {
                                $isChecked = ($country->getIsoCountry() == $isoCountry);
                                $inputMap->put(Country::INPUT_ISO_COUNTRY, $label, Map::inputName);
                                $inputMap->put($isoCountry, $label, Map::inputValue);
                                $inputMap->put($isChecked, $label, Map::isChecked);
                                $inputMap->put(null, $label, Map::inputFunc);
                            }
                        }
                        $datas = [
                            "title" => $translator->translateStation("US65"),
                            "inputMap" => $inputMap,
                            "func" => null,
                            "isRadio" => true,
                            "isDisplayed" => false
                        ];
                        echo $this->generateFile('view/elements/dropdown/dropdown2.php', $datas);
                        ?>
                        <p class="comment"></p>
                    </div>
                </div>
                <div class="form-input-container">
                    <?php
                    $datas = [
                        "inpId" => ModelFunctionality::generateDateCode(25),
                        "inpType" => Map::text,
                        "inpName" => Address::INPUT_ZIPCODE,
                        "inpTxt" => "postal code",
                        "errortype" => self::ER_TYPE_COMMENT,
                    ];
                    echo $this->generateFile('view/elements/inputs/input.php', $datas);
                    ?>
                </div>
            </div>
            <div class="form-input-block form-simple-input-block">
                <div class="form-input-container">
                    <?php
                    $datas = [
                        "inpId" => ModelFunctionality::generateDateCode(25),
                        "inpType" => Map::tel,
                        "inpName" => Address::INPUT_PHONE,
                        "inpTxt" => "phone (optional)",
                        "errortype" => self::ER_TYPE_COMMENT,
                    ];
                    echo $this->generateFile('view/elements/inputs/input.php', $datas);
                    ?>
                </div>
            </div>
            <div class="form-submit-button-div">
                <button id="<?= $sbtnid ?>" class="blue-button standard-button remove-button-default-att" onclick="addAddress('<?= $formx ?>','<?= $sbtnx ?>', '<?= $conf ?>')"><?= $translator->translateStation("US37") ?></button>
            </div>
        </div>
        <div id="address_form_loading" class="loading-img-wrap">
            <img src="<?= self::$DIR_STATIC_FILES ?>loading.gif">
        </div>
    </div>
</div>