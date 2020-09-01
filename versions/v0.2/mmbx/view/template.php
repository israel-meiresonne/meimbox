<?php

require_once 'controller/ControllerSecure.php';
require_once 'controller/ControllerGrid.php';
require_once 'controller/ControllerItem.php';
require_once 'model/special/Search.php';
require_once 'model/boxes-management/Product.php';
require_once 'model/boxes-management/Size.php';
require_once 'model/tools-management/Measure.php';
require_once 'model/tools-management/MeasureUnit.php';
require_once 'model/view-management/PageContent.php';
require_once 'model/special/MyError.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <base href="<?= $webRoot ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="$description"> <!-- <meta name="description" content=""> -->
    <title><?= $title ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Serif&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="content/css/header.css">
    <link rel="stylesheet" href="content/css/elements.css">
    <script src="content/js/elements.js"></script>
    <script src="content/qr/qr.js"></script>

    <?= $head ?>
</head>

<body>
    <header>
        <nav class="navbar-computer">
            <div class="navbar-inner">
                <div class="navbar-block navbar-left-block">
                    <ul class="navbar-ul remove-ul-default-att">
                        <li class="navbar-li remove-li-default-att left-block-li site-title">
                            <a href="http://">meimbox</a>
                            <!-- <a href="">xxxxxxx</a> -->
                        </li>
                        <!-- <li class="navbar-li remove-li-default-att left-block-li">
                                <a href="http://" target="_blank" rel="noopener noreferrer">about</a>
                            </li> -->
                    </ul>
                </div>

                <div class="navbar-block navbar-center-block">
                    <ul class="navbar-ul remove-ul-default-att">
                        <li class="navbar-li remove-li-default-att center-block-li">

                            <div class="img-text-block">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="content/brain/permanent/icons8-pill-yellow-red.png" alt="">
                                    </div>
                                    <span class="img-text-span">new drop</span>
                                </div>
                            </div>

                        </li>

                        <li class="navbar-li remove-li-default-att center-block-li">
                            <div class="img-text-block">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="content/brain/permanent/icons8-plus-math-96.png" alt="">
                                    </div>
                                    <span class="img-text-span">add box</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="navbar-block navbar-right-block">
                    <ul class="navbar-ul remove-ul-default-att">

                        <li class="navbar-lang_cur_sign-block navbar-li remove-li-default-att">

                            <div id="currency_select" class="mini-select-container">
                                <div class="mini-select-wrap">
                                    <div id="" class="mini-select-inner">
                                        <select id="" class="mini-select-tag" name="">
                                            <option data-code="AL" value="eur">€</option>
                                            <option data-code="AD" value="usd">$</option>
                                            <option data-code="AM" value="aud">a$</option>
                                            <option data-code="AM" value="cad">c$</option>
                                            <option data-code="AM" value="gbp">£</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="language_select" class="mini-select-container">
                                <div class="mini-select-wrap">
                                    <div id="" class="mini-select-inner">
                                        <select id="" class="mini-select-tag" name="">
                                            <option data-code="fr" value="français">fr</option>
                                            <option data-code="en" value="english">en</option>
                                            <option data-code="es" value="español">es</option>
                                            <option data-code="nl" value="nederland">nl</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="img-text-block ">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="content/brain/permanent/icons8-contacts-96.png" alt="">
                                    </div>
                                    <span class="img-text-span">sign up</span>
                                </div>
                            </div>

                        </li>

                        <li class="navbar-li remove-li-default-att">
                            <div class="img-text-block navbar-basket-block">
                                <div class="img-text-block  navbar-basket-wrap">
                                    <div class="img-text-wrap">
                                        <div class="img-text-img">
                                            <img src="content/brain/permanent/icons8-shopping-cart-96.png" alt="">
                                        </div>
                                        <span class="img-text-span basket-logo-span">(3)</span>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar-mobile">
            <div class="navbar-inner">
                <div class="navbar-burger-block navbar-left-block flex-row">
                    <div class="burger-container">
                        <input type="checkbox" id="checkbox2" class="checkbox2 visuallyHidden">
                        <label class="burger-label" for="checkbox2">
                            <div class="hamburger hamburger2">
                                <span class="bar bar1"></span>
                                <span class="bar bar2"></span>
                                <span class="bar bar3"></span>
                                <span class="bar bar4"></span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="navbar-title-block navbar-center-block flex-row">
                    <div class="site-title">
                        <a href="http://">meimbox</a>
                        <!-- <a href="">xxxxxxx</a> -->
                    </div>
                </div>
                <!-- <div class="navbar-new_drop-block">

                    </div> -->
                <div class="navbar-new_drop-add_box-block">
                    <div class="img-text-block">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="content/brain/permanent/icons8-pill-yellow-red.png" alt="">
                            </div>
                            <span class="img-text-span">new drop</span>
                        </div>
                    </div>

                    <div class="img-text-block">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="content/brain/permanent/icons8-plus-math-96.png" alt="">
                            </div>
                            <span class="img-text-span">add box</span>
                        </div>
                    </div>
                </div>

                <div class="navbar-basket-block navbar-right-block flex-row">

                    <div class="img-text-block navbar-basket-block">
                        <div class="img-text-block">
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="content/brain/permanent/icons8-shopping-cart-96.png" alt="">
                                </div>
                                <span class="img-text-span basket-logo-span">(3)</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="collapse-container"></div>
        </nav>
        <script>
            const WR = "<?= $webRoot ?>";
            const QR_FILTER = "<?= ControllerGrid::QR_FILTER ?>";
            const GRID_CONTENT_KEY = "<?= ControllerGrid::GRID_CONTENT_KEY ?>";
            const GRID_STICKERS_KEY = "<?= ControllerGrid::GRID_STICKERS_KEY ?>";

            const A_SELECT_BRAND = "<?= ControllerItem::A_SELECT_BRAND ?>";
            const BRAND_STICKER_KEY = "<?= ControllerItem::BRAND_STICKER_KEY ?>";

            const QR_GET_MEASURE_ADDER = "<?= ControllerItem::QR_GET_MEASURE_ADDER ?>";
            const QR_GET_EMPTY_MEASURE_ADDER = "<?= ControllerItem::QR_GET_EMPTY_MEASURE_ADDER ?>";
            const A_ADD_MEASURE = "<?= ControllerItem::A_ADD_MEASURE ?>";
            const A_SELECT_MEASURE = "<?= ControllerItem::A_SELECT_MEASURE ?>";
            const A_UPDATE_MEASURE = "<?= ControllerItem::A_UPDATE_MEASURE ?>";
            const A_DELETE_MEASURE = "<?= ControllerItem::A_DELETE_MEASURE ?>";
            const A_ADD_PROD = "<?= ControllerItem::A_ADD_PROD ?>";
            const SBMT_BTN_MSG = "<?= ControllerItem::SBMT_BTN_MSG ?>";

            const QR_MEASURE_CONTENT = "<?= ControllerItem::QR_MEASURE_CONTENT ?>";
            const MEASURRE_STICKER_KEY = "<?= Measure::MEASURRE_STICKER_KEY ?>";
            const MEASURE_ID_KEY = "<?= Measure::MEASURE_ID_KEY ?>";
            const INPUT_MEASURE_UNIT = "<?= MeasureUnit::INPUT_MEASURE_UNIT ?>";

            const TITLE_KEY = "<?= ControllerSecure::TITLE_KEY ?>";
            const BUTTON_KEY = "<?= ControllerSecure::BUTTON_KEY ?>";
            const DELETE_MEASURE_ALERT = "<?= $translator->translateStation("US50") ?>";
            const FAT_ERR = "<?= MyError::FATAL_ERROR ?>";

            const TS = 450;
            const BNR = 1000000;
            const JXF = "content/qr/qr.php";
            const LANG = "lang=" + $("html").attr("lang");
            const FCID = "full_screen_div";

            /**
             * @param {number} number 
             * @return {int} between 0 and number given in param
             */
            const randomInt = function(number) {
                return parseInt(Math.random() * number);
            }

            const strToFloat = function(x) {
                return Number.parseFloat(x).toFixed(2);
            }

            var $_GETfunc = function $_GET(param) {
                var vars = {};
                window.location.href.replace(location.hash, '').replace(
                    /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
                    function(m, key, value) { // callback
                        vars[key] = value !== undefined ? value : '';
                    }
                );

                if (param) {
                    return vars[param] ? vars[param] : null;
                }
                return vars;
            }
            const $_GET = $_GETfunc();

            const json_encode = function(value) {
                return JSON.stringify(value)
            }

            const json_decode = function(json) {
                return JSON.parse(json);
            }

            const goToParentNode = function(selector, generation) {
                var parent = selector;
                for (let i = 0; i < generation; i++) {
                    // parent = parent.parentNode;
                    parent = $(parent).parent();
                }
                return parent;
            }

            const matchRegex = function(string, regex) {
                var filter = new RegExp(regex);
                return filter.test(string);
            }
        </script>
    </header>
    <?= $content ?>
</body>

</html>