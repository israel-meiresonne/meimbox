<?php
class Facade implements Model
{
    /**
     * Can be a Visitor, a Client or a Administrator
     * @var Visitor|Client|Administrator
     */
    private $person;

    /**
     * Holds database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    private $dbMap;

    /**
     * The ID of the system stored in Administrator Table.
     * This default value is used to get the real value stored in Constante 
     * table with the keyword "SYSTEM_ID". In this way we can change the 
     * SYSTEM_ID value without touch the code.
     * @var int
     */
    private static $SYSTEM_ID;

    /**
     * Holds a connection to the database NOTE: dont forget to disconnect at 
     * the end of the ctr object. NOTE: this object can never be give to any 
     * class whatever the need
     * @var Database $db a connection to the database
     */
    private static $db;

    /**
     * Constructor
     */
    function __construct()
    {
        $userID = 651853948;
        // $userID = 666200808;
        self::$db = new Database();
        self::initDbMap(self::$db, $userID);
        self::setConstants();
        self::initSystemDynamicConst();

        switch (self::authenticate()) {
            case "Visitor":
                $this->person = new Visitor($this->dbMap);
                break;
            case "Client":
                $this->person = new Client($this->dbMap);
                break;
        }

        // self::disconnect();
    }

    /**
     * Extract tables from database following format specificated in file 
     * /oop/model/special/dbMap.txt
     * @param Database $db a connection to the database
     * @param int $userID Visitor's database ID
     */
    private function initDbMap($db, $userID)
    {
        $usersMap = $db->getUserMap($userID);
        $languageMap = $db->getLanguageMap();
        $countryMap = $db->getCountryMap();
        $buyCountryMap = $db->getBuyCountryMap();
        $currencyMap = $db->getCurrencyMap();
        $boxMap = $db->getBoxMap($userID);
        $productMap = $db->getProductMap($userID);
        $discountCodeMap = $db->getDiscountCodeMap($userID);
        $constantMap = $db->getConstantMap();
        $stationMap = $db->getStationMap();
        $translationMap = $db->getTranslationMap();
        $collections = $db->getTable("SELECT DISTINCT `collection_name` FROM `Products-Collections`");
        $product_types = $db->getTable("SELECT DISTINCT `product_type` FROM `Products`");
        $functions = $db->getTable("SELECT DISTINCT `function_name` FROM `Products-ProductFunctions`");
        $categories = $db->getTable("SELECT DISTINCT `category_name` FROM `Products-Categories`");
        $sizes = $db->getTable("SELECT DISTINCT `size_name` FROM `Products-Sizes`");
        $colors = $db->getTable("SELECT DISTINCT `colorName` FROM `Products`");
        $brandsMeasures = $db->getBrandsMeasures();
        $measureUnits = $db->getMeasureUnits();
        $bodyParts = $db->getTable("SELECT * FROM `BodyParts`");
        $productIDList = $db->getTable("SELECT `prodID` FROM `Products` ORDER BY `Products`.`prodID` ASC");
        $cuts = $db->getCutsMap();
        $DESCRIPTION = $db->getTablesDescriptions();

        $this->dbMap = [
            "db" => $db,
            "usersMap" => $usersMap,
            "languageMap" => $languageMap,
            "countryMap" => $countryMap,
            "buyCountryMap" => $buyCountryMap,
            "currencyMap" => $currencyMap,
            "boxMap" => $boxMap,
            "productMap" => $productMap,
            "discountCodeMap" => $discountCodeMap,
            // "SYSTEM_ID" => $this->SYSTEM_ID,
            "constantMap" => $constantMap,
            "stationMap" => $stationMap,
            "translationMap" => $translationMap,
            "collections" => $collections,
            "product_types" => $product_types,
            "functions" => $functions,
            "categories" => $categories,
            "sizes" => $sizes,
            "colors" => $colors,
            "brandsMeasures" => $brandsMeasures,
            "measureUnits" => $measureUnits,
            "bodyParts" => $bodyParts,
            "productIDList" => $productIDList,
            "cuts" => $cuts,
            "DESCRIPTION" => $DESCRIPTION
        ];
    }

    /**
     * Initialize Language's constants
     */
    private function setConstants()
    {
        if (!isset(self::$SYSTEM_ID)) {
            self::$SYSTEM_ID = "SYSTEM_ID";
            self::$SYSTEM_ID = (int) $this->dbMap["constantMap"][self::$SYSTEM_ID]["stringValue"];
        }
    }

    /**
     * Initialize dynamique constante of all classes
     */
    private function initSystemDynamicConst()
    {
        new Visitor($this->dbMap);
        new Navigation(null, $this->dbMap);
        new MeasureUnit(null, null, $this->dbMap);
        new Language($this->dbMap);
        new Currency(null, $this->dbMap);
        new Country(null, $this->dbMap);
        new PageContent($this->dbMap);
    }

    /**
     * Check person's cookies and session data to determinate if the person is 
     * a Visitor, a Client or a Administrator
     */
    private function authenticate()
    {
        /*
            get person's cookies and check database for his userID
            if there is any a new one is generated
        */
        return "Client";
    }

    /**
     * Shut down the connection to the database
     */
    private function disconnect()
    {
        self::$db->disconnect();
    }

    /**
     * Execute a SQL INSERT of values passed in param with the query
     * @param string $query the complete query ex: "INSERT INTO `Products`(`prodID`, `prodName`) VALUES (?,?), (?,?), etc..."
     * @param mixed[] $values list of values to insert
     * @return Response if its success Response.results[INSERT_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    public function insert($query, $values)
    {
        return self::$db->insert($query, $values);
    }

    /**
     * Execute a SQL DELETE with the query given in param
     * @param string $query the complete query ex: "DELETE FROM `UsersMeasures` WHERE ..."
     * @return Response if its success Response.results[DELETE_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    public function delete($query)
    {
        return self::$db->delete($query);
    }

    /**
     * Execute a SQL UPDATE with the query given in param
     * @param string $query the complete query ex: "UPDATE `UsersMeasures` SET userId`=?, measureID=? WHERE ..."
     * @param mixed[] $values list of values to insert
     * @return Response if its success Response.results[UPDATE_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    public function update($query, $values)
    {
        return self::$db->update($query, $values);
    }

    //————————————————————————————————————————————— ALTER MODEL DOWN ———————————————————————————————————————————————

    /**
     * Add a new measure to Visitor if input are correct
     * @return Response contain results or Myerrrors
     */
    public function addMeasure()
    {
        return $this->person->addMeasure($this->dbMap);
    }

    /**
     * Delete from database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function deleteMeasure()
    {
        return $this->person->deleteMeasure($this->dbMap);
    }

    /**
     * Update on database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function updateMeasure()
    {
        return $this->person->updateMeasure($this->dbMap);
    }

    //————————————————————————————————————————————— ALTER MODEL UP —————————————————————————————————————————————————
    //————————————————————————————————————————————— GET MODEL DATAS DOWN ———————————————————————————————————————————

    /**
     * Getter of the database's map
     * @return string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    public function getDbMap()
    {
        return $this->dbMap;
    }

    /**
     * Getter of the Language
     * @return Language a protected copy of the Visitor's current language
     */
    public function getLanguage()
    {
        return $this->person->getLanguage();
    }

    /**
     * Getter of the Currency
     * @return Currency a protected copy of the Visitor's current Currency
     */
    public function getCurrency()
    {
        return $this->person->getCurrency();
    }

    /**
     * Getter of the Country
     * @return Country a protected copy of the Visitor's current Country
     */
    public function getCountry()
    {
        return $this->person->getCountry();
    }

    //————————————————————————————————————————————— GET MODEL DATAS UP —————————————————————————————————————————————
    //————————————————————————————————————————————— BUILD MODEL DATAS DOWN —————————————————————————————————————————

    /**
     * Getter of the Measures
     * @return Measure[] a protected copy of the Visitor's Measures
     */
    public function getMeasures()
    {
        return $this->person->getMeasures();
    }

    /**
     * Use the URL to create a complete Search
     * @return Search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     */
    public function getGETSearch()
    {
        $currency = $this->person->getCurrency();
        $search = new Search(Query::GET_MOTHOD, $currency, $this->dbMap);
        $search = $this->completeSearch($search);
        return $search;
    }

    /**
     * Use the POST datas of the query to create a complete Search
     * @return Search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     */
    public function getPOSTSearch()
    {
        $currency = $this->person->getCurrency();
        $search = new Search(Query::POST_MOTHOD, $currency, $this->dbMap);
        $search = self::completeSearch($search);
        return $search;
    }

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
    public function getSystemSearch($criterions)
    {
        $currency = $this->person->getCurrency();
        $method = Search::SYSTEM_SEARCH;
        $search = new Search($method, $criterions, $currency, $this->dbMap);
        $search = self::completeSearch($search);
        return $search;
    }

    /**
     * Complete the Search by setting its products list and search Map
     * @param Search $search uncomplete Search
     * @return Search completed Search
     */
    private function completeSearch($search)
    {
        $country = $this->person->getCountry();
        $currency = $this->person->getCurrency();
        $query = $search->getSQLQuery($country, $currency);
        $productMapSearch = self::$db->getProductMapSearch($query);

        $dbMapSearch = $this->dbMap;
        $dbMapSearch["productMap"] = $productMapSearch;
        $search->setProducts($dbMapSearch);
        return $search;
    }

    /**
     * To get the measure with its id posted($_POST)
     * @return Response contain the Measure matching the id or Myerrrors
     */
    public function getMeasurePOST()
    {
        return $this->person->getMeasurePOST($this->dbMap);
    }

    //————————————————————————————————————————————— BUILD MODEL DATAS UP ———————————————————————————————————————————

    public function __toString()
    {
        $this->person->__toString();
    }
}
