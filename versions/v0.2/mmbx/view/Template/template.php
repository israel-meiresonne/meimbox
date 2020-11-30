<?php
require_once 'controller/ControllerSecure.php';
require_once 'controller/ControllerHome.php';
require_once 'controller/ControllerGrid.php';
require_once 'controller/ControllerItem.php';
require_once 'controller/ControllerDashboard.php';
require_once 'controller/ControllerCheckout.php';
require_once 'model/special/Search.php';
require_once 'model/boxes-management/Product.php';
require_once 'model/boxes-management/Size.php';
require_once 'model/tools-management/Measure.php';
require_once 'model/tools-management/MeasureUnit.php';
// require_once 'model/view-management/PageContent.php';
require_once 'model/special/MyError.php';
require_once 'model/special/Response.php';
/**
 *  ——————————————————————————————— NEED —————————————————————————————————————
 * @param Visitor|Client|Administrator $person the current user
 * @param string $webRoot domaine's root
 * @param string $title page's title
 * @param string $head complementary datas for the head
 * @param string $content the page's content
 * @param string $fullscreen full screen elements like popup
 */

/**
 * @var Visitor|Client|Administrator
 */
$person = $person;
$isoLang = (!empty($person)) ? $person->getLanguage()->getIsoLang() :  null;
$navigation = $person->getNavigation();
$pageID = $navigation->getUrlPage()->getPageID();
// $lastPageID = $navigation->getLastPage()->getPageID();
?>
<!DOCTYPE html>
<html lang="<?= $isoLang ?>">

<head>
    <meta charset="UTF-8">
    <base href="<?= $webRoot ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?= $description ?>"> <!-- <meta name="description" content=""> -->
    <title><?= $title ?></title>

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"> -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <?= self::FONT_FAM_SPARTAN ?>
    <?= self::FONT_FAM_PT ?>

    <?= $head ?>

    <script>
        const jx = function(a, d, r, l, x = null, sc = () => {}, rc = () => {}) {
            $(l).css("display", "block");
            sc();
            $.ajax({
                type: 'POST',
                url: a + QR_XHR,
                data: d,
                dataType: 'json',
                success: function(j) {
                    $(l).fadeOut(TS, rc());
                    console.log("response: ", j);
                    r(j, x);
                }
            });
        }

        const rburl = (a) => {
            var as = a.split("/");
            var u = as[0] + XHR;
            for (var i = 1; i < as.length; i++) {
                u += as[i];
            }
            return u;
        };

        frmSND = function(datas) {
            var param = $(datas.frm).serialize();
            if (datas.frmCbk() != null) {
                param += datas.frmCbk();
            }
            var datasSND = {
                "a": datas.a,
                "d": param,
                "r": datas.r,
                "l": datas.l,
                "x": datas.x,
                "sc": datas.sc,
                "rc": datas.rc
            };
            SND(datasSND);
        }

        const SND = function(datas) {
            var a = rburl(datas.a);
            var d = datas.d;
            var r = datas.r;
            var l = datas.l;
            var x = datas.x;
            var sc = datas.sc;
            var rc = datas.rc;
            console.log("send: ", d);
            console.log("to: ", a);
            jx(a, d, r, l, x, sc, rc);
        }
    </script>

    <script>
        const WR = "<?= $webRoot ?>";
        const A_SIGN_UP = "<?= ControllerHome::A_SIGN_UP ?>";
        const A_SIGN_IN = "<?= ControllerHome::A_SIGN_IN ?>";
        const QR_LOG_OUT = "<?= ControllerHome::QR_LOG_OUT ?>";
        const QR_UPDATE_COUNTRY = "<?= ControllerHome::QR_UPDATE_COUNTRY ?>";
        const QR_EVENT = "<?= ControllerHome::QR_EVENT ?>";
        const EVT_K = "<?= Event::KEY_EVENT ?>";
        const EVT_D = "<?= Event::KEY_DATA ?>";

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
        const A_SBMT_BXPROD = "<?= ControllerItem::A_SBMT_BXPROD ?>";
        const SBMT_BTN_MSG = "<?= ControllerItem::SBMT_BTN_MSG ?>";

        const QR_MEASURE_CONTENT = "<?= ControllerItem::QR_MEASURE_CONTENT ?>";
        const MEASURRE_STICKER_KEY = "<?= Measure::MEASURRE_STICKER_KEY ?>";
        const KEY_MEASURE_ID = "<?= Measure::KEY_MEASURE_ID ?>";
        const INPUT_MEASURE_UNIT = "<?= MeasureUnit::INPUT_MEASURE_UNIT ?>";

        const A_GET_BX_MNGR = "<?= ControllerItem::A_GET_BX_MNGR ?>";
        const A_GET_BSKT_POP = "<?= ControllerItem::A_GET_BSKT_POP ?>";
        const A_ADD_BOX = "<?= ControllerItem::A_ADD_BOX ?>";
        const A_ADD_BXPROD = "<?= ControllerItem::A_ADD_BXPROD ?>";
        const A_EDT_BXPROD = "<?= ControllerItem::A_EDT_BXPROD ?>";
        const A_MV_BXPROD = "<?= ControllerItem::A_MV_BXPROD ?>";
        const A_DLT_BXPROD = "<?= ControllerItem::A_DLT_BXPROD ?>";
        const A_DELETE_BOX = "<?= ControllerItem::A_DELETE_BOX ?>";
        const A_GET_EDT_POP = "<?= ControllerItem::A_GET_EDT_POP ?>";

        const QR_ADD_ADRS = "<?= ControllerDashboard::QR_ADD_ADRS ?>";
        const QR_GET_ADRS_SET = "<?= ControllerDashboard::QR_GET_ADRS_SET ?>";

        const QR_SELECT_ADRS = "<?= ControllerCheckout::QR_SELECT_ADRS ?>";

        const KEY_CART_FILE = "<?= Basket::KEY_CART_FILE ?>";
        const KEY_TOTAL = "<?= Basket::KEY_TOTAL ?>";
        const KEY_SUBTOTAL = "<?= Basket::KEY_SUBTOTAL ?>";
        const KEY_VAT = "<?= Basket::KEY_VAT ?>";
        const KEY_SHIPPING = "<?= Basket::KEY_SHIPPING ?>";
        const KEY_BSKT_QUANTITY = "<?= Basket::KEY_BSKT_QUANTITY ?>";


        const KEY_BOX_ID = "<?= Box::KEY_BOX_ID ?>";
        const KEY_NEW_BOX_ID = "<?= Box::KEY_NEW_BOX_ID ?>";
        const KEY_BOX_COLOR = "<?= Box::KEY_BOX_COLOR ?>";
        const CONF_ADD_BXPROD = "<?= Box::CONF_ADD_BXPROD ?>";
        const CONF_MV_BXPROD = "<?= Box::CONF_MV_BXPROD ?>";

        const KEY_PROD_ID = "<?= Product::KEY_PROD_ID ?>"

        const KEY_SEQUENCE = "<?= Size::KEY_SEQUENCE ?>"

        const CONF_ADRS_FEED = "<?= Address::CONF_ADRS_FEED ?>"
        const CONF_ADRS_POP = "<?= Address::CONF_ADRS_POP ?>"
        const KEY_ADRS_SEQUENCE = "<?= Address::KEY_ADRS_SEQUENCE ?>"

        const RSP_NOTIFICATION = "<?= Response::RSP_NOTIFICATION ?>"

        const TITLE_KEY = "<?= ControllerSecure::TITLE_KEY ?>";
        const BUTTON_KEY = "<?= ControllerSecure::BUTTON_KEY ?>";
        const FAT_ERR = "<?= MyError::FATAL_ERROR ?>";

        const DELETE_MEASURE_ALERT = "<?= $translator->translateStation("US50") ?>";
        const ALERT_DELETE_BOX = "<?= $translator->translateStation("US58") ?>";
        const ALERT_DLT_BXPROD = "<?= $translator->translateStation("US64") ?>";
        const ALERT_LOG_OUT = "<?= $translator->translateStation("US103") ?>";

        const TS = 450;
        const BNR = 1000000;
        const XHR = "<?= Page::PATH_XHR ?>";
        const LANG = "lang=" + $("html").attr("lang");
        const QR_XHR = "?<?= Page::KEY_XHR ?>=<?= $pageID ?>";
        const FCID = "#full_screen_div";
        const ER_TYPE_MINIPOP = "<?= self::ER_TYPE_MINIPOP ?>";
        const ER_TYPE_COMMENT = "<?= self::ER_TYPE_COMMENT ?>";

        /**
         * @param {number} number 
         * @return {int} between 0 and number given in param
         */
        const randomInt = function(number) {
            return parseInt(Math.random() * number);
        }

        const strToFloat = function(str) {
            var prs = str.replace(",", ".");
            var num = Number.parseFloat(prs).toFixed(5);
            return (num != "NaN") ? num : null;
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

        const mapToParam = function(map) {
            return jQuery.param(map);
        }
    </script>

    <link rel="stylesheet" href="<?= self::$PATH_CSS . 'root.css' ?>">
    <link rel="stylesheet" href="<?= self::$PATH_CSS ?>header.css">
    <link rel="stylesheet" href="<?= self::$PATH_CSS ?>elements.css">
    <script src="<?= self::$PATH_JS ?>evt.js"></script>
    <script src="<?= self::$PATH_JS ?>elements.js"></script>
    <script src="<?= self::$PATH_JS ?>pop.js"></script>
    <script src="<?= self::$PATH_JS ?>qr.js"></script>
    <?= $this->getFbPixelBaseCode() ?>
</head>

<body>
    <?= $this->generateFbPixel() ?>
    <?php
    $file = 'view/Template/files/headers/' . $this->header;
    $company = Configuration::getFromJson(Configuration::JSON_KEY_COMPANY);
    $companyMap = new Map($company);
    $headerDatas = [
        "person" => $person,
        "companyMap" => $companyMap
    ];
    echo $this->generateFile($file, $headerDatas);
    ?>
    <div class="template-content">
        <?= $content ?>
        <?php echo $this->generateFile('view/elements/fullscreen.php', ["person" => $person]); ?>
    </div>
</body>

</html>