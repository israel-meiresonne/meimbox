<?php

require_once 'ControllerSecure.php';

class ControllerItem extends ControllerSecure
{
    /**
     * Holds the query value for Ajax request
     * @var string
     */
    const A_SELECT_BRAND = "item/select_brand";

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
        $viewDatas =  [
            "product" => $product,
            "person" => $this->person,
            "sliderProducts" => $sliderProducts,
            "brandsMeasures" => $brandsMeasures,
            "measureUnits" => $measureUnits,
        ];
        $this->generateView($viewDatas, $language);
    }

    /**
     * Perform  a brand select validation
     */
    public function selectBrand()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $response = new Response();
        $response->addResult("msg", "ok");
        $viewDatas = [];
        $this->generateJsonView($viewDatas, $response, $language);
    }
}
