<?php

/**
 * @var Translator
 */
$translator = $translator;

/**
 * @var Search
 */
$search = $search;

/**
 * @var Visitor|Client|Administrator
 */
$person = $person;

/*————————————————————————————— Config View DOWN ————————————————————————————*/
$this->title = $translator->translateStation("US120");
$this->lang = $person->getLanguage()->getIsoLang();
$this->description = "grid page";
$this->head = $this->generateFile('view/Grid/gridFiles/head.php', []);
/*————————————————————————————— Config View UP ——————————————————————————————*/

/** Event */
$inpEvent = "evtInp(this,'evt_cd_125');";
?>
<div class="grid-container">
    <div id="ctr_grid_content">
        <div class="grid-inner">
            <div class="filter-block-mobile">
                <div id="filter_button" data-evtopen="evt_cd_113" data-evtclose="evt_cd_114" class="filter-button-block">
                    <div class="img-text-block">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>icons8-setting-80.png">
                            </div>
                            <span class="img-text-span"><?= $translator->translateStation("US1") ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="directory-wrap">
                <!-- <p>women \ collection \ category</p> -->
                <!-- <p>women \ collection1 \ collection2 \ category</p> -->
            </div>

            <div class="search-sticker-block">
                <div class="sticker-empty-div filter-block"></div>
                <div class="search-sticker-div">
                    <div class="sticker-set">
                        <?php
                        $stickers = $search->getStickers($translator);
                        ob_start();
                        require 'view/Grid/gridFiles/gridSticker.php';
                        echo ob_get_clean();
                        ?>
                    </div>
                </div>
            </div>
            <div class="grid-item-container">
                <div id="filter_block" class="filter-block back_blur">
                    <p><?= $translator->translateStation("US1") ?></p>
                    <from id="grid_filter">
                        <?php
                        $orderIsChecked[0] = Query::getParam("order") == Search::NEWEST ? 'checked="true"' : "";
                        $orderIsChecked[1] = Query::getParam("order") == Search::OLDER ? 'checked="true"' : "";
                        $orderIsChecked[2] = Query::getParam("order") == Search::HIGHT_TO_LOW ? 'checked="true"' : "";
                        $orderIsChecked[3] = Query::getParam("order") == Search::LOW_TO_HIGHT ? 'checked="true"' : "";

                        $head = ModelFunctionality::generateDateCode(25);
                        $headx = "#" . $head;
                        $body = ModelFunctionality::generateDateCode(25);
                        $bodyx = "#" . $body;
                        ?>
                        <div class="filter-dropdown-set">
                            <div class="filter-dropdown-inner">
                                <div class="dropdown-container">
                                    <div class="dropdown-wrap">
                                        <div class="dropdown-inner">
                                            <div id="<?= $head ?>" class="dropdown-head dropdown-arrow-close" data-evtopen="evt_cd_115" data-evtclose="evt_cd_116" onclick="animateDropdown('<?= $headx ?>', '<?= $bodyx ?>');">
                                                <span class="dropdown-title"><?= $translator->translateStation("US2") ?></span>
                                            </div>
                                            <div id="<?= $body ?>" class="dropdown-checkbox-list">
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US3") ?>
                                                        <input onclick="<?= $inpEvent ?>" type="radio" name="order" value="<?= Search::NEWEST ?>" <?= $orderIsChecked[0] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US4") ?>
                                                        <input onclick="<?= $inpEvent ?>" type="radio" name="order" value="<?= Search::OLDER ?>" <?= $orderIsChecked[1] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <?php
                                                /*
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US6") ?>
                                                        <input onclick="<?= $inpEvent ?>" type="radio" name="order" value="<?= Search::LOW_TO_HIGHT ?>" <?= $orderIsChecked[2] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US5") ?>
                                                        <input onclick="<?= $inpEvent ?>" type="radio" name="order" value="<?= Search::HIGHT_TO_LOW ?>" <?= $orderIsChecked[3] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                */
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                /*
                                <div class="dropdown-container">
                                    <?php
                                    // $title = $translator->translateStation("US7"); // $dpdName
                                    // $tabNames = ["product_types", "functions"];
                                    $tabNames = ["functions"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]
                                    $dpdAttr = "data-evtopen=\"evt_cd_117\" data-evtclose=\"evt_cd_118\"";
                                    $datas = [
                                        "title" => $translator->translateStation("US7"),
                                        "checkedLabels" => $checkedLabels,
                                        "labels" => $labels,
                                        "isRadio" => false,
                                        "inputName" => null,
                                        "dpdAttr" => $dpdAttr,
                                        // "TagParams" => $TagParams,
                                        "func" => $inpEvent
                                    ];
                                    echo $this->generateFile('view/elements/dropdown.php', $datas);
                                    ?>
                                </div>
                                */
                                ?>
                                <div class="dropdown-container">
                                    <?php
                                    // $title = $translator->translateStation("US8"); // $dpdName
                                    $tabNames = ["categories"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]

                                    $dpdAttr = "data-evtopen=\"evt_cd_119\" data-evtclose=\"evt_cd_120\"";
                                    $datas = [
                                        "title" => $translator->translateStation("US8"),
                                        "checkedLabels" => $checkedLabels,
                                        "labels" => $labels,
                                        "isRadio" => false,
                                        "inputName" => null,
                                        "dpdAttr" => $dpdAttr,
                                        // "TagParams" => $TagParams,
                                        "func" => $inpEvent
                                    ];
                                    echo $this->generateFile('view/elements/dropdown.php', $datas);
                                    ?>
                                </div>
                                <div class="dropdown-container">
                                    <?php
                                    // $title = $translator->translateStation("US9"); // $dpdName
                                    $tabNames = ["sizes"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]

                                    $dpdAttr = "data-evtopen=\"evt_cd_121\" data-evtclose=\"evt_cd_122\"";
                                    $datas = [
                                        "title" => $translator->translateStation("US9"),
                                        "checkedLabels" => $checkedLabels,
                                        "labels" => $labels,
                                        "isRadio" => false,
                                        "inputName" => null,
                                        "dpdAttr" => $dpdAttr,
                                        // "TagParams" => $TagParams,
                                        "func" => $inpEvent
                                    ];
                                    echo $this->generateFile('view/elements/dropdown.php', $datas);
                                    ?>
                                </div>
                                <div class="dropdown-container">
                                    <?php
                                    // $title = $translator->translateStation("US10"); // $dpdName
                                    $tabNames = ["colors"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]
                                    // ob_start();
                                    // require 'view/elements/dropdown.php';
                                    // echo ob_get_clean();

                                    $dpdAttr = "data-evtopen=\"evt_cd_123\" data-evtclose=\"evt_cd_124\"";
                                    $datas = [
                                        "title" => $translator->translateStation("US10"),
                                        "checkedLabels" => $checkedLabels,
                                        "labels" => $labels,
                                        "isRadio" => false,
                                        "inputName" => null,
                                        "dpdAttr" => $dpdAttr,
                                        // "TagParams" => $TagParams,
                                        "func" => $inpEvent
                                    ];
                                    echo $this->generateFile('view/elements/dropdown.php', $datas);

                                    $head = ModelFunctionality::generateDateCode(25);
                                    $headx = "#" . $head;
                                    $body = ModelFunctionality::generateDateCode(25);
                                    $bodyx = "#" . $body;
                                    ?>
                                </div>
                                <?php
                                /*
                                // <div class="dropdown-container">
                                //     <div class="dropdown-wrap">
                                //         <div class="dropdown-inner">
                                //             <div id="<?= $head ?>" class="dropdown-head dropdown-arrow-close" onclick="animateDropdown('<?= $headx ?>', '<?= $bodyx ?>');">
                                //                 <span class="dropdown-title"><?= $translator->translateStation("US11") ?></span>
                                //             </div>
                                //             <div id="<?= $body ?>" class="dropdown-checkbox-list">
                                //                 <div id="min_price_input" class="input-container">
                                //                     <div class="input-wrap">
                                //                         <label class="input-label" for="filter_minPrice"><?= $translator->translateStation("US12") ?></label>
                                //                         <input id="filter_minPrice" class="input-error input-tag" onchange="updateNumberInputValue('#filter_minPrice')" type="number" name="minprice" value="<?= $search->getMinPrice() ?>" placeholder="<?= $translator->translateStation("US12") ?>">
                                //                     </div>
                                //                 </div>
                                //                 <div id="max_price_input" class="input-container">
                                //                     <div class="input-wrap">
                                //                         <label class="input-label" for="filter_maxPrice"><?= $translator->translateStation("US13") ?></label>
                                //                         <input id="filter_maxPrice" class="input-error input-tag" onchange="updateNumberInputValue('#filter_maxPrice')" type="number" name="maxprice" value="<?= $search->getMaxPrice() ?>" placeholder="<?= $translator->translateStation("US13") ?>">
                                //                     </div>
                                //                 </div>
                                //             </div>
                                //         </div>
                                //     </div>
                                // </div>
                                */
                                ?>
                            </div>

                            <?php
                            /*
                            // <div class="apply-button-container">
                            //     <button id="filter_button" class="green-button standard-button remove-button-default-att"><?= $translator->translateStation("US14") ?></button>
                            // </div>
                            */
                            ?>
                        </div>
                    </from>
                    <div class="filter-hide-container">
                        <span id="filter_hide_button" class="filter-hide-span"><?= $translator->translateStation("US15") ?></span>
                    </div>
                </div>
                <div class="item-space">
                    <ul class="remove-ul-default-att">
                        <?php
                        $products = $search->getProducts();
                        $country = $person->getCountry();
                        $currency = $person->getCurrency();
                        ob_start();
                        require 'view/Grid/gridFiles/gridProduct.php';
                        echo ob_get_clean();
                        ?>
                    </ul>
                    <div id="prodGrid_loading" class="loading-img-wrap">
                        <img src="<?= self::$DIR_STATIC_FILES ?>loading.gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>