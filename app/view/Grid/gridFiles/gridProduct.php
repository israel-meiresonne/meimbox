<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param BasketProduct|BoxProduct $products list of products with all their properties set
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */
if (((is_array($products) || is_object($products)) && (count($products) > 0))) :
    foreach ($products as $product) :
?>
        <li class="remove-li-default-att article-li">
            <?php
            ob_start();
            require 'view/elements/product.php';
            echo ob_get_clean();
            ?>
        </li>
    <?php endforeach;
else : ?>
    <h1><?= $translator->translateStation("US51") ?></h1>
<?php endif; ?>