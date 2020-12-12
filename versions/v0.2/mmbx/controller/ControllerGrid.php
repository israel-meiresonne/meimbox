<?php

require_once 'ControllerSecure.php';

class ControllerGrid extends ControllerSecure
{
    /**
     * Action used to filter the product grid 
     * @var string
     */
    public const QR_FILTER = "grid/filter";

    /**
     * Holds the access key for content of the grid product
     * @var string
     */
    public const GRID_CONTENT_KEY = "grid_content";

    /**
     * Holds the access key for stickers of the grid product
     * @var string
     */
    public const GRID_STICKERS_KEY = "grid_stickers";

    public function index()
    {
        // $this->secureSession();
        $currency = $this->person->getCurrency();
        $country = $this->person->getCountry();
        $language = $this->person->getLanguage();
        $search = new Search(Search::FILTER_GET_SEARCH, $currency);
        $search->setProducts($language, $country, $currency);
        $viewDatas =  [
            "search" => $search,
            "person" => $this->person
        ];
        $this->generateView($viewDatas, $this->person);
    }

    /**
     * Action to perform a filter of the product grid
     */
    public function filter()
    {
        // sleep(5);
        $response = new Response();
        $currency = $this->person->getCurrency();
        $country = $this->person->getCountry();
        $language = $this->person->getLanguage();

        $search = new Search(Search::FILTER_POST_SEARCH, $currency);
        $search->setProducts($language, $country, $currency);

        $response->addFiles(self::GRID_CONTENT_KEY, "view/Grid/gridFiles/gridProduct.php");
        $response->addFiles(self::GRID_STICKERS_KEY, "view/Grid/gridFiles/gridSticker.php");
        $products = $search->getProducts();

        $viewDatas = [
            "products" => $products,
            "country" => $country,
            "currency" => $currency,
            "search" => $search,
            "executeObj" => [
                [
                    "var" => "stickers",
                    "obj" => "search",
                    "function" => 'getStickers',
                    "param" => 'translator'
                ]
            ]
        ];
        $this->generateJsonView($viewDatas, $response, $this->person);
    }
}
