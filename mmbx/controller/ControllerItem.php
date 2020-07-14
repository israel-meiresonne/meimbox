<?php

require_once 'ControllerSecure.php';

class ControllerItem extends ControllerSecure
{
    /**
     * Holds the query value for Ajax request
     * @var string
     */
    const A_SELECT_BRAND = "item/selectBrand";

    /**
     * Holds the access key for brand name in Query
     * @var string
     */
    const BRAND_NAME_KEY =  "brand_name";

    /**
     * Holds the access key for brand name
     * @var string
     */
    const BRAND_STICKER_KEY =  "brand_sticker";


    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const A_ADD_MEASURE = "item/addMeasure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const A_DELETE_MEASURE = "item/deleteMeasure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const A_UPDATE_MEASURE = "item/updateMeasure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_GET_MEASURE_ADDER = "item/getMeasureAdder";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_GET_EMPTY_MEASURE_ADDER = "get_empty_measure_adder";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const A_SELECT_MEASURE = "item/selectMeasure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_MEASURE_CONTENT = "measure_content";

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
            "functions" => $product->getFunctions(),
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
            $datasView = [
                "measures" => $measures
            ];
            $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManagerContent.php");
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
                $datasView = [
                    "measures" => $measures
                ];
                $response->addFiles(self::QR_MEASURE_CONTENT, "view/elements/popupMeasureManagerContent.php");
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
}
