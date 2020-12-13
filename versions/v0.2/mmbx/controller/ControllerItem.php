<?php

require_once 'ControllerSecure.php';

class ControllerItem extends ControllerSecure
{
    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_SELECT_BRAND = "item/selectBrand";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    public const A_ADD_MEASURE = "item/addMeasure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    public const A_UPDATE_MEASURE = "item/updateMeasure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    public const A_DELETE_MEASURE = "item/deleteMeasure";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_SBMT_BXPROD = "item/submitBoxProduct";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_GET_BX_MNGR = "item/getBoxManager";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_GET_BSKT_POP = "item/getBasketPop";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_ADD_BOX = "item/addBox";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_DELETE_BOX = "item/deleteBox";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_ADD_BXPROD = "item/addBoxProduct";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_EDT_BXPROD = "item/updateBoxProduct";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_MV_BXPROD = "item/moveBoxProduct";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_DLT_BXPROD = "item/deleteBoxProduct";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_GET_EDT_POP = "item/getSizeEditor";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    public const QR_GET_MEASURE_ADDER = "item/getMeasureAdder";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    public const QR_GET_EMPTY_MEASURE_ADDER = "get_empty_measure_adder";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    public const A_SELECT_MEASURE = "item/selectMeasure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    public const QR_MEASURE_CONTENT = "measure_content";

    /**
     * Holds the access key for brand name
     * @var string
     */
    public const BRAND_STICKER_KEY =  "brand_sticker";

    /**
     * Holds the access key message to put in a submit button
     * @var string
     */
    public const SBMT_BTN_MSG =  "sbmt_btn_msg";

    /**
     * Holds the access key for box manager window
     * @var string
     */
    public const BX_MNGR_KEY =  "bx_mngr_key";

    public function index()
    {
        // $this->secureSession();
        $currency = $this->person->getCurrency();
        $country = $this->person->getCountry();
        $language = $this->person->getLanguage();
        $search = new Search(Search::PROD_ID_GET_SEARCH);
        $search->setProducts($language, $country, $currency);
        $product = $search->getProducts()[0];
        unset($search);
        $params = [
            "collections" => $product->getCollections(),
            "product_types" => [Boxproduct::BOX_TYPE, BasketProduct::BASKET_TYPE],
            "functions" => $product->getProdFunctions(),
            "categories" => $product->getCategories(),
            "order" => Search::NEWEST
        ];
        $searchSlider = new Search(Search::SYSTEM_SEARCH, null, $params);
        $searchSlider->setProducts($language, $country, $currency);
        $sliderProducts = $searchSlider->getProducts();
        $brandsMeasures = $this->person->getBrandMeasures();
        $measureUnits = $this->person->getUnits();
        $datasView =  [
            "product" => $product,
            "person" => $this->person,
            "sliderProducts" => $sliderProducts,
            "brandsMeasures" => $brandsMeasures,
            "measureUnits" => $measureUnits,
        ];
        $this->generateView($datasView, $this->person);
    }

    /**
     * Select a brand from the pop up
     */
    public function selectBrand()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        $brandsMeasures = $person->getBrandMeasures();
        if ((!Query::existParam(Size::KEY_BRAND_NAME))
            || (!array_key_exists(Query::getParam(Size::KEY_BRAND_NAME), $brandsMeasures))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $brandName = Query::getParam(Size::KEY_BRAND_NAME);
            $datasView = [
                "brandName" => $brandName
            ];
            $response->addFiles(self::BRAND_STICKER_KEY, "view/Item/itemFiles/stickerBrand.php");

            $eventCode = "evt_cd_91";
            $eventDatasMap = new Map();
            $eventDatasMap->put($brandName, Size::KEY_BRAND_NAME);
            $person->handleEvent($eventCode, $eventDatasMap);
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * Create a new measure for the Visitor
     */
    public function addMeasure()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];

        $table = "UsersMeasures";
        $unitName = $this->checkInput(
            $response,
            MeasureUnit::INPUT_MEASURE_UNIT,
            Query::getParam(MeasureUnit::INPUT_MEASURE_UNIT),
            [self::CHECKBOX, self::STRING_TYPE],
            $person->getDataLength($table, "unit_name")
        );
        $measureName = $this->checkInput(
            $response,
            Measure::INPUT_MEASURE_NAME,
            Query::getParam(Measure::INPUT_MEASURE_NAME),
            [self::PSEUDO],
            $person->getDataLength($table, "measureName")
        );
        $userBust = $this->checkInput(
            $response,
            Measure::INPUT_BUST,
            Query::getParam(Measure::INPUT_BUST),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userBust")
        );
        $userArm = $this->checkInput(
            $response,
            Measure::INPUT_ARM,
            Query::getParam(Measure::INPUT_ARM),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userArm")
        );
        $userWaist = $this->checkInput(
            $response,
            Measure::INPUT_WAIST,
            Query::getParam(Measure::INPUT_WAIST),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userWaist")
        );
        $userHip = $this->checkInput(
            $response,
            Measure::INPUT_HIP,
            Query::getParam(Measure::INPUT_HIP),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userHip")
        );
        $userInseam = $this->checkInput(
            $response,
            Measure::INPUT_INSEAM,
            Query::getParam(Measure::INPUT_INSEAM),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userInseam")
        );
        if (!$response->containError()) {
            $measureMap = new Map();
            // $measureMap->put($measureID, Map::measureID);
            $measureMap->put($unitName, Map::unitName);
            $measureMap->put($measureName, Map::measureName);
            $measureMap->put($userBust, Map::bust);
            $measureMap->put($userArm, Map::arm);
            $measureMap->put($userWaist, Map::waist);
            $measureMap->put($userHip, Map::hip);
            $measureMap->put($userInseam, Map::inseam);
            $person->addMeasure($response, $measureMap);
            if (!$response->containError()) {
                $measures = $response->getResult(self::QR_MEASURE_CONTENT);
                $measureUnits = $person->getUnits();
                $datasView = [
                    "measures" => $measures,
                    "measureUnits" => $measureUnits,
                ];
                $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManager.php");

                $eventCode = "evt_cd_108";
                $eventDatasMap = new Map();
                $eventDatasMap->put($unitName, MeasureUnit::INPUT_MEASURE_UNIT);
                $eventDatasMap->put($measureName, Measure::INPUT_MEASURE_NAME);
                $eventDatasMap->put($userBust, Measure::INPUT_BUST);
                $eventDatasMap->put($userArm, Measure::INPUT_ARM);
                $eventDatasMap->put($userWaist, Measure::INPUT_WAIST);
                $eventDatasMap->put($userHip, Measure::INPUT_HIP);
                $eventDatasMap->put($userInseam, Measure::INPUT_INSEAM);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * Select a measure from the pop up
     */
    public function selectMeasure()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];

        if ((!Query::existParam(Measure::KEY_MEASURE_ID))
            || (!$person->existMeasure(Query::getParam(Measure::KEY_MEASURE_ID)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
            $measure = $person->getMeasure($measureID);
            $datasView = [
                "measure" => $measure,
            ];
            $response->addFiles(Measure::MEASURRE_STICKER_KEY, "view/Item/itemFiles/stickerMeasure.php");

            $eventCode = "evt_cd_103";
            $eventDatasMap = new Map([Measure::KEY_MEASURE_ID => $measureID]);
            $person->handleEvent($eventCode, $eventDatasMap);
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * Update a Visitor's measure
     */
    public function updateMeasure()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];

        $table = "UsersMeasures";
        $measureID = $this->checkInput(
            $response,
            Measure::KEY_MEASURE_ID,
            Query::getParam(Measure::KEY_MEASURE_ID),
            [self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER],
            $person->getDataLength($table, "measureID")/*,
            false*/
        );
        $unitName = $this->checkInput(
            $response,
            MeasureUnit::INPUT_MEASURE_UNIT,
            Query::getParam(MeasureUnit::INPUT_MEASURE_UNIT),
            [self::CHECKBOX, self::STRING_TYPE],
            $person->getDataLength($table, "unit_name")
        );
        $measureName = $this->checkInput(
            $response,
            Measure::INPUT_MEASURE_NAME,
            Query::getParam(Measure::INPUT_MEASURE_NAME),
            [self::PSEUDO],
            $person->getDataLength($table, "measureName")
        );
        $userBust = $this->checkInput(
            $response,
            Measure::INPUT_BUST,
            Query::getParam(Measure::INPUT_BUST),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userBust")
        );
        $userArm = $this->checkInput(
            $response,
            Measure::INPUT_ARM,
            Query::getParam(Measure::INPUT_ARM),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userArm")
        );
        $userWaist = $this->checkInput(
            $response,
            Measure::INPUT_WAIST,
            Query::getParam(Measure::INPUT_WAIST),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userWaist")
        );
        $userHip = $this->checkInput(
            $response,
            Measure::INPUT_HIP,
            Query::getParam(Measure::INPUT_HIP),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userHip")
        );
        $userInseam = $this->checkInput(
            $response,
            Measure::INPUT_INSEAM,
            Query::getParam(Measure::INPUT_INSEAM),
            [self::NUMBER_FLOAT],
            $person->getDataLength($table, "userInseam")
        );
        if (!$response->containError()) {
            if (empty($measureID)) {
                $response->addErrorStation("ER1", MyError::FATAL_ERROR);
            } else {
                $measureMap = new Map();
                $measureMap->put($measureID, Map::measureID);
                $measureMap->put($unitName, Map::unitName);
                $measureMap->put($measureName, Map::measureName);
                $measureMap->put($userBust, Map::bust);
                $measureMap->put($userArm, Map::arm);
                $measureMap->put($userWaist, Map::waist);
                $measureMap->put($userHip, Map::hip);
                $measureMap->put($userInseam, Map::inseam);
                $person->updateMeasure($response, $measureMap);
                if (!$response->containError()) {
                    $measures = $person->getMeasures();
                    $measureUnits = $person->getUnits();
                    $datasView = [
                        "measures" => $measures,
                        "measureUnits" => $measureUnits
                    ];
                    $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManager.php");

                    $eventCode = "evt_cd_110";
                    $eventDatasMap = new Map();
                    $eventDatasMap->put($measureID, Measure::KEY_MEASURE_ID);
                    $eventDatasMap->put($unitName, MeasureUnit::INPUT_MEASURE_UNIT);
                    $eventDatasMap->put($measureName, Measure::INPUT_MEASURE_NAME);
                    $eventDatasMap->put($userBust, Measure::INPUT_BUST);
                    $eventDatasMap->put($userArm, Measure::INPUT_ARM);
                    $eventDatasMap->put($userWaist, Measure::INPUT_WAIST);
                    $eventDatasMap->put($userHip, Measure::INPUT_HIP);
                    $eventDatasMap->put($userInseam, Measure::INPUT_INSEAM);
                    $person->handleEvent($eventCode, $eventDatasMap);
                }
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * Delete one Visitor's measure
     */
    public function deleteMeasure()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        if ((!Query::existParam(Measure::KEY_MEASURE_ID))
            || (!$person->existMeasure(Query::getParam(Measure::KEY_MEASURE_ID)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
            $person->deleteMeasure($response, $measureID);
            if (!$response->containError()) {
                $measures = $person->getMeasures();
                $datasView = [
                    "measures" => $measures
                ];
                $response->addResult(Measure::KEY_MEASURE_ID, $measureID);
                $response->addFiles(ControllerSecure::BUTTON_KEY, 'view/elements/popupMeasureManagerAddBtn.php');
                $response->addFiles(ControllerSecure::TITLE_KEY, 'view/elements/popupMeasureManagerTitle.php');

                $eventCode = "evt_cd_96";
                $eventDatasMap = new Map([Measure::KEY_MEASURE_ID => $measureID]);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To get Measure adder window
     */
    public function getMeasureAdder()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];

        if ((!Query::existParam(Measure::KEY_MEASURE_ID))
            || (!$person->existMeasure(Query::getParam(Measure::KEY_MEASURE_ID)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
            $measure = $person->getMeasure($measureID);
            $measureUnits = $person->getUnits();
            $datasView = [
                "measure" => $measure,
                "measureUnits" => $measureUnits
            ];
            $response->addFiles(self::QR_GET_MEASURE_ADDER, 'view/elements/popupMeasureAdder.php');

            $eventCode = "evt_cd_98";
            $eventDatasMap = new Map([Measure::KEY_MEASURE_ID => $measureID]);
            $person->handleEvent($eventCode, $eventDatasMap);
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To check BoxProduct's stock
     */
    public function submitBoxProduct()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        $prodID = Query::getParam(Product::INPUT_PROD_ID);
        $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
        $size = Query::getParam(Size::INPUT_ALPHANUM_SIZE);
        $brand = Query::getParam(Size::INPUT_BRAND);
        $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
        // $cut = Query::getParam(Size::INPUT_CUT);
        $cut = Query::getParam(Size::INPUT_CUT_ADDER);
        if (empty($prodID)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $sizeMap = new Map();
            $sizeMap->put($size, Map::size);
            $sizeMap->put($brand, Map::brand);
            $sizeMap->put($measureID, Map::measureID);
            $sizeMap->put($cut, Map::cut);
            $stillStock = $person->stillStock($response, $prodID, $sizeType, $sizeMap);
            if (!$response->containError()) {
                if ($stillStock) {
                    $response->addResult(self::A_SBMT_BXPROD, $stillStock);

                    $eventCode = "evt_cd_83";
                    $eventDatasMap = new Map();
                    $eventDatasMap->put($prodID, Product::INPUT_PROD_ID);
                    $eventDatasMap->put($sizeType, Size::INPUT_SIZE_TYPE);
                    $eventDatasMap->put($size, Size::INPUT_ALPHANUM_SIZE);
                    $eventDatasMap->put($brand, Size::INPUT_BRAND);
                    $eventDatasMap->put($measureID, Measure::KEY_MEASURE_ID);
                    $eventDatasMap->put($cut, Size::INPUT_CUT_ADDER);
                    $person->handleEvent($eventCode, $eventDatasMap);
                } else {
                    $errStation = ($sizeType == Size::SIZE_TYPE_ALPHANUM) ?  "ER13" : "ER32";
                    $response->addErrorStation($errStation, Size::INPUT_SIZE_TYPE);
                }
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To get box manager
     */
    public function getBoxManager()
    {
        // $this->secureSession();
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        $conf = Query::getParam(self::A_GET_BX_MNGR);
        if (empty($conf)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $boxID = Query::getParam(Box::KEY_BOX_ID);
            $basket = $person->getBasket();
            (!empty($boxID)) ? $basket->unsetBox($boxID) : null;
            $boxes = $basket->getBoxes();
            $country = $person->getCountry();
            $currency = $person->getCurrency();
            switch ($conf) {
                case Box::CONF_ADD_BXPROD:
                    $datasView = [
                        "boxes" => $boxes,
                        "country" => $country,
                        "currency" => $currency,
                        "conf" => Box::CONF_ADD_BXPROD
                    ];
                    $response->addFiles(self::A_GET_BX_MNGR, "view/elements/popupBoxManagerContent.php");
                    break;
                case Box::CONF_MV_BXPROD:
                    $datasView = [
                        "boxes" => $boxes,
                        "country" => $country,
                        "currency" => $currency,
                        "conf" => Box::CONF_MV_BXPROD
                    ];
                    $response->addFiles(self::A_GET_BX_MNGR, "view/elements/popupBoxManagerContent.php");
                    break;
                default:
                    $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                    break;
            }

            $eventCode = "evt_cd_65";
            $person->handleEvent($eventCode);
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To add a new box in Visitor's basket
     */
    public function addBox()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        if (!Query::existParam(Box::KEY_BOX_COLOR)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $colorCode = Query::getParam(Box::KEY_BOX_COLOR);
            $person->addBox($response, $colorCode);
            if (!$response->containError()) {
                $boxes = $person->getBasket()->getBoxes();
                $country = $person->getCountry();
                $currency = $person->getCurrency();
                $datasView = [
                    "boxes" => $boxes,
                    "country" => $country,
                    "currency" => $currency,
                    "conf" => Box::CONF_ADD_BXPROD
                ];
                $response->addFiles(self::A_ADD_BOX, 'view/elements/popupBoxManagerContent.php');

                $eventCode = "evt_cd_52";
                $eventDatasMap = new Map();
                $keys = array_keys($boxes);
                $lastBox = $boxes[$keys[0]];
                $eventDatasMap->put($lastBox->getColor(), Box::KEY_BOX_COLOR);
                $eventDatasMap->put($lastBox->getBoxID(), Box::KEY_BOX_ID);
                // $eventRsp = new Response();
                // $person->getNavigation()->handleEvent(($eventRsp), $person->getUserID(), $eventCode, $eventDatasMap);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * Delete a box from Visitor's basket
     */
    public function deleteBox()
    {
        $response = new Response();
        $person = $this->person;
        $datasView = [];
        if (!Query::existParam(Box::KEY_BOX_ID)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $boxID = Query::getParam(Box::KEY_BOX_ID);
            $this->person->deleteBox($response, $boxID);
            if (!$response->containError()) {
                $person->addSummaryPrices($response);

                $eventCode = "evt_cd_58";
                $eventDatasMap = new Map();
                $eventDatasMap->put($boxID, Box::KEY_BOX_ID);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To select a box where to add the product
     */
    public function addBoxProduct()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        $boxID = Query::getParam(Box::KEY_BOX_ID);
        $prodID = Query::getParam(Product::INPUT_PROD_ID);
        if (empty($boxID) || empty($prodID)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
            $size = Query::getParam(Size::INPUT_ALPHANUM_SIZE);
            $brand = Query::getParam(Size::INPUT_BRAND);
            $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
            // $cut = Query::getParam(Size::INPUT_CUT);
            $cut = Query::getParam(Size::INPUT_CUT_ADDER);
            $sizeMap = new Map();
            $sizeMap->put($size, Map::size);
            $sizeMap->put($brand, Map::brand);
            $sizeMap->put($measureID, Map::measureID);
            $sizeMap->put($cut, Map::cut);
            $selectedSize = $person->addBoxProduct($response, $boxID, $prodID, $sizeType, $sizeMap);
            if (!$response->containError()) {
                $response->addResult(self::A_ADD_BXPROD, true);

                $eventCode = "evt_cd_85";
                $eventDatasMap = new Map();
                $eventDatasMap->put($boxID, Box::KEY_BOX_ID);
                $eventDatasMap->put($prodID, Product::INPUT_PROD_ID);
                $eventDatasMap->put($sizeType, Size::INPUT_SIZE_TYPE);
                $eventDatasMap->put($size, Size::INPUT_ALPHANUM_SIZE);
                $eventDatasMap->put($brand, Size::INPUT_BRAND);
                $eventDatasMap->put($measureID, Measure::KEY_MEASURE_ID);
                $eventDatasMap->put($cut, Size::INPUT_CUT_ADDER);
                $person->handleEvent($eventCode, $eventDatasMap);

                // var_dump($cut);
                // $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
                // $selectedSize = new Size($sequence);
                $product = $person->getBasket()->getBox($boxID)->getProduct($prodID, $selectedSize);
                $pixelDatasMap = new Map([Map::product => $product]);
                $response->addResult(Pixel::KEY_FB_PXL, Facebook::getPixel(Pixel::TYPE_STANDARD, Pixel::EVENT_ADD_TO_CART, $pixelDatasMap) . ";console.log('evalued')");
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To update a box product
     */
    public function updateBoxProduct()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        $quantity = $this->checkInput(
            $response,
            Size::INPUT_QUANTITY,
            Query::getParam(Size::INPUT_QUANTITY),
            [self::NUMBER_INT],
            $person->getDataLength("`Box-Products`", "quantity")
        );
        if (!$response->containError()) {
            $boxID = Query::getParam(Box::KEY_BOX_ID);
            $prodID = Query::getParam(Product::INPUT_PROD_ID);
            $sequence = Query::getParam(Size::KEY_SEQUENCE);
            if (empty($boxID) || empty($prodID) || empty($sequence)) {
                $response->addErrorStation("ER1", MyError::FATAL_ERROR);
            } else {
                $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
                $size = Query::getParam(Size::INPUT_ALPHANUM_SIZE);
                $brand = Query::getParam(Size::INPUT_BRAND);
                $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
                // $cut = Query::getParam(Size::INPUT_CUT);
                $cut = Query::getParam(Size::INPUT_CUT_EDITOR);
                $sizeMap = new Map();
                $sizeMap->put($size, Map::size);
                $sizeMap->put($brand, Map::brand);
                $sizeMap->put($measureID, Map::measureID);
                $sizeMap->put($cut, Map::cut);
                $sizeMap->put($quantity, Map::quantity);
                $person->updateBoxProduct($response, $boxID, $prodID, $sequence, $sizeType, $sizeMap);
                if (!$response->containError()) {
                    $response->addResult(self::A_EDT_BXPROD, true);

                    $eventCode = "evt_cd_81";
                    $eventDatasMap = new Map();
                    $eventDatasMap->put($boxID, Box::KEY_BOX_ID);
                    $eventDatasMap->put($prodID, Product::INPUT_PROD_ID);
                    $eventDatasMap->put($sequence, Size::KEY_SEQUENCE);
                    $eventDatasMap->put($sizeType, Size::INPUT_SIZE_TYPE);
                    $eventDatasMap->put($size, Size::INPUT_ALPHANUM_SIZE);
                    $eventDatasMap->put($brand, Size::INPUT_BRAND);
                    $eventDatasMap->put($measureID, Measure::KEY_MEASURE_ID);
                    $person->handleEvent($eventCode, $eventDatasMap);
                }
            }
        }
        ($response->containError() &&  (!$response->existErrorKey(Size::INPUT_SIZE_TYPE))) ? $response->addErrorStation("ER35", Size::INPUT_SIZE_TYPE) : null;
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To move a boxproduct to a other box
     */
    public function moveBoxProduct()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        $boxID = Query::getParam(Box::KEY_BOX_ID);
        $newBoxID = Query::getParam(Box::KEY_NEW_BOX_ID);
        $prodID = Query::getParam(Product::KEY_PROD_ID);
        $sequence = Query::getParam(Size::KEY_SEQUENCE);
        if (empty($boxID) || empty($newBoxID) || empty($prodID) || empty($sequence)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $person->moveBoxProduct($response, $boxID, $newBoxID, $prodID, $sequence);
            if (!$response->containError()) {
                $response->addResult(self::A_MV_BXPROD, true);

                $eventCode = "evt_cd_67";
                $eventDatasMap = new Map();
                $eventDatasMap->put($boxID, Box::KEY_BOX_ID);
                $eventDatasMap->put($newBoxID, Box::KEY_NEW_BOX_ID);
                $eventDatasMap->put($prodID, Product::KEY_PROD_ID);
                $eventDatasMap->put($sequence, Size::KEY_SEQUENCE);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To delete a box product
     */
    public function deleteBoxProduct()
    {
        $response = new Response();
        $person = $this->person;
        $datasView = [];
        $boxID = Query::getParam(Box::KEY_BOX_ID);
        $prodID = Query::getParam(Product::KEY_PROD_ID);
        $sequence = Query::getParam(Size::KEY_SEQUENCE);
        if (empty($boxID) || empty($prodID) || empty($sequence)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $person->deleteBoxProduct($response, $boxID, $prodID, $sequence);
            if (!$response->containError()) {
                $basket = $person->getBasket();
                $box = $basket->getBox($boxID);
                $boxRate = $box->getQuantity() . "/" . $box->getSizeMax();
                $response->addResult(Box::KEY_BOX_ID, $boxRate);
                $person->addSummaryPrices($response);

                $eventCode = "evt_cd_62";
                $eventDatasMap = new Map();
                $eventDatasMap->put($boxID, Box::KEY_BOX_ID);
                $eventDatasMap->put($prodID, Product::KEY_PROD_ID);
                $eventDatasMap->put($sequence, Size::KEY_SEQUENCE);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To get  basket popup
     */
    public function getBasketPop()
    {
        $person = $this->getPerson();
        $response = new Response();
        $datasView = [];
        if (!$response->containError()) {
            $basket = $person->getBasket();
            $country = $person->getCountry();
            $currency = $person->getCurrency();
            $datasView = [
                "basket" => $basket,
                "country" => $country,
                "currency" => $currency,
                "containerId" => "shopping_bag",
                "elements" => $basket->getMerge(),
            ];
            $response->addFiles(self::A_GET_BSKT_POP, "view/elements/popupBasketContent.php");
            $response->addFiles(Basket::KEY_CART_FILE, 'view/elements/cart.php');
            $person->addSummaryPrices($response);

            $eventCode = "evt_cd_56";
            // $eventRsp = new Response();
            // $person->getNavigation()->handleEvent($eventRsp, $person->getUserID(), $eventCode);
            $person->handleEvent($eventCode);
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To get size editor
     */
    public function getSizeEditor()
    {
        $response = new Response();
        $person = $this->getPerson();
        $datasView = [];
        $prodID = Query::getParam(Product::KEY_PROD_ID);
        $sequence = Query::getParam(Size::KEY_SEQUENCE);
        if (empty($prodID) || empty($sequence)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $boxID = Query::getParam(Box::KEY_BOX_ID);
            $product = $person->getProduct($response, $prodID, $sequence, $boxID);
            $box = ($product->getType() == BoxProduct::BOX_TYPE) ? $person->getBasket()->getBox($boxID) : null;
            if ((!$response->containError()) && (!empty($product))) {
                $measures = $person->getMeasures();
                $datasView = [
                    "box" => $box,
                    "product" => $product,
                    "nbMeasure" => count($measures),
                ];
                $response->addFiles(self::A_GET_EDT_POP, 'view/elements/popupSizeForm.php');

                $eventCode = "evt_cd_69";
                $eventDatasMap = new Map();
                $eventDatasMap->put($boxID, Box::KEY_BOX_ID);
                $eventDatasMap->put($prodID, Product::KEY_PROD_ID);
                $eventDatasMap->put($sequence, Size::KEY_SEQUENCE);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }
}
