<?php
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param BoxProduct|BasketProduct $product a boxproduct to display
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 */
switch($product->getType()){
    case BasketProduct::BASKET_TYPE:
        $prodClass = "basket_product-wrap";
    break;
    case BoxProduct::BOX_TYPE:
        $prodClass = "box_product-wrap";
    break;
}
$size = $product->getSelectedSize();
?>
<div class="<?= $prodClass ?>">
    <?php
    $datas = [
        "title" => $product->getProdName(),
        "color" => $product->getColorName(),
        "colorRGB" => $product->getColorName(),
        "size" => $product->getSelectedSize(),
        "item" => null,
        "quantity" => $product->getQuantity(),
        "price" => $product->getDisplayablePrice($country, $currency)
    ];
    $properties = $this->generateFile('view/elements/cartElementProperties.php', $datas);
    $datas = [
        "properties" => $properties,
        "picture" => $product->getPictures()[0]
    ];
    echo $this->generateFile('view/elements/cartElement.php', $datas);
    ?>
</div>