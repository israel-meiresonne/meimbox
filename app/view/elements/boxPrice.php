<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * $boxesPrices : list containing only price and datas to color price
 * + NOTE: price are ordered from lower price to higher
 * $boxesPrices[
 *      price*100 => [
 *          "boxColor" => string,
 *          "sizeMax" => int,
 *          "boxColorRGB" => string,
 *          "priceRGB" => string,
 *          "textualRGB" => string,
 *          "price" => Price([price÷sizeMax], Country);
 *     ]
 */
?>

<div class="piano-wrap">
    <div class="piano-displayable-set">
        <ul class="piano-ul-displayable remove-ul-default-att">
            <?php
            $nbPrice = count($boxesPrices);
            $i = 0;
            foreach ($boxesPrices as $index => $datas) :
                // $priceRGB = $datas["boxColorRGB"] != self::WHITE_RGB ? $datas["boxColorRGB"] : $this->COLOR_TEXT_08;
                $priceRGB = $datas["priceRGB"];
                $price = $datas["price"]->getFormated();
                $displayNone = ($i != ($nbPrice - 1)) ? 'style="display:none;"' : "";
                $i++;
            ?>
                <li class="piano-li-displayable remove-li-default-att" <?= $displayNone ?>>
                    <p style="color:<?= $priceRGB ?>;"><?= $price ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="piano-button-set">
        <ul class="piano-ul-button remove-ul-default-att">
            <?php
            $i = 0;
            foreach ($boxesPrices as $index => $datas) :
                $selectedClass = ($i != ($nbPrice - 1)) ? "" : "piano-selected-button";
                $pianoBtnId = $this->generateCode(30);
                $animatePiano = "animatePiano(" . "'$pianoBtnId'" . ")";
                $i++;
            ?>
                <li id="<?= $pianoBtnId ?>" onclick="<?= $animatePiano ?>" class="piano-li-button remove-li-default-att <?= $selectedClass ?>">
                    <div class="piano-button remove-button-default-att" style="background:<?= $datas["boxColorRGB"] ?>; ">
                                <span class="piano-button-span" style="color:<?= $datas["textualRGB"] ?>;"><?= $datas["boxColor"] ?></span>
                            </div>
                        </li>
            <?php endforeach; ?>                    
                    </ul>
                </div>
            </div>