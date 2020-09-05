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

$this->title = "grid";
$this->lang = $person->getLanguage()->getIsoLang();
$this->description = "grid page";
ob_start();
require 'view/Grid/gridFiles/head.php';
$this->head = ob_get_clean();

?>
<div class="grid-container">
    <div id="ctr_grid_content">
        <div class="grid-inner">
            <div class="filter-block-mobile">
                <div id="filter_button" class="filter-button-block">
                    <div class="img-text-block">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="content/brain/permanent/icons8-setting-80.png">
                            </div>
                            <span class="img-text-span"><?= $translator->translateStation("US1") ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="directory-wrap">
                <p>women \ collection \ category</p>
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
                <div id="filter_block" class="filter-block">
                    <p><?= $translator->translateStation("US1") ?></p>
                    <from id="grid_filter">
                        <?php
                        $orderIsChecked[0] = Query::getParam("order") == Search::NEWEST ? 'checked="true"' : "";
                        $orderIsChecked[1] = Query::getParam("order") == Search::OLDER ? 'checked="true"' : "";
                        $orderIsChecked[2] = Query::getParam("order") == Search::HIGHT_TO_LOW ? 'checked="true"' : "";
                        $orderIsChecked[3] = Query::getParam("order") == Search::LOW_TO_HIGHT ? 'checked="true"' : "";
                        ?>
                        <div class="filter-dropdown-set">
                            <div class="filter-dropdown-inner">
                                <div class="dropdown-container">
                                    <div class="dropdown-wrap">
                                        <div class="dropdown-inner">
                                            <div class="dropdown-head dropdown-arrow-close">
                                                <span class="dropdown-title"><?= $translator->translateStation("US2") ?></span>
                                            </div>
                                            <div class="dropdown-checkbox-list" style="display: none;">
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US3") ?>
                                                        <input type="radio" name="order" value="<?= Search::NEWEST ?>" <?= $orderIsChecked[0] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US4") ?>
                                                        <input type="radio" name="order" value="<?= Search::OLDER ?>" <?= $orderIsChecked[1] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US6") ?>
                                                        <input type="radio" name="order" value="<?= Search::LOW_TO_HIGHT ?>" <?= $orderIsChecked[2] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label"><?= $translator->translateStation("US5") ?>
                                                        <input type="radio" name="order" value="<?= Search::HIGHT_TO_LOW ?>" <?= $orderIsChecked[3] ?>>
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-container">
                                    <?php
                                    $title = $translator->translateStation("US7"); // $dpdName
                                    $tabNames = ["product_types", "functions"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    ?>

                                </div>
                                <div class="dropdown-container">
                                    <?php
                                    $title = $translator->translateStation("US8"); // $dpdName
                                    $tabNames = ["categories"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    ?>

                                </div>
                                <div class="dropdown-container">
                                    <?php
                                    $title = $translator->translateStation("US9"); // $dpdName
                                    $tabNames = ["sizes"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    ?>
                                </div>
                                <div class="dropdown-container">
                                    <?php
                                    $title = $translator->translateStation("US10"); // $dpdName
                                    $tabNames = ["colors"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->getSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    ?>
                                </div>
                                <div class="dropdown-container">
                                    <div class="dropdown-wrap">
                                        <div class="dropdown-inner">
                                            <div class="dropdown-head dropdown-arrow-close">
                                                <span class="dropdown-title"><?= $translator->translateStation("US11") ?></span>
                                            </div>
                                            <div class="dropdown-checkbox-list">
                                                <div id="min_price_input" class="input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="filter_minPrice"><?= $translator->translateStation("US12") ?></label>
                                                        <input id="filter_minPrice" class="input-error input-tag" type="number" name="minprice" value="<?= $search->getMinPrice() ?>" placeholder="<?= $translator->translateStation("US12") ?>">
                                                    </div>
                                                </div>
                                                <div id="max_price_input" class="input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="filter_maxPrice"><?= $translator->translateStation("US13") ?></label>
                                                        <input id="filter_maxPrice" class="input-error input-tag" type="number" name="maxprice" value="<?= $search->getMaxPrice() ?>" placeholder="<?= $translator->translateStation("US13") ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="apply-button-container">
                                <button id="filter_button" class="green-button standard-button remove-button-default-att"><?= $translator->translateStation("US14") ?></button>
                            </div>
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
                        <img src="content/brain/permanent/loading.gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>