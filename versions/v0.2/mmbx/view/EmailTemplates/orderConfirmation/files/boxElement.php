<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $https_webroot https://mydomain.com + webroot
 * @param Box $box the box to display
 */

$boxPropMap = new Map();
// $link = 
$price = $box->getPrice()->getFormated();
$picture = $https_webroot . $box->getPictureSource();
$name = $translator->translateString($box->getColor());
$propertiesMap = new Map();
$nbItem = $box->getQuantity();
$max = $box->getSizeMax();
$propertiesMap->put($nbItem, Map::nbItem);
$propertiesMap->put($max, Map::max);
$boxPropMap->put($price, Map::price);
$boxPropMap->put($picture, Map::picture);
$boxPropMap->put($name, Map::name);
$boxPropMap->put($propertiesMap, Map::properties);
$boxDatas = [
    "element" => $boxPropMap,
];
echo $this->generateFile('view/EmailTemplates/orderConfirmation/files/emailElement.php', $boxDatas);