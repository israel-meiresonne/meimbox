<!-- cart -->
<?php

require_once "../../../oop/controller/Dependency.php";
Dependency::requireControllerDependencies("../../../");

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
    <!-- <script src="outside/js/item.js"></script> -->
    <link rel="stylesheet" href="outside/css/cart.css">
</head>

<body>
    <header>
        <?php
        echo $controller->getComputerHeader();
        echo $controller->getMobileHeader();
        echo $controller->getConstants();
        ?>
    </header>

    <div class="cart_page-container">
        <div class="cart_page-inner">
            <div class="directory-wrap">
                <p>dashboard \ cart</p>
            </div>

            <div class="cart-cart_summary-block">
                <div class="cart-cart_summary-inner">

                    <div class="cart-div-container">
                        <div class="cart-div-inner">
                            <div class="cart-wrap">
                                <ul class="remove-ul-default-att">

                                    <li class="li-cart-element-container remove-li-default-att">
                                        <div class="basket_product-wrap">
                                            <div class="cart-element-wrap">
                                                <div class="cart-element-inner">
                                                    <div class="cart-element-remove-button-block">
                                                        <button class="close_button-wrap remove-button-default-att">
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
                                                            <div class="cart-element-property-div cart-element-property-price-div">
                                                                <span class="cart-element-property">price: </span>
                                                                <span class="cart-element-value">$52.50 usd</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cart-element-edit-block">
                                                        <div class="cart-element-edit-inner">
                                                            <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                        </div>
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
                                            <div class="box-display-block">
                                                <div class="cart-element-wrap">
                                                    <div class="cart-element-inner">
                                                        <div class="cart-element-remove-button-block">
                                                            <button class="close_button-wrap remove-button-default-att">
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
                                                                    <div class="cart-element-property-div cart-element-property-price-div">
                                                                        <span class="cart-element-property">price: </span>
                                                                        <span class="cart-element-value">$52.50 usd</span>
                                                                    </div>
                                                                    <div class="cart-element-property-div cart-element-property-edit-div">
                                                                        <div class="cart-element-edit-block">
                                                                            <div class="cart-element-edit-inner">
                                                                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="cart-element-edit-block edit-block-external">
                                                            <div class="cart-element-edit-inner">
                                                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                            </div>
                                                        </div>

                                                        <div class="cart-element-price-block">
                                                            <div class="cart-element-price-inner">
                                                                <span>$52.50 usd</span>
                                                            </div>
                                                        </div>

                                                        <div class="cart-element-arrow-block">
                                                            <div class="cart-element-arrow-inner">
                                                                <button class="cart-element-arrow-button remove-button-default-att">
                                                                    <div class="arrow-element-wrap">
                                                                        <span class="arrow-span"></span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>

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
                                                                        <button class="close_button-wrap remove-button-default-att">
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
                                                                        <div class="cart-element-edit-inner">
                                                                            <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                    <li class="box-product-set-li remove-li-default-att">

                                                        <div class="box_product-wrap">
                                                            <div class="cart-element-wrap">
                                                                <div class="cart-element-inner">
                                                                    <div class="cart-element-remove-button-block">
                                                                        <button class="close_button-wrap remove-button-default-att">
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
                                                                        <div class="cart-element-edit-inner">
                                                                            <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                    <li class="box-product-set-li remove-li-default-att">

                                                        <div class="box_product-wrap">
                                                            <div class="cart-element-wrap">
                                                                <div class="cart-element-inner">
                                                                    <div class="cart-element-remove-button-block">
                                                                        <button class="close_button-wrap remove-button-default-att">
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
                                                                        <div class="cart-element-edit-inner">
                                                                            <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                        </div>
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
                                            <div class="box-display-block">
                                                <div class="cart-element-wrap">
                                                    <div class="cart-element-inner">
                                                        <div class="cart-element-remove-button-block">
                                                            <button class="close_button-wrap remove-button-default-att">
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
                                                                    <div class="cart-element-property-div cart-element-property-price-div">
                                                                        <span class="cart-element-property">price: </span>
                                                                        <span class="cart-element-value">$52.50 usd</span>
                                                                    </div>
                                                                    <div class="cart-element-property-div cart-element-property-edit-div">
                                                                        <div class="cart-element-edit-block">
                                                                            <div class="cart-element-edit-inner">
                                                                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="cart-element-edit-block edit-block-external">
                                                            <div class="cart-element-edit-inner">
                                                                <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                            </div>
                                                        </div>

                                                        <div class="cart-element-price-block">
                                                            <div class="cart-element-price-inner">
                                                                <span>$52.50 usd</span>
                                                            </div>
                                                        </div>

                                                        <div class="cart-element-arrow-block">
                                                            <div class="cart-element-arrow-inner">
                                                                <button class="cart-element-arrow-button remove-button-default-att">
                                                                    <div class="arrow-element-wrap">
                                                                        <span class="arrow-span"></span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>

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
                                                                        <button class="close_button-wrap remove-button-default-att">
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
                                                                        <div class="cart-element-edit-inner">
                                                                            <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                    <li class="box-product-set-li remove-li-default-att">

                                                        <div class="box_product-wrap">
                                                            <div class="cart-element-wrap">
                                                                <div class="cart-element-inner">
                                                                    <div class="cart-element-remove-button-block">
                                                                        <button class="close_button-wrap remove-button-default-att">
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
                                                                        <div class="cart-element-edit-inner">
                                                                            <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                    <li class="box-product-set-li remove-li-default-att">

                                                        <div class="box_product-wrap">
                                                            <div class="cart-element-wrap">
                                                                <div class="cart-element-inner">
                                                                    <div class="cart-element-remove-button-block">
                                                                        <button class="close_button-wrap remove-button-default-att">
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
                                                                        <div class="cart-element-edit-inner">
                                                                            <button class="cart-element-edit-button remove-button-default-att">edit</button>
                                                                        </div>
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
                        </div>
                    </div>

                    <div class="cart_summary-div-container">
                        <div class="summary-wrap">
                            <div class="summary-detail-block">
                                <div class="summary-detail-title-block">
                                    <div class="summary-detail-title-div">
                                        <span class="summary-title">Order Summary</span>
                                    </div>
                                    <div class="summary-detail-arrow-button-div">
                                        <div class="summary-detail-arrow-button-inner">
                                            <button class="summary-detail-arrow-button remove-button-default-att">
                                                <div class="arrow-element-wrap">
                                                    <span class="arrow-span"></span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="summary-detail-inner">
                                    <hr class="hr-summary">
                                    <div class="summary-detail-property-div">
                                        <ul class="summary-detail-property-lu remove-ul-default-att">
                                            <li class="summary-detail-property-li remove-li-default-att">
                                                <div class="data-key_value-opposite-wrap">
                                                    <span class="data-key_value-key">total: </span>
                                                    <span class="data-key_value-value">$82.09 usd</span>
                                                </div>
                                            </li>
                                            <li class="summary-detail-property-li remove-li-default-att">
                                                <div class="summary-detail-property-shipping-div">

                                                    <div class="summary-detail-property-country">
                                                        <div class="dropdown-container">
                                                            <div class="dropdown-wrap">
                                                                <div class="dropdown-inner">
                                                                    <div class="dropdown-head dropdown-arrow-close">
                                                                        <span class="dropdown-title">country</span>
                                                                    </div>
                                                                    <div class="dropdown-checkbox-list">
                                                                        <div class="dropdown-checkbox-block">
                                                                            <label class="checkbox-label">belgium
                                                                                <input type="radio" name="country">
                                                                                <span class="checkbox-checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="dropdown-checkbox-block">
                                                                            <label class="checkbox-label">france
                                                                                <input type="radio" name="country">
                                                                                <span class="checkbox-checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="dropdown-checkbox-block">
                                                                            <label class="checkbox-label">switzerland
                                                                                <input type="radio" name="country">
                                                                                <span class="checkbox-checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="summary-detail-property-shipping-div">
                                                        <div class="data-key_value-opposite-wrap">
                                                            <span class="data-key_value-key">shipping: </span>
                                                            <span class="data-key_value-value" style="text-transform:initial;">(Select a country)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="summary-detail-property-li remove-li-default-att">
                                                <div class="data-key_value-opposite-wrap">
                                                    <span class="data-key_value-key">
                                                        <span style="text-transform: uppercase;">VAT</span>
                                                        <span style="text-transform: lowercase">(included): </span>
                                                    </span>
                                                    <span class="data-key_value-value">$14.25 usd</span>
                                                </div>
                                            </li>
                                            <li class="summary-detail-property-li remove-li-default-att">
                                                <div class="data-key_value-opposite-wrap">
                                                    <span class="data-key_value-key">subtotal: </span>
                                                    <span class="data-key_value-value">$82.09 usd</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="summary-detail-button-div">
                                        <div class="summary-detail-button-inner">
                                            <button class="green-button remove-button-default-att">checkout</button>
                                        </div>
                                    </div>

                                    <div class="summary-detail-safe_info-div">
                                        <div class="summary-detail-safe_info-inner">
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
                                                    <li class="safe_info-li remove-li-default-att">
                                                        <div class="img_text_down-wrap">
                                                            <div class="img_text_down-img-div">
                                                                <div class="img_text_down-img-inner">
                                                                    <img src="outside/brain/permanent/icons8-van-96.png">
                                                                </div>
                                                            </div>
                                                            <div class="img_text_down-text-div">
                                                                <span>Track your<br> orders online</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="summary-detail-collapse-div">
                                        <div class="summary-detail-collapse-inner">

                                            <div class="collapse-wrap">
                                                <ul class="remove-ul-default-att">
                                                    <li class="remove-li-default-att">

                                                        <div class="collapse-div">
                                                            <div class="collapse-title-div">
                                                                <div class="collapse-title">contact us</div>
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

                                                                    <ul class="contact-ul remove-ul-default-att">
                                                                        <li class="contact-li remove-li-default-att">

                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/icons8-phone-100.png">
                                                                                </div>
                                                                                <span class="img-text-span">+472 13 13 24</span>
                                                                            </div>

                                                                        </li>
                                                                        <li class="contact-li remove-li-default-att">

                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/icons8-secured-letter-100.png">
                                                                                </div>
                                                                                <span class="img-text-span">email@monsite.com</span>
                                                                            </div>

                                                                        </li>
                                                                    </ul>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                    <li class="remove-li-default-att">
                                                        <div class="collapse-div">
                                                            <div class="collapse-title-div">
                                                                <div class="collapse-title">payement options</div>
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

                                                                    <ul class="payement-ul remove-ul-default-att">
                                                                        <li class="payement-li remove-li-default-att">
                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/visa-logo.png">
                                                                                </div>
                                                                                <span class="img-text-span">visa</span>
                                                                            </div>
                                                                        </li>
                                                                        <li class="payement-li remove-li-default-att">
                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/apple-pay-logo.png">
                                                                                </div>
                                                                                <span class="img-text-span">pay</span>
                                                                            </div>
                                                                        </li>
                                                                        <li class="payement-li remove-li-default-att">
                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/paypal.png">
                                                                                </div>
                                                                                <span class="img-text-span">paypal</span>
                                                                            </div>
                                                                        </li>
                                                                        <li class="payement-li remove-li-default-att">
                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/master-card.png">
                                                                                </div>
                                                                                <span class="img-text-span">masterCard</span>
                                                                            </div>
                                                                        </li>
                                                                        <li class="payement-li remove-li-default-att">
                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/maestro.png">
                                                                                </div>
                                                                                <span class="img-text-span">maestro</span>
                                                                            </div>
                                                                        </li>
                                                                        <li class="payement-li remove-li-default-att">
                                                                            <div class="img-text-wrap">
                                                                                <div class="img-text-img">
                                                                                    <img src="outside/brain/permanent/amex.png">
                                                                                </div>
                                                                                <span class="img-text-span">american express</span>
                                                                            </div>
                                                                        </li>
                                                                    </ul>

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

                </div>

            </div>
        </div>





</body>

</html>