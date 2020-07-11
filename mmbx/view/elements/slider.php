<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Builds a complete displayable slider
 * @param string[] $elements list element to display in slider
 * @param string $sliderClass CSS class for the slider
 */
$sliderClass = (!empty($sliderClass)) ? $sliderClass : "suggest_slider_nb_window_wrapper";
?>

<div class="slider-wrap <?= $sliderClass ?>">
    <button class="slider-left-button remove-button-default-att"></button>
    <div class="slider-window">
        <div class="item-set">
            <div class="slider-nb_acticle-width_indicator"></div>
            <ul class="silder-ul-container remove-ul-default-att">
                <?php foreach ($elements as $element) : ?>
                    <li class="silder-li-container remove-li-default-att">
                        <?= $element ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <button class="slider-right-button remove-button-default-att"></button>
</div>