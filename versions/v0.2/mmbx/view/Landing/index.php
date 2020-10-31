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
    <!-- VP -->
    <div class="main_content-vp">
        <div class="vp_content">
            <div class="vp_content-vp">
                <div class="vp_content-vp-txt vp_content-vp-child">
                    <h1 class="vp_content-vp-txt-title title"><span class="capitalize">profite</span> de la second main sans ses inconvénients</h1>
                    <p class="vp_content-vp-txt-line">un grand catalogue</p>
                    <p class="vp_content-vp-txt-line">un large choix de taille</p>
                    <p class="vp_content-vp-txt-line">un service de retouche totalement gratuit</p>
                    <p class="vp_content-vp-txt-line">le tout dans une boxe: la <span class="capitalize">meimboxe</span></p>
                </div>
                <div class="vp_content-vp-cta vp_content-vp-child">
                    <button class="cta-btn squared-standard-button">acheter ta <span class="capitalize">meimboxe</span></button>
                </div>
            </div>
            <div class="vp_content-img">
                <img src="<?= self::$DIR_STATIC_FILES ?>IMG_2628.png" alt="">
            </div>
        </div>
    </div>
    <!-- TUTO -->
    <div class="main_content-tuto">
        <div class="tuto_content">
            <div class="tuto_content-title title_margin_bottom">
                <h2 class="title">
                    <span class="capitalize">mais</span> la
                    <span class="capitalize">meimboxe</span> comment ça marche?
                </h2>
            </div>
            <div class="tuto_content-features">
                <div class="tuto_content-features-barre">
                    <div class="tuto_content-features-barre-barre"></div>
                </div>
                <div class="tuto_content-features-container features">
                    <div class="feature">
                        <div class="feature-head">
                            <div class="feature-head-logo">
                                <div class="back_white rectangle"></div>
                                <div class="square">
                                    <div class="circle">
                                        <span>1</span>
                                    </div>
                                </div>
                                <div class="rectangle"></div>
                            </div>
                            <div class="feature-head-title">
                                <h3 class="bold subtitle">
                                    <spa class="capitalize">choisis</spa> ta
                                    <span class="capitalize">meimboxe</span>
                                </h3>
                            </div>
                        </div>
                        <div class="feature-body">
                            <p class="feature-body-child text">
                                <span class="capitalize">choisis</span> parmi les
                                <span class="capitalize">meimboxes</span> disponible celle qui te convient le mieux.
                                <br>
                                <span class="capitalize">chaque meimboxe</span> peut contenir jusqu'à un certain nombre d'article.
                            </p>
                        </div>
                    </div>
                    <div class="feature center">
                        <div class="feature-head">
                            <div class="feature-head-logo">
                                <div class="rectangle"></div>
                                <div class="square">
                                    <div class="circle">
                                        <span>2</span>
                                    </div>
                                </div>
                                <div class="rectangle"></div>
                            </div>
                            <div class="feature-head-title">
                                <h3 class="bold subtitle">
                                    <spa class="capitalize">remplis</spa> ta
                                    <span class="capitalize">meimboxe</span>
                                </h3>
                            </div>
                        </div>
                        <div class="feature-body">
                            <p class="feature-body-child text">
                                <span class="capitalize">parcourt</span> notre catalogue, ajoute les articles qui te plaisent dans ta
                                <span class="capitalize">meimboxe</span>
                                <br>
                                <span class="capitalize">ajoute</span> les articles qui te plaisent dans ta
                                <span class="capitalize">meimboxe.</span>
                                <br>
                                <span class="capitalize">et</span> passe ta commande!
                            </p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-head">
                            <div class="feature-head-logo">
                                <div class="rectangle"></div>
                                <div class="square">
                                    <div class="circle">
                                        <span>3</span>
                                    </div>
                                </div>
                                <div class="back_white rectangle"></div>
                            </div>
                            <div class="feature-head-title">
                                <h3 class="bold subtitle">
                                    <spa class="capitalize">reçois</spa> ta
                                    <span class="capitalize">meimboxe</span>
                                </h3>
                            </div>
                        </div>
                        <div class="feature-body">
                            <p class="feature-body-child text">
                                <span class="capitalize">Une</span> fois ta commande passée, notre équipe
                                s'occupe du reste pour une livraison en
                                moins de 7 jours.
                                <br>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- SIZE -->
    <div class="main_content-size">
        <div class="size_content">
            <div class="size_content-title title_margin_bottom">
                <h2 class="title text_center">
                    <span class="capitalize">plus</span> d'option pour plus de taille
                </h2>
            </div>
            <div class="size_content-features features">
                <!-- SIZE-SIZE -->
                <div class="feature">
                    <div class="feature-head">
                        <div class="feature-head-logo">
                            <div class="logo">
                                <img src="<?= self::$DIR_STATIC_FILES ?>multiple-size.png">
                            </div>
                        </div>
                        <div class="feature-head-title">
                            <h3 class="bold subtitle">
                                <spa class="capitalize">un</spa> large choix de taille
                            </h3>
                        </div>
                    </div>
                    <div class="feature-body">
                        <p class="feature-body-child text">
                            <span class="capitalize">découvre</span> sur chaque article le plus large
                            choix de taille encore jamais vue sur un catalogue
                            de seconde main.
                        </p>
                    </div>
                </div>
                <!-- SIZE-MEASURE -->
                <div class="feature">
                    <div class="feature-head">
                        <div class="feature-head-logo">
                            <div class="logo">
                                <img src="<?= self::$DIR_STATIC_FILES ?>tape-measure.png">
                            </div>
                        </div>
                        <div class="feature-head-title">
                            <h3 class="bold subtitle">
                                <spa class="capitalize">des</spa> retouches sur mesure et gratuites
                            </h3>
                        </div>
                    </div>
                    <div class="feature-body">
                        <p class="feature-body-child text">
                            <span class="capitalize">tu</span> ne trouve pas ta taille?
                            <span class="capitalize">tu</span> désire un vêtement sur mesure?
                            <br>
                            <span class="capitalize">alors</span> enregistre ta taille avec ton article et nous nous occupons du reste.
                            <br>
                            <span class="capitalize">c'est</span> totalement gratuit!
                        </p>
                    </div>
                </div>
            </div>
            <div class="size_content-cta">
                <div class="cta">
                    <button class="cta-btn squared-standard-button">acheter ta <span class="capitalize">meimboxe</span></button>
                </div>
            </div>
        </div>
    </div>
    <!-- QUALITY -->
    <div class="main_content-quality"></div>
</div>