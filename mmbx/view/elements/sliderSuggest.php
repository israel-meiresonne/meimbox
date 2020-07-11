 <?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Builds a complete displayable slider
 * @param $string $title the slider's title
 * ——— SLIDER DOWN ———
 * @param string[] $elements list element to display in slider
 * @param string $sliderClass CSS class for the slider
 */
 ?>

<div class="suggest-silder-container">
    <div class="suggest-title-div">
        <h3 class="suggest-title"><?= $title ?></h3>
    </div>
    <?php 
    $datas = [
        "elements" => $elements,
        "sliderClass" => null
    ];
    echo $this->generateFile("view/elements/slider.php", $datas);
    ?>
</div>