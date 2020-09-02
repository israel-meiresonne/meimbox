<?php
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Translator $translator to translate
 * @param Box[]|BasketProduct[] $elements user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */
?>
<div class="cart-wrap">
    <ul class="remove-ul-default-att">
        <?php foreach ($elements as $element) : ?>
            <li class="li-cart-element-container remove-li-default-att">
                <?php
                switch (get_class($element)) {
                    case BasketProduct::class:
                        $datas = [
                            "product" => $element,
                            "country" => $country,
                            "currency" => $currency
                        ];
                        echo $this->generateFile('view/elements/cartElementProduct.php', $datas);
                        break;
                    case Box::class:
                        $datas = [
                            "translator" => $translator,
                            "box" => $element,
                            "country" => $country,
                            "currency" => $currency
                        ];
                        echo $this->generateFile('view/elements/cartElementBox.php', $datas);
                        break;
                }
                ?>
                <!-- <div class="basket_product-wrap">
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
            </div> -->
            </li>
        <?php endforeach; ?>
        <!-- <li class="li-cart-element-container remove-li-default-att">
            <div class="box-wrap">
                <div class="box-display-block">
                    <div class="cart-element-wrap" style="box-shadow: var(--box-shadow-right);">
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

                <div class="box-product-set" style="display: block;">
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
        </li> -->

    </ul>
</div>