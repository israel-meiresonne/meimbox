<?php
require_once 'model/boxes-management/Box.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Translator $translator to translate
 * @param Box $box the box to display
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */
/**
 * @var Price
 */
$price = $box->getPriceFormated();
?>
<div class="box-wrap">
    <div class="box-display-block">
        <?php
            $datas = [
                "translator" => $translator,
                "title" => $translator->translateString($box->getColor()),
                "color" => null,
                "colorRGB" => null,
                // "size" => $size,
                // "size" => "size",
                "nbItem" => $box->getNbProduct(),
                "max" => $box->getSizeMax(),
                "price" => $price
            ];
            $properties = $this->generateFile('view/elements/cartElementProperties.php', $datas);
            $datas = [
                "properties" => $properties,
                "price" => $price,
                "pictureSrc" => $box->getPictureSource()
            ];
            echo $this->generateFile('view/elements/cartElement.php', $datas);
        ?>
        <!-- <div class="cart-element-wrap" style="box-shadow: var(--box-shadow);">
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
                        <img src="content/brain/permanent/box-gold-128.png">
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
        </div> -->
    </div>
    <div class="box-product-set" style="display: none;">
        <ul class="box-product-set-ul remove-ul-default-att">
            <li class="box-product-set-li remove-li-default-att">
                <div class="box_product-wrap">
                    <?php
                    $products = $box->getBoxProducts();

                    foreach($products as $product){
                        $datas = [
                            "translator" => $translator,
                            "product" => $product,
                            "country" => $country,
                            "currency" => $currency,
                            "showRow" => false
                        ];
                        echo $this->generateFile('view/elements/cartElementProduct.php', $datas);
                    }
                    ?>
                    <!-- <div class="cart-element-wrap">
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
                                    <img src="content/brain/prod/picture01.jpeg">
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
                    </div> -->
                </div>
            </li>
            <!-- <li class="box-product-set-li remove-li-default-att">
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
                                    <img src="content/brain/prod/picture01.jpeg">
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
                                    <img src="content/brain/prod/picture01.jpeg">
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
            </li> -->
        </ul>
    </div>
</div>