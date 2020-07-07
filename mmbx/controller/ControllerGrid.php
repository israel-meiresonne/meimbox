<?php

require_once 'ControllerSecure.php';
require_once 'model/special/Search.php';

class ControllerGrid extends ControllerSecure
{

    public function index()
    {
        $this->secureSession();
        $currency = $this->person->getCurrency();
        $country = $this->person->getCountry();
        $language = $this->person->getLanguage();
        $lang = $this->person->getLanguage();
        $search = new Search(Search::GET_SEARCH, $currency);
        $search->setProducts($lang, $country, $currency);
        // $products = $search->getProducts();
        // $translator = new Translator($language);
        $viewDatas =  [
            "search" => $search,
            "person" => $this->person
        ];
        $this->generateView($viewDatas, $language);
    }
}
