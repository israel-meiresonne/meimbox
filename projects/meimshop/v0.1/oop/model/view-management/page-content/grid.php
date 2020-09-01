<?php //error_reporting(-1); 
?>
<?php //ini_set('display_errors', true); 
?>
<!-- grid -->
<?php

require_once "../../../../../oop/controller/Dependency.php";
Dependency::requireControllerDependencies("../../../../../");

?>
<html lang="en">

<head>
    <title>Document</title>
    <meta name="description" content="">
    <?php
    $controller = new Controller();
    echo $controller->getHeadDatas();
    echo $controller->getGeneralFiles();
    ?>
    <script src="outside/js/grid.js"></script>
    <link rel="stylesheet" href="outside/css/grid.css">
</head>

<body>
    <header>
        <?php
        echo $controller->getComputerHeader();
        echo $controller->getMobileHeader();
        echo $controller->getConstants();
        ?>
    </header>

    <div class="grid-container">
        <div id="ctr_grid_content">
            <div class="grid-inner">
                <div class="filter-block-mobile">
                    <div id="filter_button" class="filter-button-block">
                        <div class="img-text-block">
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="outside/brain/permanent/icons8-setting-80.png">
                                </div>
                                <span class="img-text-span">filtres</span>
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
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="older" class="sticker-content-div">older</div>
                                    <button onclick="removeSticker('older')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="basketproduct" class="sticker-content-div">basketproduct</div>
                                    <button onclick="removeSticker('basketproduct')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="boxproduct" class="sticker-content-div">boxproduct</div>
                                    <button onclick="removeSticker('boxproduct')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="accessories" class="sticker-content-div">accessories</div>
                                    <button onclick="removeSticker('accessories')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="clothes" class="sticker-content-div">clothes</div>
                                    <button onclick="removeSticker('clothes')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="jackets" class="sticker-content-div">jackets</div>
                                    <button onclick="removeSticker('jackets')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="scarfs" class="sticker-content-div">scarfs</div>
                                    <button onclick="removeSticker('scarfs')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="trousers" class="sticker-content-div">trousers</div>
                                    <button onclick="removeSticker('trousers')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="vests" class="sticker-content-div">vests</div>
                                    <button onclick="removeSticker('vests')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="yellow" class="sticker-content-div">yellow</div>
                                    <button onclick="removeSticker('yellow')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="l" class="sticker-content-div">l</div>
                                    <button onclick="removeSticker('l')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="m" class="sticker-content-div">m</div>
                                    <button onclick="removeSticker('m')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="sticker-container">
                                <div class="sticker-wrap">
                                    <div value="s" class="sticker-content-div">s</div>
                                    <button onclick="removeSticker('s')" class="sticker-button remove-button-default-att">
                                        <span class="sticker-x-left"></span>
                                        <span class="sticker-x-right"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid-item-container">
                    <div id="filter_block" class="filter-block">
                        <p>filtres</p>
                        <from id="grid_filter">
                            <div class="filter-dropdown-set">
                                <div class="filter-dropdown-inner">
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-open">
                                                    <span class="dropdown-title">trier</span>
                                                </div>
                                                <div class="dropdown-checkbox-list" style="display: block;">
                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">les plus récents
                                                            <input type="radio" name="order" value="newest">
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>

                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">les moins récents
                                                            <input type="radio" name="order" value="older">
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>

                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">prix - croissant
                                                            <input type="radio" name="order" value="lowtohight">
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>

                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">prix - décroissant
                                                            <input type="radio" name="order" value="highttolow">
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-open">
                                                    <span class="dropdown-title">type</span>
                                                </div>
                                                <div class="dropdown-checkbox-list" style="display: block;">
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
                                        </div>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-open">
                                                    <span class="dropdown-title">catégorie</span>
                                                </div>
                                                <div class="dropdown-checkbox-list" style="display: block;">
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
                                        </div>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-open">
                                                    <span class="dropdown-title">taille</span>
                                                </div>
                                                <div class="dropdown-checkbox-list" style="display: block;">
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
                                        </div>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-open">
                                                    <span class="dropdown-title">couleur</span>
                                                </div>
                                                <div class="dropdown-checkbox-list" style="display: block;">
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
                                        </div>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-close">
                                                    <span class="dropdown-title">prix</span>
                                                </div>
                                                <div class="dropdown-checkbox-list" style="display: none;">
                                                    <div id="min_price_input" class="input-container">
                                                        <div class="input-wrap">
                                                            <label class="input-label" for="filter_minPrice">prix minimum</label>
                                                            <input id="filter_minPrice" class="input-error input-tag" type="number" name="minprice" value="" placeholder="prix minimum">
                                                        </div>
                                                    </div>
                                                    <div id="max_price_input" class="input-container">
                                                        <div class="input-wrap">
                                                            <label class="input-label" for="filter_maxPrice">prix maximum</label>
                                                            <input id="filter_maxPrice" class="input-error input-tag" type="number" name="maxprice" value="" placeholder="prix maximum">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="apply-button-container">
                                    <button class="green-button remove-button-default-att">filtrer</button>
                                </div>
                            </div>
                        </from>
                        <div class="filter-hide-container">
                            <span id="filter_hide_button" class="filter-hide-span">fermer</span>
                        </div>
                    </div>
                    <div class="item-space">
                        <ul class="remove-ul-default-att">
                            <li class="remove-li-default-att article-li">
                                <article class="product-article-wrap">
                                    <div class="product-img-set">
                                        <a href="/inside/item/?prodID=3">
                                            <div class="product-img-wrap product-img-first">
                                                <img src="outside/brain/prod/picture01.jpeg">
                                            </div>
                                            <div class="product-img-wrap product-img-second">
                                                <img src="outside/brain/prod/picture02.jpeg">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="product-detail-block">
                                        <div class="detail-text-div">
                                            <h4><span>boxproduct3 | <span style="color:#ffff00;">yellow</span></span> </h4>
                                        </div>
                                        <div class="detail-price-div">
                                            <div class="piano-wrap">
                                                <div class="piano-displayable-set">
                                                    <ul class="piano-ul-displayable remove-ul-default-att">
                                                        <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                            <p>C$ <span style="color:#0E2439; opacity: .8;">13,34</span> CAD</p>
                                                        </li>
                                                        <li class="piano-li-displayable remove-li-default-att" style="display:none;">
                                                            <p>C$ <span style="color:#C6C6C7; opacity: 1;">11,67</span> CAD</p>
                                                        </li>
                                                        <li class="piano-li-displayable remove-li-default-att">
                                                            <p>C$ <span style="color:#FFD300; opacity: 1;">7,76</span> CAD</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="piano-button-set">
                                                    <ul class="piano-ul-button remove-ul-default-att">
                                                        <li class="piano-li-button remove-li-default-att">
                                                            <div class="piano-button remove-button-default-att" style="background:var(--color-white); ">
                                                                <span class="piano-button-span">regular</span>
                                                            </div>
                                                        </li>
                                                        <li class="piano-li-button remove-li-default-att">
                                                            <div class="piano-button remove-button-default-att" style="background:var(--color-shadow-05);">
                                                                <span class="piano-button-span">silver</span>
                                                            </div>
                                                        </li>
                                                        <li class="piano-li-button remove-li-default-att piano-selected-button">
                                                            <div class="piano-button remove-button-default-att" style="background:var(--color-yellow-07); color: var(--color-white);">
                                                                <span class="piano-button-span">gold</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="detail-color-div">
                                            <ul class="remove-ul-default-att">
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <a href="/inside/item/?prodID=3">
                                                            <div class="cube-wrap cube-selected">
                                                                <div class="cube-item-color" style="background: #ffff00;"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=4">
                                                                <div class="cube-item-color" style="background: red;"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=5">
                                                                <div class="cube-item-color" style="background: orange;"></div>
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
                                                <img src="outside/brain/prod/picture01.jpeg">
                                            </div>
                                            <div class="product-img-wrap product-img-second">
                                                <img src="outside/brain/prod/picture02.jpeg">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="product-detail-block">
                                        <div class="detail-text-div">
                                            <h4><span>basketproduct5 | <span style="color:#ffff00;">yellow</span></span> </h4>
                                        </div>
                                        <div class="detail-price-div">
                                            <p>C$ 83,72 CAD</p>
                                        </div>
                                        <div class="detail-color-div">
                                            <ul class="remove-ul-default-att">
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <a href="/inside/item/?prodID=9">
                                                            <div class="cube-wrap cube-selected">
                                                                <div class="cube-item-color" style="background: #ffff00;"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=10">
                                                                <div class="cube-item-color" style="background: red;"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=11">
                                                                <div class="cube-item-color" style="background: blue;"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=12">
                                                                <div class="cube-item-color" style="background: yellow;"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=13">
                                                                <div class="cube-item-color" style="background: green;"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=14">
                                                                <div class="cube-item-color" style="background: orange;"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="remove-li-default-att">
                                                    <div class="cube-container">
                                                        <div class="cube-wrap">
                                                            <a href="/inside/item/?prodID=15">
                                                                <div class="cube-item-color cube-more_color">
                                                                    <img src="outside/brain/permanent/icons8-plus-math-96.png">
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
                        </ul>
                        <div id="prodGrid_loading" class="loading-img-wrap" style="display: none;">
                            <img src="outside/brain/permanent/loading.gif">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>