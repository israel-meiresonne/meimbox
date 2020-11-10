<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Box $product the box to display
 */

$boxProdPropMap = new Map();
$link = self::$HTTPS_WEBROOT . $product->getUrlPath(Product::PAGE_ITEM);
$price = $product->getPrice()->getFormated();
$srcs = array_reverse($product->getPictureSources());
$picture = self::$HTTPS_WEBROOT . array_pop($srcs);
$name = $translator->translateString($product->getProdName());

$propertiesMap = new Map();
$color = $translator->translateString($product->getColorName());
$selectedSize = $product->getSelectedSize();
$size = $selectedSize->getsize();
$brand = $selectedSize->getbrandName();

$measure = $selectedSize->getmeasure();
$measureName = (!empty($measure)) ? $measure->getMeasureName() : null;

$cut = $selectedSize->getCut();
$quantity = $selectedSize->getQuantity();
$propertiesMap->put($color, Map::color);
$propertiesMap->put($size, Map::size);
$propertiesMap->put($brand, Map::brand);
$propertiesMap->put($measureName, Map::measureName);
$propertiesMap->put($cut, Map::cut);
$propertiesMap->put($quantity, Map::quantity);
$boxProdPropMap->put($link, Map::link);
$boxProdPropMap->put($price, Map::price);
$boxProdPropMap->put($picture, Map::picture);
$boxProdPropMap->put($name, Map::name);
$boxProdPropMap->put($propertiesMap, Map::properties);
$boxProdDatas = [
    "element" => $boxProdPropMap,
];
echo $this->generateFile('view/EmailTemplates/orderConfirmation/files/emailElement.php', $boxProdDatas);
