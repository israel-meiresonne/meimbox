<?php
$this->title = "grid";
$this->lang = "fr";
$this->description = "grid page";
ob_start();
require 'gridElements/head.php';
$this->head = ob_get_clean();
/**
 * @var Translator
 */
$translator = $this->translator;

/**
 * @var Search
 */
$search = $search;

/**
 * @var Visitor|Client|Administrator
 */
$person = $person;
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
                        $stickers = $search->getStickers($person->getLanguage(), $translator);
                        // var_dump($_GET);
                        // $stickers = ["monstick" => "fuck you"];
                        ob_start();
                        require 'view/elements/sticker.php';
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
                                    $checkedLabels = $search->geSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    /*
                                    <!-- <div class="dropdown-wrap">
                                        <div class="dropdown-inner">
                                            <div class="dropdown-head dropdown-arrow-close">
                                                <span class="dropdown-title">type</span>
                                            </div>
                                            <div class="dropdown-checkbox-list" style="display: none;">
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">accessories
                                                        <input type="checkbox" name="functions_0" value="accessories">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">basketproduct
                                                        <input type="checkbox" name="product_types_1" value="basketproduct">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">boxproduct
                                                        <input type="checkbox" name="product_types_2" value="boxproduct">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">clothes
                                                        <input type="checkbox" name="functions_3" value="clothes">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    */
                                    ?>

                                </div>
                                <div class="dropdown-container">
                                    <?php
                                    $title = $translator->translateStation("US8"); // $dpdName
                                    $tabNames = ["categories"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->geSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    /*
                                    <!-- <div class="dropdown-wrap">
                                        <div class="dropdown-inner">
                                            <div class="dropdown-head dropdown-arrow-close">
                                                <span class="dropdown-title">catégorie</span>
                                            </div>
                                            <div class="dropdown-checkbox-list" style="display: none;">
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">jackets
                                                        <input type="checkbox" name="categories_0" value="jackets">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">scarfs
                                                        <input type="checkbox" name="categories_1" value="scarfs">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">trousers
                                                        <input type="checkbox" name="categories_2" value="trousers">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">vests
                                                        <input type="checkbox" name="categories_3" value="vests">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    */
                                    ?>

                                </div>
                                <div class="dropdown-container">
                                <?php
                                    $title = $translator->translateStation("US9"); // $dpdName
                                    $tabNames = ["sizes"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->geSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    /*
                                    <!-- <div class="dropdown-wrap">
                                        <div class="dropdown-inner">
                                            <div class="dropdown-head dropdown-arrow-close">
                                                <span class="dropdown-title">taille</span>
                                            </div>
                                            <div class="dropdown-checkbox-list">
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">l
                                                        <input type="checkbox" name="sizes_0" value="l">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">m
                                                        <input type="checkbox" name="sizes_1" value="m">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">s
                                                        <input type="checkbox" name="sizes_2" value="s">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    */
                                    ?>
                                </div>
                                <div class="dropdown-container">
                                <?php
                                    $title = $translator->translateStation("US10"); // $dpdName
                                    $tabNames = ["colors"];
                                    $labels =  $search->getValToTableNameMap($tabNames); // [criterVal => criterion]
                                    $criterions = $tabNames;
                                    $checkedLabels = $search->geSearchParams($criterions); // [index => criterVal]
                                    ob_start();
                                    require 'view/elements/dropdown.php';
                                    echo ob_get_clean();
                                    /*
                                    <!-- <div class="dropdown-wrap">
                                        <div class="dropdown-inner">
                                            <div class="dropdown-head dropdown-arrow-close">
                                                <span class="dropdown-title">couleur</span>
                                            </div>
                                            <div class="dropdown-checkbox-list">
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">black
                                                        <input type="checkbox" name="colors_0" value="black">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">blue
                                                        <input type="checkbox" name="colors_1" value="blue">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">green
                                                        <input type="checkbox" name="colors_2" value="green">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">orange
                                                        <input type="checkbox" name="colors_3" value="orange">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">red
                                                        <input type="checkbox" name="colors_4" value="red">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">white
                                                        <input type="checkbox" name="colors_5" value="white">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="dropdown-checkbox-block">
                                                    <label class="checkbox-label">yellow
                                                        <input type="checkbox" name="colors_6" value="yellow">
                                                        <span class="checkbox-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    */
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
                                <button id="filter_button" class="green-button remove-button-default-att"><?= $translator->translateStation("US14") ?></button>
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
                        foreach($products as $product):
                        /*
                        <!-- <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=1">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>boxproduct1 | <span style="color:#33cc33;">green</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <div class="piano-wrap">
                                            <div class="piano-displayable-set">
                                                <ul class="piano-ul-displayable remove-ul-default-att">
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:rgba(14, 36, 57, 0.8);">C$13,51 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:#C6C6C7;">C$11,69 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att">
                                                        <p style="color:rgba(255, 211, 0);">C$7,20 CAD</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="piano-button-set">
                                                <ul class="piano-ul-button remove-ul-default-att">
                                                    <li id="a9bbb1cvlvdhl745bqazpcts6niwbo" onclick="animatePiano('a9bbb1cvlvdhl745bqazpcts6niwbo')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:#ffffff; ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">regular</span>
                                                        </div>
                                                    </li>
                                                    <li id="c5onqcgz9c6ma9yku8a1bm2p9xbc2n" onclick="animatePiano('c5onqcgz9c6ma9yku8a1bm2p9xbc2n')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(229, 229, 231, 0.5); ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">silver</span>
                                                        </div>
                                                    </li>
                                                    <li id="e55xqzku1rfrwn33bcpsfpptvh2ibc" onclick="animatePiano('e55xqzku1rfrwn33bcpsfpptvh2ibc')" class="piano-li-button remove-li-default-att piano-selected-button">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(255, 211, 0, 0.7); ">
                                                            <span class="piano-button-span" style="color:#ffffff;">gold</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=1">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #33cc33;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=2">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>boxproduct2 | <span style="color:#00ccff;">blue</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <div class="piano-wrap">
                                            <div class="piano-displayable-set">
                                                <ul class="piano-ul-displayable remove-ul-default-att">
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:rgba(14, 36, 57, 0.8);">C$13,51 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:#C6C6C7;">C$11,69 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att">
                                                        <p style="color:rgba(255, 211, 0);">C$7,20 CAD</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="piano-button-set">
                                                <ul class="piano-ul-button remove-ul-default-att">
                                                    <li id="8k1n7gab8nvixq706migujfxt8xj9e" onclick="animatePiano('8k1n7gab8nvixq706migujfxt8xj9e')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:#ffffff; ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">regular</span>
                                                        </div>
                                                    </li>
                                                    <li id="vf3kfrsgjfug7lundr3vcgdtazc5yy" onclick="animatePiano('vf3kfrsgjfug7lundr3vcgdtazc5yy')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(229, 229, 231, 0.5); ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">silver</span>
                                                        </div>
                                                    </li>
                                                    <li id="8j6g2tfgxncganv23v0w0v40wwek35" onclick="animatePiano('8j6g2tfgxncganv23v0w0v40wwek35')" class="piano-li-button remove-li-default-att piano-selected-button">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(255, 211, 0, 0.7); ">
                                                            <span class="piano-button-span" style="color:#ffffff;">gold</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=2">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #00ccff;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=3">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>boxproduct3 | <span style="color:#ffff00;">yellow</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <div class="piano-wrap">
                                            <div class="piano-displayable-set">
                                                <ul class="piano-ul-displayable remove-ul-default-att">
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:rgba(14, 36, 57, 0.8);">C$13,51 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:#C6C6C7;">C$11,69 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att">
                                                        <p style="color:rgba(255, 211, 0);">C$7,20 CAD</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="piano-button-set">
                                                <ul class="piano-ul-button remove-ul-default-att">
                                                    <li id="o5lfcfkef1sr03o8o703q160svmw2h" onclick="animatePiano('o5lfcfkef1sr03o8o703q160svmw2h')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:#ffffff; ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">regular</span>
                                                        </div>
                                                    </li>
                                                    <li id="k3l9ardgap8xf411fx66xvvd2rys0w" onclick="animatePiano('k3l9ardgap8xf411fx66xvvd2rys0w')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(229, 229, 231, 0.5); ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">silver</span>
                                                        </div>
                                                    </li>
                                                    <li id="wz54bhwuo1s0bakbkyf1otw0ygyl9s" onclick="animatePiano('wz54bhwuo1s0bakbkyf1otw0ygyl9s')" class="piano-li-button remove-li-default-att piano-selected-button">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(255, 211, 0, 0.7); ">
                                                            <span class="piano-button-span" style="color:#ffffff;">gold</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=3">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #ffff00;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=4">
                                                            <div class="cube-item-color " style="background: #ff3300;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=5">
                                                            <div class="cube-item-color " style="background: #ff9900;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=4">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>boxproduct3 | <span style="color:#ff3300;">red</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <div class="piano-wrap">
                                            <div class="piano-displayable-set">
                                                <ul class="piano-ul-displayable remove-ul-default-att">
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:rgba(14, 36, 57, 0.8);">C$13,51 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:#C6C6C7;">C$11,69 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att">
                                                        <p style="color:rgba(255, 211, 0);">C$7,20 CAD</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="piano-button-set">
                                                <ul class="piano-ul-button remove-ul-default-att">
                                                    <li id="lwvbilsxvhr58s4xno63wzzqd23co2" onclick="animatePiano('lwvbilsxvhr58s4xno63wzzqd23co2')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:#ffffff; ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">regular</span>
                                                        </div>
                                                    </li>
                                                    <li id="tawbv56ae72bk5urrplc1bhk5xdqtg" onclick="animatePiano('tawbv56ae72bk5urrplc1bhk5xdqtg')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(229, 229, 231, 0.5); ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">silver</span>
                                                        </div>
                                                    </li>
                                                    <li id="idq3fb84hhmjji6xx1yovl4gebbzhz" onclick="animatePiano('idq3fb84hhmjji6xx1yovl4gebbzhz')" class="piano-li-button remove-li-default-att piano-selected-button">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(255, 211, 0, 0.7); ">
                                                            <span class="piano-button-span" style="color:#ffffff;">gold</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=4">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #ff3300;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=3">
                                                            <div class="cube-item-color " style="background: #ffff00;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=5">
                                                            <div class="cube-item-color " style="background: #ff9900;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=5">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>boxproduct3 | <span style="color:#ff9900;">orange</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <div class="piano-wrap">
                                            <div class="piano-displayable-set">
                                                <ul class="piano-ul-displayable remove-ul-default-att">
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:rgba(14, 36, 57, 0.8);">C$13,51 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                        <p style="color:#C6C6C7;">C$11,69 CAD</p>
                                                    </li>
                                                    <li class="piano-li-displayable remove-li-default-att">
                                                        <p style="color:rgba(255, 211, 0);">C$7,20 CAD</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="piano-button-set">
                                                <ul class="piano-ul-button remove-ul-default-att">
                                                    <li id="fuqxiqr93wvxjmaftanz4a3720d2oz" onclick="animatePiano('fuqxiqr93wvxjmaftanz4a3720d2oz')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:#ffffff; ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">regular</span>
                                                        </div>
                                                    </li>
                                                    <li id="hh05ontozc41jt6ftp3f54mmxcj4em" onclick="animatePiano('hh05ontozc41jt6ftp3f54mmxcj4em')" class="piano-li-button remove-li-default-att ">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(229, 229, 231, 0.5); ">
                                                            <span class="piano-button-span" style="color:rgba(14, 36, 57, 0.5);">silver</span>
                                                        </div>
                                                    </li>
                                                    <li id="tkv05ywqtoi2rbswc0y6ukv76dlnh8" onclick="animatePiano('tkv05ywqtoi2rbswc0y6ukv76dlnh8')" class="piano-li-button remove-li-default-att piano-selected-button">
                                                        <div class="piano-button remove-button-default-att" style="background:rgba(255, 211, 0, 0.7); ">
                                                            <span class="piano-button-span" style="color:#ffffff;">gold</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=5">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #ff9900;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=3">
                                                            <div class="cube-item-color " style="background: #ffff00;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=4">
                                                            <div class="cube-item-color " style="background: #ff3300;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=6">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>basketproduct4 | <span style="color:#000000;">black</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <p>C$84,25 CAD</p>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=6">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #000000;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=7">
                                                            <div class="cube-item-color " style="background: #33cc33;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=8">
                                                            <div class="cube-item-color cube-border" style="background: #ffffff;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=7">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>basketproduct4 | <span style="color:#33cc33;">green</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <p>C$87,47 CAD</p>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=7">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #33cc33;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=6">
                                                            <div class="cube-item-color " style="background: #000000;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=8">
                                                            <div class="cube-item-color cube-border" style="background: #ffffff;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=8">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>basketproduct4 | <span style="color:rgba(14, 36, 57, 0.5);">white</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <p>C$80,75 CAD</p>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=8">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: rgba(14, 36, 57, 0.5);"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=6">
                                                            <div class="cube-item-color " style="background: #000000;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=7">
                                                            <div class="cube-item-color " style="background: #33cc33;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=9">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>basketproduct5 | <span style="color:#ffff00;">yellow</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <p>C$83,72 CAD</p>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=9">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #ffff00;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=10">
                                                            <div class="cube-item-color " style="background: #ff3300;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=11">
                                                            <div class="cube-item-color " style="background: #00ccff;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=12">
                                                            <div class="cube-item-color " style="background: #ffff00;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=13">
                                                            <div class="cube-item-color " style="background: #33cc33;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=14">
                                                            <div class="cube-item-color " style="background: #ff9900;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=15">
                                                            <div class="cube-item-color cube-more_color">
                                                                <img src="content/brain/permanent/icons8-plus-math-96.png">
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="remove-li-default-att article-li">
                            <article class="product-article-wrap">
                                <div class="product-img-set">
                                    <a href="/inside/item/?prodID=10">
                                        <div class="product-img-wrap product-img-first">
                                            <img src="content/brain/prod/picture01.jpeg">
                                        </div>
                                        <div class="product-img-wrap product-img-second">
                                            <img src="content/brain/prod/picture02.jpeg">
                                        </div>
                                    </a>
                                </div>
                                <div class="product-detail-block">
                                    <div class="detail-text-div" style="height: 29px;">
                                        <h4><span>basketproduct5 | <span style="color:#ff3300;">red</span></span> </h4>
                                    </div>
                                    <div class="detail-price-div" style="height: 75px;">
                                        <p>C$38,41 CAD</p>
                                    </div>
                                    <div class="detail-color-div" style="height: 30px;">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <a href="/inside/item/?prodID=10">
                                                        <div class="cube-wrap cube-selected">
                                                            <div class="cube-item-color " style="background: #ff3300;"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=9">
                                                            <div class="cube-item-color " style="background: #ffff00;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=11">
                                                            <div class="cube-item-color " style="background: #00ccff;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=12">
                                                            <div class="cube-item-color " style="background: #ffff00;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=13">
                                                            <div class="cube-item-color " style="background: #33cc33;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=14">
                                                            <div class="cube-item-color " style="background: #ff9900;"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="cube-container">
                                                    <div class="cube-wrap">
                                                        <a href="/inside/item/?prodID=15">
                                                            <div class="cube-item-color cube-more_color">
                                                                <img src="content/brain/permanent/icons8-plus-math-96.png">
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </li> -->
                        */
                        ?>
                        <li class="remove-li-default-att article-li">
                            <?php
                            ob_start();
                            require 'view/elements/product.php';
                            echo ob_get_clean();
                            ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div id="prodGrid_loading" class="loading-img-wrap">
                        <img src="content/brain/permanent/loading.gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>