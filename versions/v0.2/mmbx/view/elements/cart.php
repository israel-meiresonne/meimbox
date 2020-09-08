<?php
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Translator $translator to translate
 * @param Box[]|BasketProduct[] $elements user's basket
 * @param Country $country Visitor's current Country
 * @param Currency $currency Visitor's current Currency
 * @param string $dad id of the dad (if set it activate the select fonctionality)
 * @param string $dadx selector of the dad (used only if $dad is set)
 * + i.e: "#mydadid"
 * @param string $brotherx selector of the brother (used only if $dad is set)
 * @param string $sbtnx selector of the submit button (used only if $dad is set)
 */

 if(!empty($dad)){
    $Tagdad = "id='$dad'";
    $Tagsbtnx = "data-sbtnx='$sbtnx'";
 } else {
    $Tagdad = null;
    $Tagsbtnx = null;
    $dadx = null;
    $brotherx = null;
 }


?>
<div class="cart-wrap">
    <ul <?= $Tagdad ?> class="remove-ul-default-att" <?= $Tagsbtnx ?> >
        <?php foreach ($elements as $element) : ?>
            <li class="li-cart-element-container remove-li-default-att">
                <?php
                switch (get_class($element)) {
                    case BasketProduct::class:
                        $submitdata = $element->getProdID();
                        $datas = [
                            "product" => $element,
                            "country" => $country,
                            "currency" => $currency,
                            "dadx" => $dadx,
                            "brotherx" => $brotherx,
                            "submitdata" => $submitdata
                        ];
                        echo $this->generateFile('view/elements/cartElementProduct.php', $datas);
                        break;
                    case Box::class:
                        $submitdata = $element->getBoxID();
                        $datas = [
                            "translator" => $translator,
                            "box" => $element,
                            "country" => $country,
                            "currency" => $currency,
                            "dadx" => $dadx,
                            "brotherx" => $brotherx,
                            "submitdata" => $submitdata
                        ];
                        echo $this->generateFile('view/elements/cartElementBox.php', $datas);
                        break;
                }
                ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>