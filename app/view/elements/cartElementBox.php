<?php
require_once 'model/boxes-management/Box.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerId id of the tag that contain datas generated
 * @param Box $box the box to display
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param string $elementId id of the element (allway given)
 * @param string $dadx selector of the dad (if set it activate the select fonctionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 */

/**
 * @var Box
 */
$box = $box;
if (empty($dadx)) {
    $dadx = null;
    $brotherx = null;
    $submitdata = null;
}

$containerIdx = "#" . $containerId;
$boxID = $box->getBoxID();
$elementIdx = "#" . $elementId;

/** Event */
$eventDatas = [Box::KEY_BOX_ID=>$box->getBoxID()];
$eventJson = htmlentities(json_encode($eventDatas));
$detailAttr = "data-evtcd='evt_cd_71'  data-evtj='$eventJson'";
/**
 * @var Price
 */
$price = $box->getPriceFormated();
?>
<div class="box-wrap">
    <div class="box-display-block">
        <?php
        /*———————————————————————— GET PROPERTIES DOWN ——————————————————————*/
        $datas = [
            // "class" => get_class($box),
            "title" => $box->getColor(),
            "color" => null,
            "colorRGB" => null,
            "nbItem" => $box->getQuantity(),
            "max" => $box->getSizeMax(),
            "price" => $price
        ];
        $properties = $this->generateFile('view/elements/cartElementProperties.php', $datas);
        /*———————————————————————— GET PROPERTIES UP ————————————————————————*/
        $boxBodyId = ModelFunctionality::generateDateCode(25);
        // $boxBodyx = "#" . $boxBodyId;


        $datas = [
            "elementId" => $elementId,
            "deleteFunc" => "removeBox(this,'$boxID','$elementIdx')",
            "properties" => $properties,
            "price" => $price,
            "pictureSrc" => $box->getPictureSource(),
            "boxBodyId" => $boxBodyId,
            "dadx" => $dadx,
            "brotherx" => $brotherx,
            "submitdata" => $submitdata,
            "eventDatas" => $eventDatas,
            "detailAttr" => $detailAttr
        ];
        echo $this->generateFile('view/elements/cartElement.php', $datas);
        ?>
    </div>
    <div id="<?= $boxBodyId ?>" class="box-product-set">
        <ul class="box-product-set-ul remove-ul-default-att">
            <?php
            $products = $box->getProducts();
            foreach ($products as $product) :
                $boxElementId = $elementId;
                $prodElementId  = ModelFunctionality::generateDateCode(25);
            ?>
                <li id="<?= $prodElementId ?>" class="box-product-set-li remove-li-default-att">
                    <?php
                    $datas = [
                        "containerId" => $containerId,
                        "elementId" => $prodElementId,
                        "boxElementId" => $boxElementId,
                        "product" => $product,
                        "box" => $box,
                        "country" => $country,
                        "currency" => $currency,
                        "showArrow" => false,
                    ];
                    echo $this->generateFile('view/elements/cartElementProduct.php', $datas);
                    ?>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </div>
</div>