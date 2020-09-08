<?php
require_once 'model/boxes-management/Box.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Translator $translator to translate
 * @param Box $box the box to display
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param string $dadx selector of the dad (if set it activate the select fonctionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 */

if (empty($dadx)) {
    $dadx = null;
    $brotherx = null;
    $submitdata = null;
}

/**
 * @var Price
 */
$price = $box->getPriceFormated();
?>
<div class="box-wrap">
    <div class="box-display-block">
        <?php
        $datas = [
            "translator" => $translator,
            "title" => $translator->translateString($box->getColor()),
            "color" => null,
            "colorRGB" => null,
            "nbItem" => $box->getNbProduct(),
            "max" => $box->getSizeMax(),
            "price" => $price
        ];
        $properties = $this->generateFile('view/elements/cartElementProperties.php', $datas);
        $datas = [
            "properties" => $properties,
            "price" => $price,
            "pictureSrc" => $box->getPictureSource(),
            "dadx" => $dadx,
            "brotherx" => $brotherx,
            "submitdata" => $submitdata
        ];
        echo $this->generateFile('view/elements/cartElement.php', $datas);
        ?>
    </div>
    <div class="box-product-set" style="display: none;">
        <ul class="box-product-set-ul remove-ul-default-att">
            <li class="box-product-set-li remove-li-default-att">
                <div class="box_product-wrap">
                    <?php
                    $products = $box->getBoxProducts();

                    foreach ($products as $product) {
                        $datas = [
                            "translator" => $translator,
                            "product" => $product,
                            "country" => $country,
                            "currency" => $currency,
                            "showArow" => false
                        ];
                        echo $this->generateFile('view/elements/cartElementProduct.php', $datas);
                    }
                    ?>
                </div>
            </li>
        </ul>
    </div>
</div>