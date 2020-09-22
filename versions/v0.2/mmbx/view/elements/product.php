<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param BasketProduct|BoxProduct $product a product to display
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */

/**
 * @var BasketProduct|BoxProduct
 */
$product = $product;

$prodID = $product->getProdID();
// $pictures = $product->getPictures();
$pictures = $product->getPictureSources();
$colorRGB = $product->getColorRGB();
$colorRGBText = $product->getColorRGBText();
// $cubeBorder = ($colorRGB == Product::WHITE_RGB) ? "cube-border" : "";
?>

<article class="product-article-wrap">
    <div class="product-img-set">
        <!-- <a href="/inside/item/?prodID=<?= $prodID ?>"> -->
        <a href="<?= $product->getUrl(Product::PAGE_ITEM) ?>">
            <?php
            $i = 0;
            foreach ($pictures as $picture) :
                switch ($i) {
                    case 0:
            ?>
                        <div class="product-img-wrap product-img-first">
                            <!-- <img src="content/brain/prod/<?= $picture ?>"> -->
                            <img src="<?= $picture ?>">
                        </div>
                    <?php
                        $i++;
                        break;
                    case 1;
                    ?>
                        <div class="product-img-wrap product-img-second">
                            <!-- <img src="content/brain/prod/<?= $picture ?>"> -->
                            <img src="<?= $picture ?>">
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
                <span><?= $translator->translateString($product->getProdName()) ?> | <span style="color:<?= $colorRGBText ?>;"><?= $product->getColorName() ?></span></span>
            </h4>
        </div>
        <div class="detail-price-div">
            <?= $product->getDisplayablePrice($country, $currency) ?>
        </div>
        <div class="detail-color-div">
            <ul class="remove-ul-default-att">
                <li class="remove-li-default-att">
                    <div class="cube-container">
                        <!-- <a href="/inside/item/?prodID=<?= $prodID ?>"> -->
                        <a href="<?= $product->getUrl(Product::PAGE_ITEM) ?>">
                            <div class="cube-wrap cube-selected">
                                <div class="cube-item-color" style="background: <?= $colorRGB ?>;"></div>
                            </div>
                        </a>
                    </div>
                </li>
                <?php
                $maxCube = Product::getMAX_PRODUCT_CUBE_DISPLAYABLE() - 1;
                $sameProducts = $product->getSameProducts();
                $datas = [
                    "products" => $sameProducts,
                    "maxCube" => $maxCube,
                    "prodID" => null
                ];
                echo $this->generateFile("view/elements/productCube.php", $datas);
                ?>
            </ul>
        </div>
    </div>
</article>