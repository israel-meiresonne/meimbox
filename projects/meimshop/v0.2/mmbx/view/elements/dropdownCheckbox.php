<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $titleId the id of the checkbox input in the head
 * @param string $title the dropdown title
 * @param string $inputName the name attribut of the head's checkbox
 * @param string $inputValue the value of the head's checkbox
 * @param string $dataAttributs input in head's data attributs
 * @param string $isRadio indicate if the checkbox in the  head are radio or just checkbox
 * + NOTE: set true if it radio else false
 * @param string $content the content of the dropdown
 */
$inputType = (isset($isRadio) && $isRadio) ? "radio" : "checkbox";
?>
<div class="dropdown_checkbox-wrap">
    <div class="dropdown_checkbox-inner">
        <div class="dropdown_checkbox-head">
            <div class="dropdown_checkbox-title">
                <div class="dropdown_checkbox-checkbox-block">
                    <label class="checkbox-label" for="<?= $titleId ?>"><?= $title ?>
                        <input id="<?= $titleId ?>" type="<?= $inputType ?>" name="<?= $inputName ?>" value="<?= $inputValue ?>" <?= $dataAttributs ?>>
                        <span class="checkbox-checkmark"></span>
                    </label>
                </div>
                <!-- <div class="customize-price-block">
                    <?php //$customDpPrice = (new Price(0, $currency))->getFormated(); 
                    ?>
                    <span class="customize-price-span"><?php //$customDpPrice 
                                                        ?></span>
                </div> -->
            </div>
        </div>
        <div class="dropdown_checkbox-checkbox-list">
           <?= $content ?>
        </div>
    </div>
</div>