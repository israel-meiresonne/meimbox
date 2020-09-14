<?php
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerId id of the tag that contain datas generated
 * @param BoxProduct|BasketProduct $product a boxproduct to display
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param boolean $showArrow set true to display the row else set false
 * @param string $elementId id of the element (allway given)
 * + this id is generated in file cart.php
 * @param string $dadx selector of the dad (if set it activate the select fonctionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 */
/**
 * @var Price
 */
$price = null;
$showArrow = false;

switch ($product->getType()) {
    case BasketProduct::BASKET_TYPE:
        $prodClass = "basket_product-wrap";
        $price = $product->getFormatedPrice();
        if (empty($dadx)) {
            $dadx = null;
            $brotherx = null;
            $submitdata = null;
        }
        break;
    case BoxProduct::BOX_TYPE:
        $prodClass = "box_product-wrap";
        $dadx = null;
        $brotherx = null;
        $submitdata = null;
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
        "price" => $price,
        "showArrow" => $showArrow,
        "elementId" => $elementId,
        "dadx" => $dadx,
        "brotherx" => $brotherx,
        "submitdata" => $submitdata
    ];
    echo $this->generateFile('view/elements/cartElement.php', $datas);
    ?>
</div>