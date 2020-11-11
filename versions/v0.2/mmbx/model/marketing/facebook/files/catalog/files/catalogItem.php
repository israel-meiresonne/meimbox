<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string                    $url_DomainWebroot  url like https://domain.dom/web/root/
 * @param BasketProduct|BoxProduct  $product            products of the catalog
 * @param Map                       $company            datas about company
 */

/**
 * @var Product */
$product = $product;
/**
 * @var Map */
$company = $company;
$prodID = $product->getProdID();
$prodName = $product->getProdName();
$priceObj = $product->getPrice();
$description = $product->getDescription();
$price = $priceObj->getPrice() . " " . $priceObj->getCurrency()->getIsoCurrency();
$link = $url_DomainWebroot . $product->getUrlPath(Product::PAGE_ITEM);
$picPaths = $product->getPictureSources();
$picPathsReverse = array_reverse($picPaths);
$firstpicPath = array_pop($picPathsReverse);
$image_link = $url_DomainWebroot . $firstpicPath;
$brand = strtoupper($company->get(Map::brand));
$availability = $product->getAvailability();
$condition = "new"; // new (neuf), refurbished (reconditionné), used (d’occasion)
$google_product_category = $product->getForeignCategory(Product::CATEGORY_GOOGLE);
$additional_image_links = null;
if (count($picPaths) > 1) {
    $additional_image_links = "";
    $picPathsStilling = array_reverse($picPathsReverse);
    foreach ($picPathsStilling as $path) {
        $img_url = $url_DomainWebroot . $path;
        $additional_image_links .= "<g:additional_image_link>$img_url</g:additional_image_link>";
        $additional_image_links .= "\n";
    }
}
$color = $product->getColorName();
$item_group_id = $product->getProdName();
$category = (!empty($product->getCategories())) ? $product->getCategories()[0] : null;
$product_type = (!empty($category)) ? "<g:product_type>$category</g:product_type>" : null;
$size = implode(", ", $product->getSizes());
// $richDescription = $product->getRichDescription();
// $rich_text_description = (!empty($richDescription)) ? "<g:rich_text_description>$richDescription</g:rich_text_description>" : null;

?>
<item>
    <?php //<!-- Required fields down --> 
    ?>
    <g:id><?= $prodID ?></g:id>
    <g:title><?= $prodName ?></g:title>
    <g:description><?= $description ?></g:description>
    <g:availability><?= $availability ?></g:availability>
    <g:condition><?= $condition ?></g:condition>
    <g:price><?= $price ?></g:price>
    <g:link><?= $link ?></g:link>
    <g:image_link><?= $image_link ?></g:image_link>
    <g:brand><?= $brand ?></g:brand>
    <?php //<!-- Required fields for paiements down -->
    ?>
    <g:google_product_category><?= $google_product_category ?></g:google_product_category>
    <?php
    // <!-- <g:inventory></g:inventory> required to sell through FB's medias -->
    ?>
    <?php //<!-- Optional fields down -->
    ?>
    <?= $additional_image_links ?>
    <g:age_group>all ages</g:age_group>
    <g:color><?= $color ?></g:color>
    <g:item_group_id><?= $item_group_id ?></g:item_group_id>
    <g:size><?= $size ?></g:size>
    <?= $product_type ?>
    <?php
    //$rich_text_description
    // <!-- <g:gender>female, male, unisex  </g:gender> -->
    // <!-- <g:material>cotton, denim, leather  </g:material> -->
    // <g:rich_text_description>
    //     <b>, <i>, <em>, <strong>, <header>
    //                         <h1> thru <h6> <br>, <p>, <ul>, and <li>
    //     </g:rich_text_description>
    ?>
</item>