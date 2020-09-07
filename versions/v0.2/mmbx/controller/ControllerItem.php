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
    public const A_ADD_PROD = "item/addProduct";

    /**
     * Holds the query value for Ajax request
     * @var string
     */
    public const A_ADD_BOX = "item/addBox";

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
     * Holds the access key for brand name in Query
     * @var string
     */
    public const BRAND_NAME_KEY =  "brand_name";

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
        $this->secureSession();
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
        $this->generateView($datasView, $language);
    }

    /**
     * Select a brand from the pop up
     */
    public function selectBrand()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        $brandsMeasures = $this->person->getBrandMeasures();
        if ((!Query::existParam(self::BRAND_NAME_KEY))
            || (!array_key_exists(Query::getParam(self::BRAND_NAME_KEY), $brandsMeasures))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $brandName = Query::getParam(self::BRAND_NAME_KEY);
            $datasView = [
                "brandName" => $brandName
            ];
            $response->addFiles(self::BRAND_STICKER_KEY, "view/Item/itemFiles/stickerBrand.php");
        }
        $this->generateJsonView($datasView, $response, $language);
    }

    /**
     * Create a new measure for the Visitor
     */
    public function addMeasure()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];
        $this->person->addMeasure($response);
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
        $this->generateJsonView($datasView, $response, $language);
    }

    /**
     * Select a measure from the pop up
     */
    public function selectMeasure()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        if ((!Query::existParam(Measure::MEASURE_ID_KEY))
            || (!$this->person->existMeasure(Query::getParam(Measure::MEASURE_ID_KEY)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
            $measure = $this->person->getMeasure($measureID);
            $datasView = [
                "measure" => $measure
            ];
            $response->addFiles(Measure::MEASURRE_STICKER_KEY, "view/Item/itemFiles/stickerMeasure.php");
        }
        $this->generateJsonView($datasView, $response, $language);
    }

    /**
     * Update a Visitor's measure
     */
    public function updateMeasure()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        if ((!Query::existParam(Measure::MEASURE_ID_KEY))
            || (!$this->person->existMeasure(Query::getParam(Measure::MEASURE_ID_KEY)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
            $this->person->updateMeasure($response, $measureID);
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
        $this->generateJsonView($datasView, $response, $language);
    }

    /**
     * Delete one Visitor's measure
     */
    public function deleteMeasure()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        if ((!Query::existParam(Measure::MEASURE_ID_KEY))
            || (!$this->person->existMeasure(Query::getParam(Measure::MEASURE_ID_KEY)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
            $this->person->deleteMeasure($response, $measureID);
            if (!$response->containError()) {
                $measures = $this->person->getMeasures();
                $datasView = [
                    "measures" => $measures
                ];
                $response->addResult(Measure::MEASURE_ID_KEY, $measureID);
                $response->addFiles(ControllerSecure::BUTTON_KEY, 'view/elements/popupMeasureManagerAddBtn.php');
                $response->addFiles(ControllerSecure::TITLE_KEY, 'view/elements/popupMeasureManagerTitle.php');
            }
        }
        $this->generateJsonView($datasView, $response, $language);
    }

    /**
     * To get Measure adder window
     */
    public function getMeasureAdder()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];

        if ((!Query::existParam(Measure::MEASURE_ID_KEY))
            || (!$this->person->existMeasure(Query::getParam(Measure::MEASURE_ID_KEY)))
        ) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
            $measure = $this->person->getMeasure($measureID);
            $measureUnits = $this->person->getUnits();
            $datasView = [
                "measure" => $measure,
                "measureUnits" => $measureUnits
            ];
            $response->addFiles(self::QR_GET_MEASURE_ADDER, 'view/elements/popupMeasureAdder.php');
        }
        $this->generateJsonView($datasView, $response, $language);
    }

    /**
     * To add product to cart
     */
    public function addProduct()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $country = $this->person->getCountry();
        $currency = $this->person->getCurrency();
        $response = new Response();
        $datasView = [];
        if (!Query::existParam(Product::INPUT_PROD_ID)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $prodID = Query::getParam(Product::INPUT_PROD_ID);
            $stillStock = $this->person->stillStock($response, $prodID);
            if (!$response->containError()) {
                // $params = [
                //     Product::INPUT_PROD_ID => Query::getParam(Product::INPUT_PROD_ID)
                // ];
                // $search = new Search(Search::SYSTEM_SEARCH, $currency, $params);
                // $search->setProducts($language, $country, $currency);
                if ($stillStock) {
                    $response->addResult(self::A_ADD_PROD, $stillStock);
                    // $response->addFiles(self::BX_MNGR_KEY, );
                } else {
                    $station = "ER13";
                    $response->addErrorStation($station, self::SBMT_BTN_MSG);
                }
            }
        }
        $this->generateJsonView($datasView, $response, $language);
    }

    /**
     * 
     */
    public function addBox()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $datasView = [];
        if(!Query::existParam(Box::KEY_BOX_COLOR)){
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $colorCode = Query::getParam(Box::KEY_BOX_COLOR);
            $this->person->addBox($response, $colorCode);
            if(!$response->containError()){
                $boxes = $this->person->getBasket()->getBoxes();
                $country = $this->person->getCountry();
                $currency = $this->person->getCurrency();
                $datasView = [
                    "boxes" => $boxes,
                    "country" => $country,
                    "currency" => $currency
                ];
                // $boxManager = $this->generateFile('view/elements/popupBoxManager.php', $datas);
                $response->addFiles(self::A_ADD_BOX, 'view/elements/popupBoxManager.php');
            }
        }
        $this->generateJsonView($datasView, $response, $language);
    }
}
