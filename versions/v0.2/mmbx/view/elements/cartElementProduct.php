<?php
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerId id of the tag that contain datas generated
 * @param string $elementId id of the element (allway given)
 * + this id is generated in file cart.php
 * @param string $boxElementId id of the box element that holds the boxproduct (allway given) 
 * @param BoxProduct|BasketProduct $product a boxproduct to display
 * @param Box $box the box witch holds the boxProduct
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param boolean $showArrow set true to display the row else set false
 * @param string $dadx selector of the dad (if set it activate the select fonctionality)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dadx is set)
 * @param string|int|float $submitdata data to sumbit (used only if $dadx is set)
 */

/**
 * @var BoxProduct|BasketProduct
 */
$product = $product;

/**
 * @var Price
 */
$price = null;

$elementIdx = "#" . $elementId;
$containerIdx = "#" . $containerId;
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
        /*———————————————————————— CONFIG DELETE BUTTON DOWN ————————————————*/
        $deleteFunc = "console.log('delete basket product')";
        /*———————————————————————— CONFIG DELETE BUTTON UP ——————————————————*/
        /*———————————————————————— CONFIG EDIT BUTTON DWON ——————————————————*/
        $editFunc = "console.log('edit basket product')";
        $miniPopEdit = null;
        /*———————————————————————— CONFIG EDIT BUTTON UP ————————————————————*/
        break;
    case BoxProduct::BOX_TYPE:
        $prodClass = "box_product-wrap";
        $dadx = null;
        $brotherx = null;
        $submitdata = null;
        $boxID = $box->getBoxID();
        $prodID = $product->getProdID();
        $sequence = $product->getSelectedSize()->getSequence();
        $boxElementIdx = "#" . $boxElementId;
        /*———————————————————————— CONFIG DELETE BUTTON DOWN ————————————————*/
        $deleteFunc = "removeBoxProduct('$boxID', '$prodID', '$sequence', '$boxElementIdx', '$elementIdx')";
        /*———————————————————————— CONFIG DELETE BUTTON UP ——————————————————*/
        /*———————————————————————— CONFIG EDIT BUTTON DWON ——————————————————*/
        $spanid = ModelFunctionality::generateDateCode(25);
        $spanidx = "#" . $spanid;
        switch ($containerId):
                // case 'box_manager_window':
                //     $editFunc = null;
                //     $miniPopEdit = null;
                //     break;
            case 'shopping_bag':
                ob_start(); ?>
                <ul class="remove-ul-default-att">
                    <li class="remove-li-default-att">
                        <span id="<?= $spanid ?>" class="grey-tag-button standard-tag-button" data-onclick="moveBoxProduct('<?= $boxID ?>','<?= $prodID ?>','<?= $sequence ?>')" onclick="openPopUp('#box_manager_window',()=>{getBoxMngr('<?= Box::CONF_MV_BXPROD ?>', '<?= $boxID ?>')},()=>{setMoveBoxProduct('<?= $spanidx ?>','<?= $boxID ?>')});"><?= $translator->translateStation("US63") ?></span>
                    </li>
                    <li class="remove-li-default-att">
                        <span class="grey-tag-button standard-tag-button" onclick="getSizeEditor('<?= $boxID ?>','<?= $prodID ?>','<?= $sequence ?>',()=>{openPopUp('#size_editor_pop')})"><?= $translator->translateStation("US62") ?></span>
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

            case 'basket_pop':
                ob_start(); ?>
                <ul class="remove-ul-default-att">
                    <li class="remove-li-default-att">
                        <span id="<?= $spanid ?>" class="grey-tag-button standard-tag-button" data-onclick="moveBoxProduct('<?= $boxID ?>','<?= $prodID ?>','<?= $sequence ?>')" onclick="switchPopUp('<?= $containerIdx ?>','#box_manager_window',()=>{getBoxMngr('<?= Box::CONF_MV_BXPROD ?>', '<?= $boxID ?>')},()=>{setMoveBoxProduct('<?= $spanidx ?>','<?= $boxID ?>')});"><?= $translator->translateStation("US63") ?></span>
                    </li>
                    <li class="remove-li-default-att">
                        <span class="grey-tag-button standard-tag-button" onclick="getSizeEditor('<?= $boxID ?>','<?= $prodID ?>','<?= $sequence ?>',()=>{switchPopUp('<?= $containerIdx ?>','#size_editor_pop')})"><?= $translator->translateStation("US62") ?></span>
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
            default:
                $editFunc = null;
                $miniPopEdit = null;
                break;
        endswitch;
        /*———————————————————————— CONFIG EDIT BUTTON UP ————————————————————*/
        break;
}
$size = $product->getSelectedSize();
?>
<div class="<?= $prodClass ?>">
    <?php
    $sizeObj = $product->getSelectedSize();
    $datas = [
        // "class" => get_class($product),
        "title" => $product->getProdName(),
        "color" => $translator->translateString($product->getColorName()),
        "colorRGB" => $product->getColorRGB(),
        "size" => $sizeObj->getsize(),
        "brand" => $sizeObj->getbrandName(),
        "measure" => $sizeObj->getmeasure(),
        "cut" => $sizeObj->getcut(),
        "quantity" => $product->getQuantity(),
        "price" => $price,
        "editFunc" => $editFunc,
        "miniPopEdit" => $miniPopEdit
    ];
    $properties = $this->generateFile('view/elements/cartElementProperties.php', $datas);
    $pictureSrcs = $product->getPictureSources();
    krsort($pictureSrcs);
    $datas = [
        "elementId" => $elementId,
        "deleteFunc" => $deleteFunc,
        "properties" => $properties,
        "miniPopEdit" => $miniPopEdit,
        "editFunc" => $editFunc,
        "pictureSrc" => (count($pictureSrcs) > 0) ? array_pop(($pictureSrcs)) : null,
        "price" => $price,
        "showArrow" => $showArrow,
        "dadx" => $dadx,
        "brotherx" => $brotherx,
        "submitdata" => $submitdata
    ];
    echo $this->generateFile('view/elements/cartElement.php', $datas);
    ?>
</div>