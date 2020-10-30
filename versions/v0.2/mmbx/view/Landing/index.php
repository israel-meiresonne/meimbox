<?php
$this->title = "shipping address";
$this->description = "select shipping address";
$this->header = self::HEADER_CONF_LANDING;
/**
 * @var Translator
 */
$translator = $translator;
$this->head = $this->generateFile('view/Landing/files/head.php', []);
?>
<div class="main_content">
    <div class="main_content-vp">
        <div class="vp_content">
            <div class="vp_content-vp">
                <div class="vp_content-vp-txt vp_content-vp-child">
                    <h1 class="vp_content-vp-txt-title"><span class="capitalize">profite</span> de la second main sans ses inconvénients</h1>
                    <p class="vp_content-vp-txt-line">un grand catalogue</p>
                    <p class="vp_content-vp-txt-line">un large choix de taille</p>
                    <p class="vp_content-vp-txt-line">un service de retouche totalement gratuit</p>
                    <p class="vp_content-vp-txt-line">le tout dans une boxe: la meimboxe</p>
                </div>
                <div class="vp_content-vp-cta vp_content-vp-child">
                    <button class="cta-btn squared-standard-button">acheter ta meimboxe</button>
                </div>
            </div>
            <div class="vp_content-img">
                <img src="<?= self::$DIR_STATIC_FILES ?>IMG_2628.png" alt="">
            </div>
        </div>
    </div>

    <div class="main_content-tuto"></div>
    <div class="main_content-size"></div>
    <div class="main_content-quality"></div>
</div>