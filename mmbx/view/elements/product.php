<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param BasketProduct|BoxProduct $product a product with all its properties set
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */

/**
 * @var BasketProduct|BoxProduct
 */
$product = $product;
$prodID = $product->getProdID();
$pictures = $product->getPictures();
$colorRGB = $product->getColorRGB();
$cubeBorder = ($colorRGB == Product::WHITE_RGB) ? "cube-border" : "";
?>

<article class="product-article-wrap">
    <div class="product-img-set">
        <a href="/inside/item/?prodID=<?= $prodID ?>">
            <?php
            $i = 0;
            foreach ($pictures as $picture) :
                switch ($i) {
                    case 0:
            ?>
                        <div class="product-img-wrap product-img-first">
                            <img src="content/brain/prod/<?= $picture ?>">
                        </div>
                    <?php
                        $i++;
                        break;
                    case 1;
                    ?>
                        <div class="product-img-wrap product-img-second">
                            <img src="content/brain/prod/<?= $picture ?>">
                        </div>
            <?php
                        $i++;
                        break;
                }
            endforeach;
            ?>
        </a>
    </div>
    <div class="product-detail-block">
        <div class="detail-text-div">
            <h4>
                <span><?= $translator->translateString($product->getProdName()) ?> | <span style="color:<?= $colorRGB ?>;"><?= $product->getColorName() ?></span></span>
            </h4>
        </div>
        <div class="detail-price-div">
            <?= $product->getDisplayablePrice($country, $currency) ?>
        </div>
        <div class="detail-color-div">
            <ul class="remove-ul-default-att">
                <li class="remove-li-default-att">
                    <div class="cube-container">
                        <a href="/inside/item/?prodID=<?= $prodID ?>">
                            <div class="cube-wrap cube-selected">
                                <div class="cube-item-color <?= $cubeBorder ?>" style="background: <?= $colorRGB ?>;"></div>
                            </div>
                        </a>
                    </div>
                </li>
                <?php
                $sameProducts = $product->getSameProd();
                $i = 0;
                $maxCube = Product::getMAX_PRODUCT_CUBE_DISPLAYABLE();
                foreach ($sameProducts as $sameNameProduct) : // $i = 1 + 5 + 1
                    $sameColorRGB = $sameNameProduct->getColorRGB();
                    $sameCubeBorder = ($sameNameProduct->getColorRGB() == Product::WHITE_RGB) ? "cube-border" : "";
                    if ($i <= $maxCube) {
                ?>
                        <li class="remove-li-default-att">
                            <div class="cube-container">
                                <div class="cube-wrap">
                                    <a href="/inside/item/?prodID=<?= $sameNameProduct->getProdID() ?>">
                                        <div class="cube-item-color <?= $sameCubeBorder ?>" style="background: <?= $sameColorRGB ?>;"></div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="remove-li-default-att">
                            <div class="cube-container">
                                <div class="cube-wrap">
                                    <a href="/inside/item/?prodID=<?= $sameNameProduct->getProdID() ?>">
                                        <div class="cube-item-color cube-more_color">
                                            <img src="content/brain/permanent/icons8-plus-math-96.png">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                <?php break;
                    }
                    $i++;
                endforeach; ?>
            </ul>
        </div>
    </div>
</article>