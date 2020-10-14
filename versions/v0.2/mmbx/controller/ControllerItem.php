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
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        $brandsMeasures = $this->person->getBrandMeasures();
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
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * Create a new measure for the Visitor
     */
    public function addMeasure()
    {
        // $this->secureSession();
        $response = new Response();
        $datasView = [];

        $table = "UsersMeasures";
        $unitName = $this->checkInput(
            $response,
            MeasureUnit::INPUT_MEASURE_UNIT,
            Query::getParam(MeasureUnit::INPUT_MEASURE_UNIT),
            [Query::CHECKBOX, Query::STRING_TYPE],
            $this->person->getDataLength($table, "unit_name")
        );
        $measureName = $this->checkInput(
            $response,
            Measure::INPUT_MEASURE_NAME,
            Query::getParam(Measure::INPUT_MEASURE_NAME),
            [Query::PSEUDO],
            $this->person->getDataLength($table, "measureName")
        );
        $userBust = $this->checkInput(
            $response,
            Measure::INPUT_BUST,
            Query::getParam(Measure::INPUT_BUST),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userBust")
        );
        $userArm = $this->checkInput(
            $response,
            Measure::INPUT_ARM,
            Query::getParam(Measure::INPUT_ARM),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userArm")
        );
        $userWaist = $this->checkInput(
            $response,
            Measure::INPUT_WAIST,
            Query::getParam(Measure::INPUT_WAIST),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userWaist")
        );
        $userHip = $this->checkInput(
            $response,
            Measure::INPUT_HIP,
            Query::getParam(Measure::INPUT_HIP),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userHip")
        );
        $userInseam = $this->checkInput(
            $response,
            Measure::INPUT_INSEAM,
            Query::getParam(Measure::INPUT_INSEAM),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userInseam")
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
            $this->person->addMeasure($response, $measureMap);
            if (!$response->containError()) {
                $measures = $response->getResult(self::QR_MEASURE_CONTENT);
                $measureUnits = $this->person->getUnits();
                $datasView = [
                    "measures" => $measures,
                    "measureUnits" => $measureUnits,
                ];
                // $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManagerContent.php");
                $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManager.php");
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * Select a measure from the pop up
     */
    public function selectMeasure()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        if ((!Query::existParam(Measure::KEY_MEASURE_ID))
            || (!$this->person->existMeasure(Query::getParam(Measure::KEY_MEASURE_ID)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
            $measure = $this->person->getMeasure($measureID);
            $datasView = [
                "measure" => $measure
            ];
            $response->addFiles(Measure::MEASURRE_STICKER_KEY, "view/Item/itemFiles/stickerMeasure.php");
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * Update a Visitor's measure
     */
    public function updateMeasure()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        $table = "UsersMeasures";
        $measureID = $this->checkInput(
            $response,
            Measure::KEY_MEASURE_ID,
            Query::getParam(Measure::KEY_MEASURE_ID),
            [Query::ALPHA_NUMERIC],
            $this->person->getDataLength($table, "measureID")/*,
            false*/
        );
        $unitName = $this->checkInput(
            $response,
            MeasureUnit::INPUT_MEASURE_UNIT,
            Query::getParam(MeasureUnit::INPUT_MEASURE_UNIT),
            [Query::CHECKBOX, Query::STRING_TYPE],
            $this->person->getDataLength($table, "unit_name")
        );
        $measureName = $this->checkInput(
            $response,
            Measure::INPUT_MEASURE_NAME,
            Query::getParam(Measure::INPUT_MEASURE_NAME),
            [Query::PSEUDO],
            $this->person->getDataLength($table, "measureName")
        );
        $userBust = $this->checkInput(
            $response,
            Measure::INPUT_BUST,
            Query::getParam(Measure::INPUT_BUST),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userBust")
        );
        $userArm = $this->checkInput(
            $response,
            Measure::INPUT_ARM,
            Query::getParam(Measure::INPUT_ARM),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userArm")
        );
        $userWaist = $this->checkInput(
            $response,
            Measure::INPUT_WAIST,
            Query::getParam(Measure::INPUT_WAIST),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userWaist")
        );
        $userHip = $this->checkInput(
            $response,
            Measure::INPUT_HIP,
            Query::getParam(Measure::INPUT_HIP),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userHip")
        );
        $userInseam = $this->checkInput(
            $response,
            Measure::INPUT_INSEAM,
            Query::getParam(Measure::INPUT_INSEAM),
            [Query::NUMBER_FLOAT],
            $this->person->getDataLength($table, "userInseam")
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
                // $this->person->updateMeasure($response, $measureID);
                $this->person->updateMeasure($response, $measureMap);
                if (!$response->containError()) {
                    $measures = $this->person->getMeasures();
                    $measureUnits = $this->person->getUnits();
                    $datasView = [
                        "measures" => $measures,
                        "measureUnits" => $measureUnits
                    ];
                    // $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManagerContent.php");
                    $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManager.php");
                }
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * Delete one Visitor's measure
     */
    public function deleteMeasure()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        if ((!Query::existParam(Measure::KEY_MEASURE_ID))
            || (!$this->person->existMeasure(Query::getParam(Measure::KEY_MEASURE_ID)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
            $this->person->deleteMeasure($response, $measureID);
            if (!$response->containError()) {
                $measures = $this->person->getMeasures();
                $datasView = [
                    "measures" => $measures
                ];
                $response->addResult(Measure::KEY_MEASURE_ID, $measureID);
                $response->addFiles(ControllerSecure::BUTTON_KEY, 'view/elements/popupMeasureManagerAddBtn.php');
                $response->addFiles(ControllerSecure::TITLE_KEY, 'view/elements/popupMeasureManagerTitle.php');
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To get Measure adder window
     */
    public function getMeasureAdder()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        if ((!Query::existParam(Measure::KEY_MEASURE_ID))
            || (!$this->person->existMeasure(Query::getParam(Measure::KEY_MEASURE_ID)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
            $measure = $this->person->getMeasure($measureID);
            $measureUnits = $this->person->getUnits();
            $datasView = [
                "measure" => $measure,
                "measureUnits" => $measureUnits
            ];
            $response->addFiles(self::QR_GET_MEASURE_ADDER, 'view/elements/popupMeasureAdder.php');
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To add product to cart
     */
    public function submitBoxProduct()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];
        $prodID = Query::getParam(Product::INPUT_PROD_ID);
        $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
        $size = Query::getParam(Size::INPUT_ALPHANUM_SIZE);
        $brand = Query::getParam(Size::INPUT_BRAND);
        $measureID = Query::getParam(Measure::KEY_MEASURE_ID);
        $cut = Query::getParam(Size::INPUT_CUT);
        if (empty($prodID)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $sizeMap = new Map();
            $sizeMap->put($size, Map::size);
            $sizeMap->put($brand, Map::brand);
            $sizeMap->put($measureID, Map::measureID);
            $sizeMap->put($cut, Map::cut);
            $stillStock = $this->person->stillStock($response, $prodID, $sizeType, $sizeMap);
            if (!$response->containError()) {
                if ($stillStock) {
                    $response->addResult(self::A_SBMT_BXPROD, $stillStock);
                } else {
                    $station = "ER13";
                    $response->addErrorStation($station, self::SBMT_BTN_MSG);
                }
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To get box manager
     */
    public function getBoxManager()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];
        $conf = Query::getParam(self::A_GET_BX_MNGR);
        if (empty($conf)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $boxID = Query::getParam(Box::KEY_BOX_ID);
            $basket = $this->person->getBasket();
            (!empty($boxID)) ? $basket->unsetBox($boxID) : null;
            $boxes = $basket->getBoxes();
            $country = $this->person->getCountry();
            $currency = $this->person->getCurrency();
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
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To add a new box in Visitor's basket
     */
    public function addBox()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];
        if (!Query::existParam(Box::KEY_BOX_COLOR)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $colorCode = Query::getParam(Box::KEY_BOX_COLOR);
            $this->person->addBox($response, $colorCode);
            if (!$response->containError()) {
                $boxes = $this->person->getBasket()->getBoxes();
                $country = $this->person->getCountry();
                $currency = $this->person->getCurrency();
                $datasView = [
                    "boxes" => $boxes,
                    "country" => $country,
                    "currency" => $currency,
                    "conf" => Box::CONF_ADD_BXPROD
                ];
                $response->addFiles(self::A_ADD_BOX, 'view/elements/popupBoxManagerContent.php');
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * Delete a box from Visitor's basket
     */
    public function deleteBox()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];
        if (!Query::existParam(Box::KEY_BOX_ID)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $boxID = Query::getParam(Box::KEY_BOX_ID);
            $this->person->deleteBox($response, $boxID);
            if (!$response->containError()) {
                $basket = $this->person->getBasket();
                $total = $basket->getTotal()->getFormated();
                $subtotal = $basket->getSubTotal()->getFormated();
                $vat = $basket->getVatAmount()->getFormated();
                $shipping = $basket->getShipping()->getFormated();
                $quantity = $basket->getQuantity();
                $response->addResult(Basket::KEY_TOTAL, $total);
                $response->addResult(Basket::KEY_SUBTOTAL, $subtotal);
                $response->addResult(Basket::KEY_VAT, $vat);
                $response->addResult(Basket::KEY_SHIPPING, $shipping);
                $response->addResult(Basket::KEY_BSKT_QUANTITY, $quantity);
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To select a box where to add the product
     */
    public function addBoxProduct()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
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
            $cut = Query::getParam(Size::INPUT_CUT);
            $sizeMap = new Map();
            $sizeMap->put($size, Map::size);
            $sizeMap->put($brand, Map::brand);
            $sizeMap->put($measureID, Map::measureID);
            $sizeMap->put($cut, Map::cut);
            $this->person->addBoxProduct($response, $boxID, $prodID, $sizeType, $sizeMap);
            (!$response->containError()) ? $response->addResult(self::A_ADD_BXPROD, true) : null;
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To update a box product
     */
    public function updateBoxProduct()
    {
        // $this->secureSession();
        $response = new Response();
        $datasView = [];
        $quantity = $this->checkInput(
            $response,
            Size::INPUT_QUANTITY,
            Query::getParam(Size::INPUT_QUANTITY),
            [self::NUMBER_INT],
            $this->person->getDataLength("`Box-Products`", "quantity")
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
                $cut = Query::getParam(Size::INPUT_CUT);
                $sizeMap = new Map();
                $sizeMap->put($size, Map::size);
                $sizeMap->put($brand, Map::brand);
                $sizeMap->put($measureID, Map::measureID);
                $sizeMap->put($cut, Map::cut);
                $sizeMap->put($quantity, Map::quantity);
                $this->person->updateBoxProduct($response, $boxID, $prodID, $sequence, $sizeType, $sizeMap);
                (!$response->containError()) ? $response->addResult(self::A_EDT_BXPROD, true) : null;
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To move a boxproduct to a other box
     */
    public function moveBoxProduct()
    {
        // $this->secureSession();
        $response = new Response();
        $datasView = [];
        $boxID = Query::getParam(Box::KEY_BOX_ID);
        $newBoxID = Query::getParam(Box::KEY_NEW_BOX_ID);
        $prodID = Query::getParam(Product::KEY_PROD_ID);
        $sequence = Query::getParam(Size::KEY_SEQUENCE);
        if (empty($boxID) || empty($newBoxID) || empty($prodID) || empty($sequence)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $this->person->moveBoxProduct($response, $boxID, $newBoxID, $prodID, $sequence);
            (!$response->containError()) ? $response->addResult(self::A_MV_BXPROD, true) : null;
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To delete a box product
     */
    public function deleteBoxProduct()
    {
        // $this->secureSession();
        $response = new Response();
        $datasView = [];
        $boxID = Query::getParam(Box::KEY_BOX_ID);
        $prodID = Query::getParam(Product::KEY_PROD_ID);
        $sequence = Query::getParam(Size::KEY_SEQUENCE);
        if (empty($boxID) || empty($prodID) || empty($sequence)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $this->person->deleteBoxProduct($response, $boxID, $prodID, $sequence);
            if (!$response->containError()) {
                $basket = $this->person->getBasket();
                $quantity = $basket->getQuantity();
                $box = $basket->getBoxe($boxID);
                $boxRate = $box->getQuantity() . "/" . $box->getSizeMax();
                $response->addResult(Box::KEY_BOX_ID, $boxRate);
                $response->addResult(Basket::KEY_BSKT_QUANTITY, $quantity);
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To get  basket popup
     */
    public function getBasketPop()
    {
        // $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];
        if (!$response->containError()) {
            $basket = $this->person->getBasket();
            $country = $this->person->getCountry();
            $currency = $this->person->getCurrency();
            $datasView = [
                "basket" => $basket,
                "country" => $country,
                "currency" => $currency,
                "containerId" => "shopping_bag",
                "elements" => $basket->getMerge(),
                // cart datas
            ];
            $response->addFiles(self::A_GET_BSKT_POP, "view/elements/popupBasketContent.php");
            // $boxDatas = [
            //     // "containerId" => $containerId,
            //     "country" => $country,
            //     "currency" => $currency,
            // ];
            $response->addFiles(Basket::KEY_CART_FILE, 'view/elements/cart.php');

            $total = $basket->getTotal()->getFormated();
            $subtotal = $basket->getSubTotal()->getFormated();
            $vat = $basket->getVatAmount()->getFormated();
            $quantity = $basket->getQuantity();
            $shipping = $basket->getShipping()->getFormated();
            $response->addResult(Basket::KEY_TOTAL, $total);
            $response->addResult(Basket::KEY_SUBTOTAL, $subtotal);
            $response->addResult(Basket::KEY_VAT, $vat);
            $response->addResult(Basket::KEY_SHIPPING, $shipping);
            $response->addResult(Basket::KEY_BSKT_QUANTITY, $quantity);
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To get size editor
     */
    public function getSizeEditor()
    {
        // $this->secureSession();
        $response = new Response();
        $datasView = [];
        $prodID = Query::getParam(Product::KEY_PROD_ID);
        $sequence = Query::getParam(Size::KEY_SEQUENCE);
        if (empty($prodID) || empty($sequence)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $boxID = Query::getParam(Box::KEY_BOX_ID);
            $product = $this->person->getProduct($response, $prodID, $sequence, $boxID);
            $box = ($product->getType() == BoxProduct::BOX_TYPE) ? $this->person->getBasket()->getBoxe($boxID) : null;
            if ((!$response->containError()) && (!empty($product))) {
                $measures = $this->person->getMeasures();
                $datasView = [
                    "box" => $box,
                    "product" => $product,
                    "nbMeasure" => count($measures),
                ];
                $response->addFiles(self::A_GET_EDT_POP, 'view/elements/popupSizeForm.php');
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    public function test()
    {
        //    foreach($_SERVER as $key => $data){
        //        echo "$key => ";
        //        var_dump($data);
        //        echo "<hr>";
        //    }
        // $a = false;
        // var_dump($a);
        // echo "<hr>";
        // $b = (int) $a;
        // var_dump($b);
        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // foreach($sizes as $size){
        //     // var_dump();
        //     // echo "<br>";
        //     $sizeObj = new Size(Size::buildSequence($size, null, null, null));
        //     $sizeObj->setQuantity(3);
        //     $product->selecteSize($sizeObj);
        //     var_dump("To convert: ", $sizeObj->getsize());
        //     echo "<br>";
        //     var_dump("Converted: ", $product->SelectedToRealSize()->getsize());
        //     echo "<br>";
        //     var_dump("quantity: ", $product->SelectedToRealSize()->getQuantity());
        //     echo "<hr>";
        // }

        // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // $measureIDs = [
        //     '803g420892212029wn05e10cq',
        //     // 'c39521az182vv0012250220n0',
        //     // 'a5rn30s0gtn2x2998j3000221', 
        //     '1001nq54od2c002o903219929', 
        //     '0jj2g3rj131923p1560b90d01', 
        //     '2191802te91kv3ee27a280h02', 
        //     '651853948740'
        // ];
        // foreach ($measureIDs as $measureID) {
        //     // var_dump();
        //     // echo "<br>";
        //     $sizeObj = new Size(Size::buildSequence(null, null, $measureID, "wide"));
        //     $product->selecteSize($sizeObj);
        //     var_dump("To convert: ", $sizeObj->getmeasure()->getMeasureName());
        //     echo "<br>";
        //     var_dump("Converted: ", $product->SelectedToRealSize()->getsize());
        //     echo "<hr>";
        // }

        // $a = strtotime("2020-10-12 12:00:00");
        // $a = strtotime(null);
        // $setDate = strtotime("2020-10-12 15:00:45");
        // // $setDate = time();
        // $lockLimit = 60;
        // // var_dump(time() > ($setDate + $lockLimit));
        // var_dump((int)strtotime("1971-10-12 15:00:45"));

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // $sizes = ['xxs'];
        // foreach ($sizes as $size) {
        //     $sizeObj = new Size(Size::buildSequence($size, null, null, null));
        //     $sizeObj->setQuantity(17);
        //     // $product->selecteSize($sizeObj);
        //     var_dump("still stock: ", $product->stillStock($sizeObj));
        //     echo "<br>";
        //     echo "<hr>";
        // }

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // $measureIDs = [
        //     'decrease_s_2',
        //     // 'c39521az182vv0012250220n0',
        //     // 'a5rn30s0gtn2x2998j3000221', 
        //     // '1001nq54od2c002o903219929', 
        //     // '0jj2g3rj131923p1560b90d01', 
        //     // '2191802te91kv3ee27a280h02', 
        //     // '651853948740'
        // ];
        // foreach ($measureIDs as $measureID) {
        //     $sizeObj = new Size(Size::buildSequence(null, null, $measureID, "fit"));
        //     $sizeObj->setQuantity(15);
        //     // $product->selecteSize($sizeObj);
        //     var_dump("still stock: ", $product->stillStock($sizeObj));
        //     echo "<br>";
        //     echo "<hr>";
        // }

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // $sizes = ['xxs'];
        // $response = new Response();
        // foreach ($sizes as $size) {
        //     $sizeObj = new Size(Size::buildSequence($size, null, null, null));
        //     $sizeObj->setQuantity(3);
        //     $product->selecteSize($sizeObj);
        //     $product->lock($response, $this->person->getUserID());
        //     var_dump("response: ", $response->getAttributs());
        //     echo "<br>";
        //     echo "<hr>";
        // }

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // var_dump($product);
        // echo "<hr>";
        // echo "<hr>";
        // $copy = $product->getCopy();
        // var_dump($copy);
        // $response = new Response();
        // $this->person->getBasket()->lock($response, $this->person->getUserID());
        // $soldOut = $this->person->getBasket()->stillStock();
        // $keys = $soldOut->getKeys();
        // // var_dump($soldOut);
        // // echo "<hr>";
        // foreach($keys as $key){
        //     var_dump($soldOut->get($key));
        //     echo "<hr>";
        // }
        // echo "<hr>";

        // $response = new Response();
        // // $this->person->getBasket()->unlock($response, $this->person->getUserID());
        // // $this->person->getBasket()->lock($response, $this->person->getUserID());
        // var_dump($response->getAttributs());
        // echo "<hr>";
        // var_dump($response->getAttributs());

        // $this->person->generateCookie(Cookie::COOKIE_LCK, "test");
        // $this->person->destroyCookie(Cookie::COOKIE_LCK, true);

        // $response = new Response();
        // $this->person->getBasket()->empty($response);
        // var_dump($response->getAttributs());
        // echo "<hr>";

        // $boxes = $this->person->getBasket()->getBoxes();
        // $toDecreaseProds = [];
        // foreach ($boxes as $box) {
        //     $products = $box->getProducts();
        //     if (!empty($products)) {
        //         foreach ($products as $product) {
        //             array_push($toDecreaseProds, $product);
        //         }
        //     }
        // }
        // foreach($toDecreaseProds as $x){
        //     var_dump($x);
        //     echo "<hr>";
        // }
        // $response = new Response();
        // BoxProduct::decreaseStock($response, $toDecreaseProds);
        // var_dump($response->getAttributs());
        // echo "<hr>";

        require_once 'model/tools-management/SendinBlueAPI.php';
        // $sendinBlueAPI = new SendinBlueAPI();
        // echo __DIR__;
    }
}
