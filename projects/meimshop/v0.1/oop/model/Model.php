<?php

interface Model
{
    //————————————————————————————————————————————— ALTER MODEL DOWN ———————————————————————————————————————————————
    /**
     * Add a new measure to Visitor if input are correct
     * @return Response contain results or Myerrrors
     */
    public function addMeasure();

    /**
     * Delete from database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function deleteMeasure();

    /**
     * Update on database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function updateMeasure();

    //————————————————————————————————————————————— ALTER MODEL UP —————————————————————————————————————————————————
    //————————————————————————————————————————————— GET MODEL DATAS DOWN ———————————————————————————————————————————

    /**
     * Getter of the database's map
     * @return string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    public function getDbMap();

    /**
     * Getter of the Language
     * @return Language a protected copy of the Visitor's current language
     */
    public function getLanguage();

    /**
     * Getter of the Currency
     * @return Currency a protected copy of the Visitor's current Currency
     */
    public function getCurrency();

    /**
     * Getter of the Country
     * @return Country a protected copy of the Visitor's current Country
     */
    public function getCountry();

    /**
     * Getter of the Measures
     * @return Measure[] a protected copy of the Visitor's Measures
     */
    public function getMeasures();

    //————————————————————————————————————————————— GET MODEL DATAS UP —————————————————————————————————————————————
    //————————————————————————————————————————————— BUILD MODEL DATAS DOWN —————————————————————————————————————————

    /**
     * Use the URL to create a complete Search
     * @return Search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     */
    public function getGETSearch();

    /**
     * Use the POST datas of the query to create a complete Search
     * @return Search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     */
    public function getPOSTSearch();

    /**
     * @param string[] $criterions list of criterions
     *  $criterions = [
     *      "prodIds" => int[],
     *      "collections" => string[],
     *      "product_types" => string[],
     *      "functions" => string[],
     *      "categories" => string[],
     *      "colors" => string[],
     *      "sizes" => string[],
     *      "minprice" => double,
     *      "maxprice" => double,
     *      "order" => string
     *  ]
     * @return Search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     */
    public function getSystemSearch($criterions);

    /**
     * To get the measure with its id posted($_POST)
     * @return Response contain the Measure matching the id or Myerrrors
     */
    public function getMeasurePOST();
    //————————————————————————————————————————————— BUILD MODEL DATAS UP ———————————————————————————————————————————
    /**
     * The toString of Visitor
     */
    public function __toString();
}
