<?php
require_once 'view/view/Mosaic/Mosaic.php';

$this->title = "landing page";
$this->description = "welcome";
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
                <img src="<?= self::$DIR_STATIC_FILES ?>IMG_2628.png">
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
            <div class="size_content-title title_margin_bottom title_background">
                <h2 class="title text_center">
                    <span class="capitalize">plus</span> d'option pour plus de taille
                </h2>
            </div>
            <div class="size_content-features features">
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
    <div class="main_content-quality">
        <div class="quality_content">
            <div class="quality_content-lines">
                <!-- LINE-QUALITY -->
                <div class="quality_content-line">
                    <div class="quality_content-line-img">
                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-squared-menu-100.png">
                    </div>
                    <div class="quality_content-line-txt">
                        <div class="quality_content-line-txt-inner">
                            <div class="quality_content-line-txt-title">
                                <h3 class="bold subtitle">
                                    <spa class="capitalize">la</spa> meilleure qualité pour un meilleur confort
                                </h3>
                            </div>
                            <div class="quality_content-line-txt-txt">
                                <p class="text">
                                    <span class="capitalize">nous</span> mettons à ta disposition que les articles dont nous jugeons la qualité irréprochable* pour toujours te
                                    garantir le meilleur confort et ça sur toute notre gamme.
                                    <br>
                                    <br>
                                    <span class="capitalize">*ceux</span> dont la qualité est jugé insuffisante sont détruits pour en faire des nouveaux produits.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- LINE-COLOR -->
                <div class="quality_content-line flex_reverse">
                    <div class="quality_content-line-img">
                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-squared-menu-100.png">
                    </div>
                    <div class="quality_content-line-txt">
                        <div class="quality_content-line-txt-inner">
                            <div class="quality_content-line-txt-title">
                                <h3 class="bold subtitle">
                                    <spa class="capitalize">des</spa> couleurs ravivées
                                </h3>
                            </div>
                            <div class="quality_content-line-txt-txt">
                                <p class="text">
                                    <span class="capitalize">finis</span> les couleurs fades et délavées,
                                    grâce à notre programme de repigmentation des tissus, nous te proposons
                                    des vêtements avec des couleurs plus éclatantes les unes que les autres.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- LINE-LIFE -->
                <div class="quality_content-line">
                    <div class="quality_content-line-img">
                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-squared-menu-100.png">
                    </div>
                    <div class="quality_content-line-txt">
                        <div class="quality_content-line-txt-inner">
                            <div class="quality_content-line-txt-title">
                                <h3 class="bold subtitle">
                                    <spa class="capitalize">des</spa> vêtements qui durent
                                </h3>
                            </div>
                            <div class="quality_content-line-txt-txt">
                                <p class="text">
                                    <span class="capitalize">pour</span> t'assure un vêtement qui tient
                                    longtemps, nous renforçons les coutures de chaque article sur les
                                    zones que nous avons identifiées comme pouvant se relâcher voir céder
                                    dans le temps comme [zone 1, zone 2].
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="quality_content-cta">
                <div class="cta">
                    <button class="cta-btn squared-standard-button">acheter ta <span class="capitalize">meimboxe</span></button>
                </div>
            </div>
        </div>
    </div>
    <!-- FEATURES -->
    <div class="main_content-feature">
        <div class="feature_content">
            <?php
            $files = [];
            $i = 0;
            while ($i < 50) {
                $rand = rand(1, 3);
                // $file = self::$PATH_PRODUCT . 'picture01.jpeg';
                $file = self::$PATH_PRODUCT . "picture0$rand.jpeg";
                array_push($files, $file);
                $i++;
            }
            $min = 10;
            $max = 30;
            $configMap = new Map();
            $containerClass = "computer_mosaic";
            $sizerClass = "computer_mosaic-sizer";
            $stoneClass = "computer_mosaic-stone";
            $configMap->put($containerClass, Map::containerClass);
            $configMap->put($sizerClass, Map::sizerClass);
            $configMap->put($stoneClass, Map::stoneClass);
            $css = "
                    .$containerClass {min-width: 100%;}
                    .$stoneClass {padding: 5px;}
                    .$stoneClass img { width: 100%; }";
            $configMap->put($css, Map::css);
            $mosaicComputer = new Mosaic($files, $configMap, $min, $max);

            $min = 20;
            $max = 60;
            $configMap = new Map();
            $containerClass = "mobile_mosaic";
            $sizerClass = "mobile_mosaic-sizer";
            $stoneClass = "mobile_mosaic-stone";
            $configMap->put($containerClass, Map::containerClass);
            $configMap->put($sizerClass, Map::sizerClass);
            $configMap->put($stoneClass, Map::stoneClass);
            $css = "
                    .$containerClass {min-width: 100%;}
                    .$stoneClass {padding: 2px;}
                    .$stoneClass img { width: 100%; }";
            $configMap->put($css, Map::css);
            $mosaicMobile = new Mosaic($files, $configMap, $min, $max);
            ?>
            <!-- MOSAIC -->
            <div class="feature_content-mosaic">
                <div class="feature_content-mosaic-child feature_content-mosaic_computer">
                    <?= $mosaicComputer ?>
                    <?= $mosaicComputer ?>
                    <?= $mosaicComputer ?>
                </div>
                <div class="feature_content-mosaic-child feature_content-mosaic_mobile">
                    <?= $mosaicMobile ?>
                    <?= $mosaicMobile ?>
                    <?= $mosaicMobile ?>
                </div>
            </div>
            <!-- FEATURES -->
            <div class="feature_content-features">
                <!-- WAVE_TOP -->
                <div class="feature_content-wave_top">
                    <div class="feature_content-wave-mask"></div>
                </div>
                <div class="feature_content-features-inner">
                    <div class="feature_content-features-title title_margin_bottom title_background">
                        <h2 class="title text_center">
                            <span class="capitalize">mais</span> la <span class="capitalize">meimbox</span> c'est aussi...
                        </h2>
                    </div>
                    <div class="feature_content-features-features">
                        <div class="feature_line features">
                            <div class="feature">
                                <div class="feature-head">
                                    <div class="feature-head-logo">
                                        <div class="logo">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>no-trash.png">
                                        </div>
                                    </div>
                                    <div class="feature-head-title">
                                        <h3 class="bold subtitle">
                                            <spa class="capitalize">zéro</spa> déchet
                                        </h3>
                                    </div>
                                </div>
                                <div class="feature-body">
                                    <p class="feature-body-child text">
                                        <span class="capitalize">la meimboxe</span> c'est une boxe en carton solide avec fermeture magnétique.
                                        <br>
                                        <span class="capitalize">ce</span> détails te permet de la réutiliser comme rangement et éviter de remplir les poubelles.
                                    </p>
                                </div>
                            </div>
                            <div class="feature">
                                <div class="feature-head">
                                    <div class="feature-head-logo">
                                        <div class="logo">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>no-plastic.png">
                                        </div>
                                    </div>
                                    <div class="feature-head-title">
                                        <h3 class="bold subtitle">
                                            <spa class="capitalize">zéro</spa> plastique
                                        </h3>
                                    </div>
                                </div>
                                <div class="feature-body">
                                    <p class="feature-body-child text">
                                        <span class="capitalize">grace</span> à l'usage massif de matériaux alternatif
                                        nous sommes parvenue à vous proposer aujourd'hui une
                                        <span class="capitalize">meimboxe</span> affichant zéro gramme de plastic...
                                        <span class="capitalize">comme</span> quoi c'est possible!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="feature_line features">
                            <div class="feature">
                                <div class="feature-head">
                                    <div class="feature-head-logo">
                                        <div class="logo">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>flag-europe.png">
                                        </div>
                                    </div>
                                    <div class="feature-head-title">
                                        <h3 class="bold subtitle">
                                            <span class="capitalize">made</span> in <span class="capitalize">europe</span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="feature-body">
                                    <p class="feature-body-child text">
                                        <span class="capitalize">toutes</span> nos infrastructures, nos locaux et notre personnel sont localisés en
                                        <span class="capitalize">europe</span> à fin d'être au plus prêt de vous et ainsi vous assurer un service parfait et dans les temps.
                                    </p>
                                </div>
                            </div>
                            <div class="feature">
                                <div class="feature-head">
                                    <div class="feature-head-logo">
                                        <div class="logo">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-headset-96.png">
                                        </div>
                                    </div>
                                    <div class="feature-head-title">
                                        <h3 class="bold subtitle">
                                            <spa class="capitalize">service</spa> client dévoué
                                        </h3>
                                    </div>
                                </div>
                                <div class="feature-body">
                                    <p class="feature-body-child text">
                                        <span class="capitalize">nous</span> restons à votre écoute pour vous répondre à toutes vos questions.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="feature_line features">
                            <div class="feature">
                                <div class="feature-head">
                                    <div class="feature-head-logo">
                                        <div class="logo">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>track-order.png">
                                        </div>
                                    </div>
                                    <div class="feature-head-title">
                                        <h3 class="bold subtitle">
                                            <spa class="capitalize">suivis</spa> de colis intégré
                                        </h3>
                                    </div>
                                </div>
                                <div class="feature-body">
                                    <p class="feature-body-child text">
                                        <span class="capitalize">suis</span> l'état de ta commande à tout moment grâce
                                        à notre système de suivis de colis directement disponible sur notre plateforme.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feature_content-features-cta">
                        <div class="cta">
                            <button class="cta-btn squared-standard-button">acheter ta <span class="capitalize">meimboxe</span></button>
                        </div>
                    </div>
                </div>
                <!-- WAVE_BOTTOM -->
                <div class="feature_content-wave_bottom">
                    <div class="feature_content-wave-mask"></div>
                </div>
            </div>

        </div>
    </div>
    <script id="fbpxlevt" type="text/javascript">
        const mxs = <?= $maxScroll ?>;
        lp = () => {
            var s = scrollRate();
            if (s >= mxs) {
                fbpxl('<?= $pxlEvnt ?>', '<?= $pxlJson ?>');
                lp = null;
            }
        }
    </script>
</div>