<?php

class View implements ViewInterface
{
    /**
     * Used to build the content of all page
     * @var PageContent
     */
    private $pageContent;

    /**
     * The translator used to translate every string  
     * + NOTE: it's the only
     *  instance of this class in the whole system.
     * @var Translator $translator 
     */
    private static $translator;

    /**
     * Holds the current file's name for translator
     * @var string
     */
    const CURRRENT_FILE = "View.php";

    /**
     * Holds key to store response
     * @var string
     */
    const TITLE_KEY = "title_key";

    /**
     * Holds key to store response
     * @var string
     */
    const BUTTON_KEY = "button_key";


    /**
     * View's Constructor
     * @param Language $language the Visitor's current language
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    function __construct($language, $dbMap)
    {
        // empty(self::$CURRRENT_FILE) ? self::$CURRRENT_FILE = basename(__FILE__) : null;
        self::$translator = new Translator($language, $dbMap);
        $this->pageContent = new PageContent($dbMap);
    }

    /**
     * Give the translation of a string for a specified station. 
     * If there is any translation of the string for asked station, a 
     * translation is returned in the default language of the 
     * Translator
     * @param int $station the id of the station where to get the translation
     * @return string the translation at the station and into the language given in param
     */
    public static function translateStation($fileName, $station)
    {
        return self::$translator->translateStation($fileName, $station);
    }

    /**
     * Getter for the current file's name
     * @return string the current file's name
     */
    public function getCURRRENT_FILE()
    {
        return self::CURRRENT_FILE;
    }

    /**
     * To get head's datas (meta-data, css link and script tags) shared by all the 
     * web pages
     * @return string meta-data, link and script tags
     */
    public function getHeadDatas()
    {
        $datas =
            '<meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <!-- <base href="/v1.0/"> --!>
            <base href="/versions/v0.1/">
            <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --!>
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=PT+Serif&display=swap" rel="stylesheet">';
        return $datas;
    }

    /**
     * To get files used in all web page (css link and script tags)
     * @return string css link and script tags
     */
    public function getGeneralFiles()
    {
        $headerDatas =
            '<link rel="stylesheet" href="outside/css/header.css">';
        $elementDatas =
            '<script src="outside/js/elements.js"></script>
        <link rel="stylesheet" href="outside/css/elements.css">';
        $queryDatas =
            '<script src="outside/qr/qr.js"></script>';
        return $headerDatas . $elementDatas . $queryDatas;
    }

    /**
     * To get constants needed in js code. NOTE: each constant is named 
     * following their class name and their value name (ex: VARNAME_CLASSNAME)
     * @return string constants needed in js code.
     */
    public function getConstants()
    {
        $scriptOpen =
            '<script>';

        $constants =
            '
                const QR_FILTER = "' . Search::QR_FILTER . '";
                const GRID_CONTENT_KEY = "' . Product::GRID_CONTENT_KEY . '";
                const GRID_STICKERS_KEY = "' . Product::GRID_STICKERS_KEY . '";

                const QR_SELECT_BRAND = "' . Size::QR_SELECT_BRAND . '";
                const BRAND_STICKER_KEY = "' . Size::BRAND_STICKER_KEY . '";

                const QR_GET_MEASURE_ADDER = "' . Measure::QR_GET_MEASURE_ADDER . '";
                const QR_GET_EMPTY_MEASURE_ADDER = "' . Measure::QR_GET_EMPTY_MEASURE_ADDER . '";
                const QR_ADD_MEASURE = "' . Measure::QR_ADD_MEASURE . '";
                const QR_UPDATE_MEASURE = "' . Measure::QR_UPDATE_MEASURE . '";
                const QR_DELETE_MEASURE = "' . Measure::QR_DELETE_MEASURE . '";
                const QR_SELECT_MEASURE = "' . Measure::QR_SELECT_MEASURE . '";
                const QR_MEASURE_CONTENT = "' . Measure::QR_MEASURE_CONTENT . '";
                const MEASURRE_STICKER_KEY = "' . Measure::MEASURRE_STICKER_KEY . '";
                const MEASURE_ID_KEY = "' . Measure::MEASURE_ID_KEY . '";
                const INPUT_MEASURE_UNIT = "' . MeasureUnit::INPUT_MEASURE_UNIT . '";
                
                const TITLE_KEY = "' . View::TITLE_KEY . '";
                const BUTTON_KEY = "' . View::BUTTON_KEY . '";
                const DELETE_MEASURE_ALERT = "' . self::$translator->translateStation(PageContent::GRID_USED_INSIDE, 50) . '";
                const FAT_ERR = "' . MyError::FATAL_ERROR . '";

                const TS = 450;
                const BNR = 1000000;
                const JXF = "outside/qr/qr.php";';

        $functions =
            '
                /**
                 * @param {number} number 
                 * @return {int} between 0 and number given in param
                 */
                const randomInt = function (number) {
                    return parseInt(Math.random() * number);
                }
            
                const strToFloat = function (x) {
                    return Number.parseFloat(x).toFixed(2);
                }
            
                var $_GETfunc = function $_GET(param) {
                    var vars = {};' . "
                    window.location.href.replace(location.hash, '').replace(
                        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
                        function (m, key, value) { // callback
                            vars[key] = value !== undefined ? value : '';" . '
                        }
                    );
            
                    if (param) {
                        return vars[param] ? vars[param] : null;
                    }
                    return vars;
                }
                const $_GET = $_GETfunc();
            
                const json_encode = function (value) {
                    return JSON.stringify(value)
                }
            
                const json_decode = function (json) {
                    return JSON.parse(json);
                }

                const goToParentNode = function (selector, generation){
                    var parent = selector;
                    for (let i = 0; i < generation; i++) {
                        // parent = parent.parentNode;
                        parent = $(parent).parent();
                    }
                    return parent;
                }

                const matchRegex = function (string, regex) {
                    var filter = new RegExp(regex);
                    return filter.test(string);
                }
                
                ';

        $scriptClose =
            '
            </script>';

        $scriptOpen .= $constants;
        $scriptOpen .= $functions;

        return $scriptOpen . $scriptClose;
    }

    /**
     * To get the navigation bar of computer screen
     * @return string the html navbar tag of computer screen
     */
    public function getComputerHeader()
    {
        $datas =
            '<nav class="navbar-computer">
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
                                            <img src="outside/brain/permanent/icons8-pill-yellow-red.png" alt="">
                                        </div>
                                        <span class="img-text-span">new drop</span>
                                    </div>
                                </div>

                            </li>

                            <li class="navbar-li remove-li-default-att center-block-li">
                                <div class="img-text-block">
                                    <div class="img-text-wrap">
                                        <div class="img-text-img">
                                            <img src="outside/brain/permanent/icons8-plus-math-96.png" alt="">
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
                                            <img src="outside/brain/permanent/icons8-contacts-96.png" alt="">
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
                                                <img src="outside/brain/permanent/icons8-shopping-cart-96.png" alt="">
                                            </div>
                                            <span class="img-text-span basket-logo-span">(3)</span>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>';

        return $datas;
    }

    /**
     * To get the navigation bar of mobile screen
     * @return string the html navbar tag of mobile screen
     */
    public function getMobileHeader()
    {
        $datas =
            '<nav class="navbar-mobile">
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
                                    <img src="outside/brain/permanent/icons8-pill-yellow-red.png" alt="">
                                </div>
                                <span class="img-text-span">new drop</span>
                            </div>
                        </div>

                        <div class="img-text-block">
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="outside/brain/permanent/icons8-plus-math-96.png" alt="">
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
                                        <img src="outside/brain/permanent/icons8-shopping-cart-96.png" alt="">
                                    </div>
                                    <span class="img-text-span basket-logo-span">(3)</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="collapse-container"></div>
            </nav>';

        return $datas;
    }

    /**
     * To get the content of the grid page following the URL params
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param Model $model model interface
     * @return string grid page following the search criteriion
     */
    public function getGridPage($search, $model)
    {
        return  $this->pageContent->getGridPage($search, self::$translator, $model);
    }

    /**
     * Build grid product and its stickers with search's criterions into HTML 
     * displayable format
     * @param Search $search the search that content all the criterion of the 
     * search, its Products result and a map where is ordered each product by 
     * criterion
     * @param Model $model model interface
     * @return Response grid page and its stickers following the Search criteriion
     */
    public function getFilterPOSTSearch($search, $model)
    {
        $response = new Response();
        $stickers = self::getStickers($search, $model);
        $gridContent = self::getGridProducts($search, $model);
        (strlen($gridContent) == 0)
            ? $response->addResult(Product::GRID_CONTENT_KEY, $this->pageContent->emptyGrid())
            : $response->addResult(Product::GRID_CONTENT_KEY, $gridContent);
        $response->addResult(Product::GRID_STICKERS_KEY, $stickers);
        return $response;
    }

    /**
     * To make sticker with search's criterions into HTML displayable format
     * @param Search $search the search that content all the criterion of the 
     * search, its Products result and a map where is ordered each product by 
     * criterion
     * @param Model $model model interface
     * @return string grid stickers following the search criteriion
     */
    private function getStickers($search, $model)
    {
        $language = $model->getLanguage();
        $stickers = $search->getStickers($language, self::$translator);
        return $this->pageContent->buildFilterStickers($stickers, self::$translator);
    }

    /**
     * Build grid product with search's products list into HTML displayable 
     * format
     * @param Search $search the search that content all the criterion of the 
     * search, its Products result and a map where is ordered each product by 
     * criterion
     * @param Model $model model interface
     * @return string grid page following the search criteriion
     */
    private function getGridProducts($search, $model)
    {
        $products = $search->getProducts();
        $country = $model->getCountry();
        $currency = $model->getCurrency();
        return $this->pageContent->getGridProducts($products, $country, $currency, self::$translator);
    }

    /**
     * To get the content of the item page following the URL params
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param Model $model model interface
     * @return string grid page following the search criteriion
     */
    public function getItemPage($search, $model)
    {
        return  $this->pageContent->getItemPage($search, self::$translator, $model);
    }

    /**
     * To get selected brand html sticker
     * @param Model $model model interface
     * @return Response contain sticker or a MyError
     */
    public function getBrandSticker($model)
    {
        $dbMap = $model->getDbMap();
        $query = new Query();
        $response = new Response();

        if (
            !$query->paramExistPOST(Size::BRAND_NAME_KEY)
            || !array_key_exists($query->POST(Size::BRAND_NAME_KEY), $dbMap["brandsMeasures"])
        ) {
            $errorMsg = self::$translator->translateStation(self::CURRRENT_FILE, 1);
            // $error = new MyError($errorMsg);
            $response->addError($errorMsg);
        } else {
            $brandName = $query->POST(Size::BRAND_NAME_KEY);
            $brand_sticker = $this->pageContent->getBrandSticker($brandName, self::$translator);
            $response->addResult(Size::BRAND_STICKER_KEY, $brand_sticker);
        }
        return $response;
    }

    /**
     * To get selected measure's html sticker
     * @param Model $model model interface
     * @return Response contain sticker or a MyError
     */
    public function getMeasureSticker($model)
    {
        $dbMap = $model->getDbMap();
        $query = new Query();
        $response = new Response();

        if (
            !$query->paramExistPOST(Measure::MEASURE_ID_KEY)
            || !array_key_exists($query->POST(Measure::MEASURE_ID_KEY), $dbMap["usersMap"]["usersMeasures"])
        ) {
            $errorMsg = self::$translator->translateStation(self::CURRRENT_FILE, 1);
            $response->addError($errorMsg);
        } else {
            $measure_id = $query->POST(Measure::MEASURE_ID_KEY);
            $measureDatas = Measure::getDatas4Measure($dbMap["usersMap"]["usersMeasures"][$measure_id]);
            $measure = new Measure($measureDatas, $dbMap);
            $measure_sticker = $this->pageContent->getMeasureSticker($measure, self::$translator);
            $response->addResult(Measure::MEASURRE_STICKER_KEY, $measure_sticker);
        }
        return $response;
    }

    /**
     * To get measure manager's content
     * @param Response $response contain Visitor's measures
     * @return Response contain measure manager's content or a MyError
     */
    public function getMeasureManagerContent($response)
    {
        if (!$response->containError()) {
            $measures = $response->getResult(Measure::QR_MEASURE_CONTENT);
            $managerContent = $this->pageContent->buildMeasureManagerContent($measures, self::$translator);
            $response->addResult(Measure::QR_MEASURE_CONTENT, $managerContent);
        }
        return $response;
    }

    /**
     * To get elements inside Measure Manager
     * @param Response $response contain Visitor's measures
     * @return Response contain measure manager's content or a MyError
     */
    public function getMeasureManagerElements($response)
    {
        if (!$response->containError()) {
            $results = $response->getResult(Measure::QR_DELETE_MEASURE);
            $measures = $results[View::TITLE_KEY];
            $managerElements = $this->pageContent->getMeasureManagetTitleANDbutton($measures, self::$translator);
            $results[View::TITLE_KEY] = $managerElements[View::TITLE_KEY];
            $results[View::BUTTON_KEY] = $managerElements[View::BUTTON_KEY];
            $response->addResult(Measure::QR_DELETE_MEASURE, $results);
        }
        return $response;
    }

    /**
     * To get measure adder's content
     * @param Response $response contain Visitor's measures
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @return Response contain measure manager's content or a MyError
     */
    public function getMeasureAdderContent($response, $dbMap)
    {
        if (!$response->containError()) {
            $measure = $response->getResult(Query::POST_MOTHOD);
            $adderContent = $this->pageContent->buildMeasureAdderContent(self::$translator, $dbMap, $measure);
            $response->addResult(Measure::QR_GET_MEASURE_ADDER, $adderContent);
            $response->unsetResult(Query::POST_MOTHOD);
        }
        return $response;
    }
}
