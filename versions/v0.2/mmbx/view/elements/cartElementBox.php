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

/**
 * @var Price
 */
$price = $box->getPriceFormated();
?>
<div class="box-wrap">
    <div class="box-display-block">
        <?php
        /*———————————————————————— GET PROPERTIES DWON ——————————————————————*/
        $datas = [
            "title" => $translator->translateString($box->getColor()),
            "color" => null,
            "colorRGB" => null,
            "nbItem" => $box->getNbProduct(),
            "max" => $box->getSizeMax(),
            "price" => $price
        ];
        $properties = $this->generateFile('view/elements/cartElementProperties.php', $datas);
        /*———————————————————————— GET PROPERTIES UP ————————————————————————*/


        /*———————————————————————— CONFIG EDIT BUTTON DWON ——————————————————*/
        switch ($containerId):
            case 'box_manager_window':
                $editFunc = null;
                $miniPopEdit = null;
                break;

            default:
                ob_start(); ?>
                <ul class="remove-ul-default-att">
                    <li class="grey-tag-button standard-tag-button remove-li-default-att">
                        <span onclick="emptyBox('<?= $boxID ?>','<?= $elementIdx ?>')">empty the box</span>
                    </li>
                    <li class="grey-tag-button standard-tag-button remove-li-default-att">
                        <span onclick="switchPopUp('<?= $containerIdx ?>','#box_manager_window',getBoxMngr)">move to</span>
                    </li>
                </ul>
        <?php
                $miniPopContent  = ob_get_clean();
                $miniPopId = ModelFunctionality::generateDateCode(25);
                $miniPopIdx = "#" . $miniPopId;
                $datas = [
                    "id" => $miniPopId,
                    "dir" => "down",
                    "content" => $miniPopContent
                ];
                $miniPopEdit = $this->generateFile('view/elements/miniPopUp.php', $datas);
                $editFunc = "openMiniPop('$miniPopIdx')";
                break;
        endswitch;
        /*———————————————————————— CONFIG EDIT BUTTON UP ————————————————————*/


        $datas = [
            "properties" => $properties,
            // "miniPopEdit" => $miniPopEdit,
            // "editFunc" => $editFunc,
            "price" => $price,
            "pictureSrc" => $box->getPictureSource(),
            "elementId" => $elementId,
            "deleteFunc" => "removeBox('$boxID', '$elementIdx')",
            "dadx" => $dadx,
            "brotherx" => $brotherx,
            "submitdata" => $submitdata
        ];
        echo $this->generateFile('view/elements/cartElement.php', $datas);
        ?>

    </div>
    <div class="box-product-set">
        <ul class="box-product-set-ul remove-ul-default-att">
            <?php
            $products = $box->getBoxProducts();
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