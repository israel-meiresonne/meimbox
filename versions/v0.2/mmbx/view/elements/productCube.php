<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param BasketProduct|BoxProduct $products list of products with only the constructor properties set
 * @param int $maxCube maximum number of cube displayable before to display a plus symbol
 * @param int $prodID the id of the selected cube
 */



// $products = $product->getSameProducts();
$i = 1;
// $maxCube = Product::getMAX_PRODUCT_CUBE_DISPLAYABLE() - 1;
foreach ($products as $product) :
    $sameColorRGB = $product->getColorRGB();
    $sameCubeBorder = ($product->getColorRGB() == Product::WHITE_RGB) ? "cube-border" : "";
    $selectedCube = ($prodID == $product->getProdID()) ? ' cube-selected' : "";
    if ((!isset($maxCube)) || ($i < $maxCube)) :
?>
        <li class="remove-li-default-att">
            <div class="cube-container">
                <div class="cube-wrap <?= $selectedCube ?>">
                    <!-- <a href="/inside/item/?prodID=<?= $product->getProdID() ?>"> -->
                    <a href="<?= $product->getUrl(Product::PAGE_ITEM) ?>">
                        <div class="cube-item-color <?= $sameCubeBorder ?>" style="background: <?= $sameColorRGB ?>;"></div>
                    </a>
                </div>
            </div>
        </li>
    <?php
    else :
    ?>
        <li class="remove-li-default-att">
            <div class="cube-container">
                <div class="cube-wrap">
                    <!-- <a href="/inside/item/?prodID=<?= $product->getProdID() ?>"> -->
                    <a href="<?= $product->getUrl(Product::PAGE_ITEM) ?>">
                        <div class="cube-item-color cube-more_color">
                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-plus-math-96.png">
                        </div>
                    </a>
                </div>
            </div>
        </li>
<?php break;
    endif;
    $i++;
endforeach; ?>