<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $containerId id of the tag that contain datas generated
 * @param Map[Address] $addressMap user's Address
 * @param string $dad id of the dad (if set it activate the select fonctionality)
 * @param string $brotherx selector of the brother (used only if $dad is set)
 * @param string $sbtnx selector of the submit button (used only if $dad is set)
 */

if (!empty($dad)) {
    $Tagdad = "id='$dad'";
    $Tagsbtnx = "data-sbtnx='$sbtnx'";
    $dadx = "#$dad";
} else {
    $Tagdad = null;
    $Tagsbtnx = null;
    $dadx = null;
    $brotherx = null;
}
?>
<div class="cart-wrap">
    <ul <?= $Tagdad ?> class="cart-ul remove-ul-default-att" <?= $Tagsbtnx ?>>
        <?php 
        $sequences = $addressMap->getKeys();
        foreach ($sequences as $sequence) :
            $address = $addressMap->get($sequence);
            $elementId = ModelFunctionality::generateDateCode(25);
            $TagelementId = "id='" . $elementId . "'";
        ?>
            <li <?= $TagelementId ?> class="li-cart-element-container remove-li-default-att">
                <?php
                // $submitdata = $element->getProdID();
                $datas = [
                    "containerId" => $containerId,
                    "elementId" => $elementId,
                    "address" => $address,
                    "showButon" => true,
                    "dadx" => $dadx,
                    "brotherx" => $brotherx,
                    "submitdata" => $sequence
                ];
                echo $this->generateFile('view/elements/cart/address/cartElementAddress.php', $datas);
                ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>