<!-- home -->
<?php //error_reporting(-1); 
?>
<?php //ini_set('display_errors', true); 
?>

<?php
require_once "oop/controller/Dependency.php";
Dependency::requireControllerDependencies("");

?>
<html lang="en">

<head>
    <title>Document</title>
    <meta name="description" content="">
    <?php
    $controller = new Controller(651853948);
    echo $controller->getHeadDatas();
    echo $controller->getGeneralFiles();
    ?>
</head>

<body>

    <header>
        <?php
        echo $controller->getComputerHeader();
        echo $controller->getMobileHeader();
        ?>


    </header>

    <button class="green-button remove-button-default-att">add to box</button>

    <div class="data-key_value-wrap">
        <span class="data-key_value-key">color: </span>
        <span class="data-key_value-value">red</span>
    </div>

    <div class="data-key_value-opposite-wrap">
        <span class="data-key_value-key">color: </span>
        <span class="data-key_value-value">red</span>
    </div>

    <div class="plus_symbol-container">
        <div class="plus_symbol-wrap">
            <span class="plus_symbol-vertical"></span>
            <span class="plus_symbol-horizontal"></span>
        </div>
    </div>

    <div class="select-container">
        <div class="select-wrap">
            <div class="select-inner">
                <label class="select-label" for="">Country/Region</label>
                <select class="select-tag" name="">
                    <option value=""></option>
                    <option data-code="AL" value="Albania">Albania</option>
                    <option data-code="AD" value="Andorra">Andorra</option>
                    <option data-code="AM" value="Armenia">Armenia</option>
                    <option data-code="AT" value="Austria">Austria</option>
                </select>
            </div>
            <p class="comment">hello i'm error message</p>
        </div>
    </div>

    <div class="input-container">
        <div class="input-wrap">
            <label class="input-label" for="appartement">Apartment, suite, etc. (optional)</label>
            <span class="input-unit">cm</span>
            <input id="appartement" class="input-error input-tag" type="text" name="appartement" placeholder="Apartment, suite, etc. (optional)" value="">
            <p class="comment">hello i'm error message</p>
        </div>
    </div>

    <div class="checkbox-container">
        <label class="checkbox-label" for="measure_unit_inch">inch
            <input id="measure_unit_inch" type="radio" name="measure_unit">
            <span class="checkbox-checkmark"></span>
        </label>
    </div>

    <div class="dropdown-container">
        <div class="dropdown-wrap">
            <div class="dropdown-inner">
                <div class="dropdown-head dropdown-arrow-close">
                    <span class="dropdown-title">color</span>
                </div>
                <div class="dropdown-checkbox-list">
                    <div class="dropdown-checkbox-block">
                        <label class="checkbox-label">red
                            <input type="checkbox" name="size_s">
                            <span class="checkbox-checkmark"></span>
                        </label>
                    </div>
                    <div class="dropdown-checkbox-block">
                        <label class="checkbox-label">blue
                            <input type="checkbox" name="size_m">
                            <span class="checkbox-checkmark"></span>
                        </label>
                    </div>
                    <div class="dropdown-checkbox-block">
                        <label class="checkbox-label">yellow
                            <input type="checkbox" name="size_l">
                            <span class="checkbox-checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sticker-container">
        <div class="sticker-wrap">
            <div class="sticker-content-div">jackets</div>
            <button class="sticker-button remove-button-default-att">
                <span class="sticker-x-left"></span>
                <span class="sticker-x-right"></span>
            </button>
        </div>
    </div>

    <div class="directory-wrap">
        <p>women \ collection \ coat \ essential double coat</p>
    </div>

    <div class="img-text-wrap">
        <div class="img-text-img">
            <img src="outside/brain/permanent/icons8-pill-yellow-red.png" alt="">
        </div>
        <span class="img-text-span">new drop</span>
    </div>

    <div class="collapse-wrap">
        <ul class="remove-ul-default-att">
            <li class="remove-li-default-att">

                <div class="collapse-div">
                    <div class="collapse-title-div">
                        <div class="collapse-title">details</div>
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
                            These upgraded wardrobe staples feature understated
                            styling and timeless silhouettes that let you create
                            effortlessly on-trend outfits. This warm and protective
                            maxi trench coat has you looking sleek and sophisticated
                            while you're out and about in the city. Highlights
                            • Pure cotton twill
                            • Point collar
                            • Contrast piping on collar
                            • Button closure
                            • Double breasted
                            • Self-tie belt at waist
                            • Contrast lining
                            • Tommy Hilfiger branding
                        </div>
                    </div>
                </div>

            </li>
            <li class="remove-li-default-att">
                <div class="collapse-div">
                    <div class="collapse-title-div">
                        <div class="collapse-title">shipping + return</div>
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
                            These upgraded wardrobe staples feature understated
                            styling and timeless silhouettes that let you create
                            effortlessly on-trend outfits. This warm and protective
                            maxi trench coat has you looking sleek and sophisticated
                            while you're out and about in the city. Highlights
                            • Pure cotton twill
                            • Point collar
                            • Contrast piping on collar
                            • Button closure
                            • Double breasted
                            • Self-tie belt at waist
                            • Contrast lining
                            • Tommy Hilfiger branding
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div id="product_slider" class="slider-wrap">
        <button class="slider-left-button remove-button-default-att"></button>
        <div class="slider-window">
            <div class="item-set">
                <div class="slider-nb_acticle-width_indicator"></div>
                <ul class="silder-ul-container remove-ul-default-att">
                    <li class="silder-li-container remove-li-default-att">
                        <article class="slider-article">
                            <img src="outside/brain/prod/picture01.jpeg">
                        </article>
                    </li>
                    <li class="silder-li-container remove-li-default-att">
                        <article class="slider-article">
                            <img src="outside/brain/prod/picture02.jpeg">
                        </article>
                    </li>
                    <li class="silder-li-container remove-li-default-att">
                        <article class="slider-article">
                            <img src="outside/brain/prod/picture03.jpeg">
                        </article>
                    </li>
                    <li class="silder-li-container remove-li-default-att">
                        <article class="slider-article">
                            <img src="outside/brain/prod/picture02.jpeg">
                        </article>
                    </li>
                    <li class="silder-li-container remove-li-default-att">
                        <article class="slider-article">
                            <img src="outside/brain/prod/picture02.jpeg">
                        </article>
                    </li>
                </ul>
            </div>
        </div>
        <button class="slider-right-button remove-button-default-att"></button>
    </div>

    <article class="product-article-wrap">
        <div class="product-img-set">
            <a href="">
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
                <h4>
                    <span>essential double coat | <span style="color:#B19879;">beige</span></span>
                </h4>
            </div>
            <div class="detail-price-div">
                <p>$52.50 usd</p>
            </div>
            <div class="detail-color-div">
                <ul class="remove-ul-default-att">

                    <li class="remove-li-default-att">
                        <div class="cube-container">
                            <a href="">
                                <div class="cube-wrap cube-selected">
                                    <div class="cube-item-color" style="background: #B19879;"></div>
                                </div>
                            </a>
                        </div>
                    </li>

                    <li class="remove-li-default-att">
                        <div class="cube-container">
                            <div class="cube-wrap">
                                <a href="">
                                    <div class="cube-item-color" style="background: #7483F2;"></div>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="remove-li-default-att">
                        <div class="cube-container">
                            <div class="cube-wrap">
                                <a href="">
                                    <div class="cube-item-color" style="background: #F2A474;"></div>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="remove-li-default-att">
                        <div class="cube-container">
                            <div class="cube-wrap">
                                <a href="">
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

    <div class="cart-wrap">
        <ul class="remove-ul-default-att">
            <li class="li-cart-element-container remove-li-default-att">
                <div class="basket_product-wrap">
                    <div class="cart-element-wrap">
                        <div class="cart-element-inner">
                            <div class="cart-element-remove-button-block">
                                <button class="cart-element-remove-button remove-button-default-att">
                                    <div class="plus_symbol-wrap">
                                        <span class="plus_symbol-vertical"></span>
                                        <span class="plus_symbol-horizontal"></span>
                                    </div>
                                </button>
                            </div>

                            <div class="cart-element-detail-block">
                                <div class="cart-element-img-div">
                                    <img src="outside/brain/prod/picture01.jpeg">
                                </div>
                                <div class="cart-element-property-set">
                                    <div class="cart-element-property-div">
                                        <span>essential double coat</span>
                                    </div>
                                    <div class="cart-element-property-div">

                                        <span class="cart-element-property">color: </span>
                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                    </div>
                                    <div class="cart-element-property-div">
                                        <span class="cart-element-property">size: </span>
                                        <span class="cart-element-value">s</span>
                                    </div>
                                    <div class="cart-element-property-div">
                                        <span class="cart-element-property">quantity: </span>
                                        <span class="cart-element-value">2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-element-edit-block">
                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                            </div>
                            <div class="cart-element-price-block">
                                <div class="cart-element-price-inner">
                                    <span>$52.50 usd</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="li-cart-element-container remove-li-default-att">

                <div class="box-wrap">
                    <div class="cart-element-wrap">
                        <div class="cart-element-inner">
                            <div class="cart-element-remove-button-block">
                                <button class="cart-element-remove-button remove-button-default-att">
                                    <div class="plus_symbol-wrap">
                                        <span class="plus_symbol-vertical"></span>
                                        <span class="plus_symbol-horizontal"></span>
                                    </div>
                                </button>
                            </div>

                            <div class="cart-element-detail-block">
                                <div class="cart-element-img-div">
                                    <img src="outside/brain/permanent/box-gold-128.png">
                                </div>
                                <div class="cart-element-property-set box-property-set">
                                    <div class="box-property-set-inner">
                                        <div class="cart-element-property-div">
                                            <span>golden box</span>
                                        </div>
                                        <div class="cart-element-property-div">
                                            <span class="cart-element-property">item: </span>
                                            <span class="cart-element-value">3</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-element-edit-block">
                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                            </div>

                            <div class="cart-element-price-block">
                                <div class="cart-element-price-inner">
                                    <span>$52.50 usd</span>
                                </div>
                            </div>

                            <div class="cart-element-arrow-block">
                                <button class="cart-element-arrow-button remove-button-default-att">
                                    <div class="arrow-element-wrap">
                                        <span class="arrow-span"></span>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="box-product-set">
                        <ul class="box-product-set-ul remove-ul-default-att">
                            <li class="box-product-set-li remove-li-default-att">

                                <div class="box_product-wrap">
                                    <div class="cart-element-wrap">
                                        <div class="cart-element-inner">
                                            <div class="cart-element-remove-button-block">
                                                <button class="cart-element-remove-button remove-button-default-att">
                                                    <div class="plus_symbol-wrap">
                                                        <span class="plus_symbol-vertical"></span>
                                                        <span class="plus_symbol-horizontal"></span>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="cart-element-detail-block">
                                                <div class="cart-element-img-div">
                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                </div>
                                                <div class="cart-element-property-set">
                                                    <div class="cart-element-property-div">
                                                        <span>essential double coat</span>
                                                    </div>
                                                    <div class="cart-element-property-div">

                                                        <span class="cart-element-property">color: </span>
                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                    </div>
                                                    <div class="cart-element-property-div">
                                                        <span class="cart-element-property">size: </span>
                                                        <span class="cart-element-value">s</span>
                                                    </div>
                                                    <div class="cart-element-property-div">
                                                        <span class="cart-element-property">quantity: </span>
                                                        <span class="cart-element-value">2</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-element-edit-block">
                                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>

                </div>

            </li>

            <li class="li-cart-element-container remove-li-default-att">

                <div class="box-wrap">
                    <div class="cart-element-wrap">
                        <div class="cart-element-inner">
                            <div class="cart-element-remove-button-block">
                                <button class="cart-element-remove-button remove-button-default-att">
                                    <div class="plus_symbol-wrap">
                                        <span class="plus_symbol-vertical"></span>
                                        <span class="plus_symbol-horizontal"></span>
                                    </div>
                                </button>
                            </div>

                            <div class="cart-element-detail-block">
                                <div class="cart-element-img-div">
                                    <img src="outside/brain/permanent/box-gold-128.png">
                                </div>
                                <div class="cart-element-property-set box-property-set">
                                    <div class="box-property-set-inner">
                                        <div class="cart-element-property-div">
                                            <span>golden box</span>
                                        </div>
                                        <div class="cart-element-property-div">
                                            <span class="cart-element-property">item: </span>
                                            <span class="cart-element-value">3</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-element-edit-block">
                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                            </div>

                            <div class="cart-element-price-block">
                                <div class="cart-element-price-inner">
                                    <span>$52.50 usd</span>
                                </div>
                            </div>

                            <div class="cart-element-arrow-block">
                                <button class="cart-element-arrow-button remove-button-default-att">
                                    <div class="arrow-element-wrap">
                                        <span class="arrow-span"></span>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="box-product-set">
                        <ul class="box-product-set-ul remove-ul-default-att">
                            <li class="box-product-set-li remove-li-default-att">

                                <div class="box_product-wrap">
                                    <div class="cart-element-wrap">
                                        <div class="cart-element-inner">
                                            <div class="cart-element-remove-button-block">
                                                <button class="cart-element-remove-button remove-button-default-att">
                                                    <div class="plus_symbol-wrap">
                                                        <span class="plus_symbol-vertical"></span>
                                                        <span class="plus_symbol-horizontal"></span>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="cart-element-detail-block">
                                                <div class="cart-element-img-div">
                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                </div>
                                                <div class="cart-element-property-set">
                                                    <div class="cart-element-property-div">
                                                        <span>essential double coat</span>
                                                    </div>
                                                    <div class="cart-element-property-div">

                                                        <span class="cart-element-property">color: </span>
                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                    </div>
                                                    <div class="cart-element-property-div">
                                                        <span class="cart-element-property">size: </span>
                                                        <span class="cart-element-value">s</span>
                                                    </div>
                                                    <div class="cart-element-property-div">
                                                        <span class="cart-element-property">quantity: </span>
                                                        <span class="cart-element-value">2</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-element-edit-block">
                                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>

                </div>

            </li>
        </ul>
    </div>

    <div class="cart-element-wrap">
        <div class="cart-element-inner">
            <div class="cart-element-remove-button-block">
                <button class="cart-element-remove-button remove-button-default-att">
                    <div class="plus_symbol-wrap">
                        <span class="plus_symbol-vertical"></span>
                        <span class="plus_symbol-horizontal"></span>
                    </div>
                </button>
            </div>
            <div class="cart-element-detail-block">
                <div class="cart-element-img-div">
                    <img src="outside/brain/prod/picture01.jpeg">
                </div>
                <div class="cart-element-property-set">
                    <div class="cart-element-property-div">
                        <span>essential double coat</span>
                    </div>
                    <div class="cart-element-property-div">

                        <span class="cart-element-property">color: </span>
                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                    </div>
                    <div class="cart-element-property-div">
                        <span class="cart-element-property">size: </span>
                        <span class="cart-element-value">s</span>
                    </div>
                    <div class="cart-element-property-div">
                        <span class="cart-element-property">quantity: </span>
                        <span class="cart-element-value">2</span>
                    </div>
                </div>
            </div>
            <div class="cart-element-edit-block">
                <button class="cart-element-edit-button remove-button-default-att">edit</button>
            </div>
            <div class="cart-element-price-block">
                <div class="cart-element-price-inner">
                    <span>$52.50 usd</span>
                </div>
            </div>
            <div class="cart-element-arrow-block">
                <button class="cart-element-arrow-button remove-button-default-att">
                    <div class="arrow-element-wrap">
                        <span class="arrow-span"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div class="box-wrap">
        <div class="cart-element-wrap">
            <div class="cart-element-inner">
                <div class="cart-element-remove-button-block">
                    <button class="cart-element-remove-button remove-button-default-att">
                        <div class="plus_symbol-wrap">
                            <span class="plus_symbol-vertical"></span>
                            <span class="plus_symbol-horizontal"></span>
                        </div>
                    </button>
                </div>

                <div class="cart-element-detail-block">
                    <div class="cart-element-img-div">
                        <img src="outside/brain/permanent/box-gold-128.png">
                    </div>
                    <div class="cart-element-property-set box-property-set">
                        <div class="box-property-set-inner">
                            <div class="cart-element-property-div">
                                <span>golden box</span>
                            </div>
                            <div class="cart-element-property-div">
                                <span class="cart-element-property">item: </span>
                                <span class="cart-element-value">3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cart-element-edit-block">
                    <button class="cart-element-edit-button remove-button-default-att">edit</button>
                </div>

                <div class="cart-element-price-block">
                    <div class="cart-element-price-inner">
                        <span>$52.50 usd</span>
                    </div>
                </div>

                <div class="cart-element-arrow-block">
                    <button class="cart-element-arrow-button remove-button-default-att">
                        <div class="arrow-element-wrap">
                            <span class="arrow-span"></span>
                        </div>
                    </button>
                </div>

            </div>
        </div>

        <div class="box-product-set">
            <ul class="box-product-set-ul remove-ul-default-att">
                <li class="box-product-set-li remove-li-default-att">

                    <div class="box_product-wrap">
                        <div class="cart-element-wrap">
                            <div class="cart-element-inner">
                                <div class="cart-element-remove-button-block">
                                    <button class="cart-element-remove-button remove-button-default-att">
                                        <div class="plus_symbol-wrap">
                                            <span class="plus_symbol-vertical"></span>
                                            <span class="plus_symbol-horizontal"></span>
                                        </div>
                                    </button>
                                </div>

                                <div class="cart-element-detail-block">
                                    <div class="cart-element-img-div">
                                        <img src="outside/brain/prod/picture01.jpeg">
                                    </div>
                                    <div class="cart-element-property-set">
                                        <div class="cart-element-property-div">
                                            <span>essential double coat</span>
                                        </div>
                                        <div class="cart-element-property-div">

                                            <span class="cart-element-property">color: </span>
                                            <span class="cart-element-value" style="color: #AF3134;">red</span>
                                        </div>
                                        <div class="cart-element-property-div">
                                            <span class="cart-element-property">size: </span>
                                            <span class="cart-element-value">s</span>
                                        </div>
                                        <div class="cart-element-property-div">
                                            <span class="cart-element-property">quantity: </span>
                                            <span class="cart-element-value">2</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-element-edit-block">
                                    <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </li>
            </ul>
        </div>

    </div>

    <div class="basket_product-wrap">
        <div class="cart-element-wrap">
            <div class="cart-element-inner">
                <div class="cart-element-remove-button-block">
                    <button class="cart-element-remove-button remove-button-default-att">
                        <div class="plus_symbol-wrap">
                            <span class="plus_symbol-vertical"></span>
                            <span class="plus_symbol-horizontal"></span>
                        </div>
                    </button>
                </div>
                <div class="cart-element-detail-block">
                    <div class="cart-element-img-div">
                        <img src="outside/brain/prod/picture01.jpeg">
                    </div>
                    <div class="cart-element-property-set">
                        <div class="cart-element-property-div">
                            <span>essential double coat</span>
                        </div>
                        <div class="cart-element-property-div">

                            <span class="cart-element-property">color: </span>
                            <span class="cart-element-value" style="color: #AF3134;">red</span>
                        </div>
                        <div class="cart-element-property-div">
                            <span class="cart-element-property">size: </span>
                            <span class="cart-element-value">s</span>
                        </div>
                        <div class="cart-element-property-div">
                            <span class="cart-element-property">quantity: </span>
                            <span class="cart-element-value">2</span>
                        </div>
                    </div>
                </div>
                <div class="cart-element-edit-block">
                    <button class="cart-element-edit-button remove-button-default-att">edit</button>
                </div>
                <div class="cart-element-price-block">
                    <div class="cart-element-price-inner">
                        <span>$52.50 usd</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="safe_info-wrap">
        <ul class="safe_info-ul remove-ul-default-att">
            <li class="safe_info-li remove-li-default-att">
                <div class="img_text_down-wrap">
                    <div class="img_text_down-img-div">
                        <div class="img_text_down-img-inner">
                            <img src="outside/brain/permanent/icons8-card-security-150.png">
                        </div>
                    </div>
                    <div class="img_text_down-text-div">
                        <span>3D secure & <br>SSL encrypted payement</span>
                    </div>
                </div>
            </li>
            <li class="safe_info-li remove-li-default-att">
                <div class="img_text_down-wrap">
                    <div class="img_text_down-img-div">
                        <div class="img_text_down-img-inner">
                            <img src="outside/brain/permanent/icons8-headset-96.png">
                        </div>
                    </div>
                    <div class="img_text_down-text-div">
                        <span>customer service 24h/7 <br> response in 1h</span>
                    </div>
                </div>
            </li>
            <li class="safe_info-li remove-li-default-att">
                <div class="img_text_down-wrap">
                    <div class="img_text_down-img-div">
                        <div class="img_text_down-img-inner">
                            <img src="outside/brain/permanent/return-box.png">
                        </div>
                    </div>
                    <div class="img_text_down-text-div">
                        <span>free & <br>easy return</span>
                    </div>
                </div>
            </li>


        </ul>
    </div>

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

    <button class="close_button-wrap remove-button-default-att">
        <div class="plus_symbol-wrap">
            <span class="plus_symbol-vertical"></span>
            <span class="plus_symbol-horizontal"></span>
        </div>
    </button>

    <div class="pop_up-wrap">
        <div class="pop_up-window">
            <div class="pop_up-inner">
                <div class="pop_up-title-block">
                    <div class="pop_up-title-div">
                        <span class="form-title">brand references</span>
                    </div>
                    <div class="pop_up-close-button-div">
                        <button class="close_button-wrap remove-button-default-att">
                            <div class="plus_symbol-wrap">
                                <span class="plus_symbol-vertical"></span>
                                <span class="plus_symbol-horizontal"></span>
                            </div>
                        </button>
                    </div>
                </div>
                <hr class="hr-summary">
                <div class="pop_up-content-block">
                    <div class="brand_reference-info-div">
                        <p>Indicate your measurements:</p>
                    </div>
                    <!-- pop up's content -->
                    <div class="pop_up-validate_button-div">
                        <button id="" class="green-arrow remove-button-default-att">validate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>









</body>

</html>