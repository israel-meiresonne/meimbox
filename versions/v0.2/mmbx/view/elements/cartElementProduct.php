<?php
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Translator $translator to translate
 * @param BoxProduct|BasketProduct $product a boxproduct to display
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param boolean $showRow set true to display the row else set false
 */
/**
 * @var Price
 */
$price = null;
switch($product->getType()){
    case BasketProduct::BASKET_TYPE:
        $prodClass = "basket_product-wrap";
        $price = $product->getFormated();
    break;
    case BoxProduct::BOX_TYPE:
        $prodClass = "box_product-wrap";
    break;
}
$size = $product->getSelectedSize();
?>
<div class="<?= $prodClass ?>">
    <?php
    $sizeObj = $product->getSelectedSize();
    $datas = [
        "translator" => $translator,
        "title" => $product->getProdName(),
        "color" => $translator->translateString($product->getColorName()),
        "colorRGB" => $product->getColorRGB(),
        "size" => $sizeObj->getsize(),
        "brand" => $sizeObj->getbrandName(),
        "measure" => $sizeObj->getmeasure(),
        "cut" => $sizeObj->getcut(),
        "quantity" => $product->getQuantity(),
        "price" => $price
    ];
    $properties = $this->generateFile('view/elements/cartElementProperties.php', $datas);
    $pictureSrcs = $product->getPictureSources();
    krsort($pictureSrcs);
    $datas = [
        "properties" => $properties,
        "pictureSrc" => (count($pictureSrcs) > 0) ? array_pop(($pictureSrcs)) : null,
        "showRow" => $showRow
    ];
    echo $this->generateFile('view/elements/cartElement.php', $datas);
    ?>
</div>