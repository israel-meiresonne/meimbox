<?php

require_once 'framework/Model.php';
require_once 'framework/Configuration.php';
require_once 'model/special/Query.php';
require_once 'model/special/MyError.php';
require_once 'model/special/Response.php';
require_once 'model/special/Map.php';

/**
 * This class provide to model's classes common function
 */
abstract class ModelFunctionality extends Model
{
    /**
     * Counter for code generator
     * @var int
     */
    private static $counter = 0;

    /**
     * Holds db's Constants table in map format
     * @var string[] specified in file model/special/dbMap.txt
     */
    private static $constants;

    /**
     * Holds the access key from Constant table to get length of db types
     * @var string
     */
    private const DB_TYPES_LENGTH = "DB_TYPES_LENGTH";

    /**
     * Holds db's Currencies table in map format
     * @var string[] specified in file model/special/dbMap.txt
     */
    private static $currencies;

    /**
     * Holds db's Languages table in map format
     * @var string[] specified in file model/special/dbMap.txt
     */
    private static $languages;

    /**
     * Holds db's Countries table in map format
     * @var string[] specified in file model/special/dbMap.txt
     */
    private static $countries;

    /**
     * One column table of values from db
     * @var string[]
     */
    private static $collectionsMap;
    private static $product_types;
    private static $functions;
    private static $categoriesMap;
    private static $sizes;
    private static $supoortedSizes;
    private static $cuts;
    private static $colors;
    private static $productIDList; //X
    private static $brandsMeasures; //X

    /**
     * Holds db's Products table in map format
     * @var string[]
     */
    private static $productMap;

    /**
     * Holds db's MeasureUnits table in map format
     * @var string[]
     */
    private static $unitMap;

    /**
     * Holds columns length for each db's table
     * + $desciptions = [
     *      tableName{string} => [
     *          column{string} => int
     *      ]
     * ]
     */
    private static $desciptions;

    /**
     * Holds db's BoxColors, BoxPrices, BoxShippings and BoxDisciunts tables in map format
     * +$boxMap[
     *      boxcolor{string} =>[
     *              "sizeMax" => int,
     *              "weight" => double,
     *              "boxColorRGB" => string,
     *              "priceRGB" => string,
     *              "textualRGB" => string,
     *              "boxPicture" => string,
     *              "stock" => int,
     *              "price" => float,
     *              "shipping" => [
     *                      "shipPrice" => float,
     *                      "time" => int,
     *                  ],
     *              "discount" => [
     *                      "value" => float,
     *                      "beginDate" => DATETIME,
     *                      "endDate" => DATETIME
     *                  ],
     *              "arguments" => [
     *                      "advantage" => [    // ordered from lower index to highest
     *                              index{int} => string
     *                          ]
     *                      "drawback" => [    // ordered from lower index to highest
     *                              index{int} => string
     *                          ]
     *                  ]
     *          ]
     * ]
     * @var string[]
     */
    private static $boxMap;

    /**
     * @var Map
     */
    private static $usersCookiesMap;

    /**
     * Holds cookies datas need to config cookies
     * @var Map
     */
    private static $cookiesMap;

    /**
     * Holds cookies datas need to config cookies
     * @var string[]
     */
    private static $sexesMap;

    /**
     * Holds supported payement methods
     * @var Map
     * + payementMap[Map::payID] => [
     * + + Map::payMethod
     * + + Map::company
     * + + Map::cancelPath
     * + + Map::successPath
     * + ]
     */
    private static $payementMap;

    /**
     * Holds datas about company
     * @var Map
     */
    protected static $INFOS_COMPANY;

    /**
     * Holds datas from Tutorials table
     * @var Map
     * Map[tutoID{string}][stepID{int}][Map::id]            =>  {string}    Tutorial's id
     * Map[tutoID{string}][stepID{int}][Map::index]         =>  {int}       step's id
     * Map[tutoID{string}][stepID{int}][Map::code]          =>  {string}    event code
     * Map[tutoID{string}][stepID{int}][Map::name]          =>  {string}    name of the step
     * Map[tutoID{string}][stepID{int}][Map::direction]     =>  {string}    must match Vieuw's directions
     * Map[tutoID{string}][stepID{int}][Map::content]       =>  {string}
     * Map[tutoID{string}][stepID{int}][Map::cookieID]      =>  {string}    id of the cookie to drop when
     *                                                                      Turial is completed
     */
    protected static $tutorialsMap;

    /**
     * PDOStatement success code
     * @var string
     */
    private const PDO_SUCCEESS = "00000";

    /**
     * Holds access keys for CRUD
     */
    public const CRUD_STATUS = "crud_status";

    public const DATE_FORMAT = "Y-m-d H:i:s";
    /*———————————————————————————— CRUD DOWN ————————————————————————————————*/

    /**
     * Execute a SQL INSERT of values passed in param with the query
     * @param string $sql the complete sql query ex: "INSERT INTO `Products`(`prodID`, `prodName`) VALUES (?,?), (?,?), etc..."
     * @param mixed[] $params list of values to insert
     * @return Response if its success Response.results[INSERT_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    protected static function insert(Response $response, $sql, $params)
    {
        // $response = new Response();
        try {
            $pdo = parent::executeRequest($sql, $params);
            $pdoStatus = $pdo->errorInfo()[0];

            // ($pdoStatus == self::PDO_SUCCEESS) ? $response->addResult(self::CRUD_STATUS, $pdoStatus)
            //     : $response->addError($pdoStatus->errorInfo()[2], self::CRUD_STATUS);
            ($pdoStatus != self::PDO_SUCCEESS) ? $response->addError($pdoStatus->errorInfo()[2], self::CRUD_STATUS)
                : null;
        } catch (\Throwable $e) {
            $map = new Map();
            $map->put($e->errorInfo, Map::message);
            $map->put($sql, Map::sql);
            $map->put($params, Map::params);
            $response->addError($map->getMap(), MyError::ADMIN_ERROR);
        }
    }

    /**
     * Execute a SQL query on the  db and return the résulte in a array
     * @param string $sql the sql query like "SELECT * FROM ... WHERE ... etc..."
     * @return array the résulte of the query
     */
    protected static function select($sql)
    {
        $select = parent::executeRequest($sql);

        if ($select->rowCount() > 0) {
            return $select->fetchAll();
        } else {
            return [];
        }
    }

    /**
     * Execute a SQL UPDATE with the query given in param
     * @param string $sql the complete sql query ex: "UPDATE `UsersMeasures` SET userId`=?, measureID=? WHERE ..."
     * @param mixed[] $params list of values to insert
     * @return Response if its success Response.results[UPDATE_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    protected static function update(Response $response, $sql, $params)
    {
        return self::insert($response, $sql, $params);
    }

    /**
     * Execute a SQL DELETE with the query given in param
     * @param string $sql the complete sql query ex: "DELETE FROM `UsersMeasures` WHERE ..."
     * @return Response if its success Response.results[DELETE_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    public static function delete(Response $response, $sql)
    {
        return self::insert($response, $sql, null);
    }

    /**
     * Build bracket for SQL INSERT
     * @param int $nb how musch $bracket is needed
     * @param string $bracket = "(?,?,?,?,...)";
     */
    protected static function buildBracketInsert($nb, $bracket)
    {
        $query = " ";
        for ($i = 0; $i < $nb; $i++) {
            if ($i == 0) {
                $query .= $bracket;
            } else {
                $query .= ", " . $bracket;
            }
        }
        return $query;
    }
    /*———————————————————————————— CRUD UP ——————————————————————————————————*/
    /*———————————————————————————— STATIC TABLES ACCESS DOWN ————————————————*/

    /**
     * To get db line with constante values
     * @return string[] table with constante values
     */
    protected static function getConstantLine($key)
    {
        !isset(self::$constants) ? self::setConstantsMap() : null;
        if (!key_exists($key, self::$constants)) {
            throw new Exception("This constante '$key' don't exist!");
        }
        return self::$constants[$key];
    }

    /**
     * Set constante map with db
     */
    private static function setConstantsMap()
    {
        self::$constants = [];
        $sql = "SELECT * FROM `Constants`";
        $tab = self::select($sql);
        foreach ($tab as $tabLine) {
            self::$constants[$tabLine["constName"]]["stringValue"] = $tabLine["stringValue"];
            self::$constants[$tabLine["constName"]]["jsonValue"] = $tabLine["jsonValue"];
            self::$constants[$tabLine["constName"]]["setDate"] = $tabLine["setDate"];
            self::$constants[$tabLine["constName"]]["description"] = $tabLine["description"];
        }
    }

    /**
     * Check if a currency exist in currencies map
     * @param string $isoCurrency currncy's iso code
     * @return boolean true if currency exist else false
     */
    protected function existCurrency($isoCurrency)
    {
        !isset(self::$currencies) ? $this->setCurrenciesMap() : null;
        return key_exists($isoCurrency, self::$currencies);
    }

    /**
     * To get db line with currency values
     * @param string $isoCurrency currncy's iso code
     * @return string[] table with iso currency values
     */
    protected function getCurrencyLine($isoCurrency)
    {
        !isset(self::$currencies) ? $this->setCurrenciesMap() : null;
        if (!key_exists($isoCurrency, self::$currencies)) {
            throw new Exception("This currency don't exist!");
        }
        return self::$currencies[$isoCurrency];
    }

    /**
     * Set currencies map with db
     */
    private function setCurrenciesMap()
    {
        self::$currencies = [];
        $sql = 'SELECT * FROM `Currencies`';
        $tab = $this->select($sql);
        foreach ($tab as $tabLine) {
            self::$currencies[$tabLine["isoCurrency"]]["currencyName"] = $tabLine["currencyName"];
            self::$currencies[$tabLine["isoCurrency"]]["symbol"] = $tabLine["symbol"];
            self::$currencies[$tabLine["isoCurrency"]]["EURtoCurrency"] = (float) $tabLine["EURtoCurrency"];
            self::$currencies[$tabLine["isoCurrency"]]["isDefault"] = $tabLine["isDefault"]  == 1;

            if (self::$currencies[$tabLine["isoCurrency"]]["isDefault"]) {
                self::$currencies["default"]["isoCurrency"] = $tabLine["isoCurrency"];
                self::$currencies["default"]["currencyName"] = $tabLine["currencyName"];
                self::$currencies["default"]["symbol"] = $tabLine["symbol"];
                self::$currencies["default"]["EURtoCurrency"] = (float) $tabLine["EURtoCurrency"];
                self::$currencies["default"]["isDefault"] = $tabLine["isDefault"]  == 1;
            }
        }
    }

    /**
     * Check if a language exist in currencies map
     * @param string $isoLang language's iso code
     * @return boolean true if language exist else false
     */
    protected function existLanguage($isoLang)
    {
        !isset(self::$languages) ? $this->setLanguageMap() : null;
        return key_exists($isoLang, self::$languages);
    }

    /**
     * To get db line with language values
     * @param string $isoLang currncy's iso code
     * @return string[] table with iso language values
     */
    protected function getLanguageLine($isoLang)
    {
        !isset(self::$languages) ? $this->setLanguageMap() : null;
        if (!key_exists($isoLang, self::$languages)) {
            throw new Exception("This language don't exist!");
        }
        return self::$languages[$isoLang];
    }

    /**
     * Set languages map with db
     */
    private function setLanguageMap()
    {
        self::$languages = [];
        $tab = $this->select("SELECT * FROM `Languages`");
        foreach ($tab as $tabLine) {
            self::$languages[$tabLine["langIsoCode"]]["langName"] = $tabLine["langName"];
            self::$languages[$tabLine["langIsoCode"]]["langLocalName"] = $tabLine["langLocalName"];
        }
    }

    /**
     * Check if a country exist in Countries map
     * @param string $countryName country's english name
     * @return boolean true if country exist else false
     */
    protected function existCountry($countryName)
    {
        !isset(self::$countries) ? self::setCountrys() : null;
        return key_exists($countryName, self::$countries);
    }

    /**
     * To get db line with country values
     * @param string $countryName country's english name
     * @return string[] table with iso country values
     */
    protected function getCountryLine($countryName)
    {
        !isset(self::$countries) ? self::setCountrys() : null;
        if (!key_exists($countryName, self::$countries)) {
            throw new Exception("This country don't exist!");
        }
        return self::$countries[$countryName];
    }

    /**
     * To get db's country values in map format
     * @param string $countryName country's english name
     * @return string[] table with iso country values
     */
    protected static function getCountriesDb()
    {
        !isset(self::$countries) ? self::setCountrys() : null;
        return self::$countries;
    }

    /**
     * Set country map with db
     */
    private static function setCountrys()
    {
        self::$countries = [];
        $query = 'SELECT * FROM `Countries`';
        $tab = self::select($query);

        foreach ($tab as $tabLine) {
            self::$countries[$tabLine["country"]]["isoCountry"] = $tabLine["isoCountry"];
            self::$countries[$tabLine["country"]]["iso_currency"] = $tabLine["iso_currency"];
            self::$countries[$tabLine["country"]]["isUE"] = ($tabLine["isUE"] == 1);
            self::$countries[$tabLine["country"]]["vat"] = (float) $tabLine["vat"];

            // $isoCountry = $tabLine["isoCountry"];
            // self::$countries[$isoCountry]["country"] = $tabLine["country"];
            // self::$countries[$isoCountry]["iso_currency"] = $tabLine["iso_currency"];
            // self::$countries[$isoCountry]["isUE"] = ($tabLine["isUE"] == 1);
            // self::$countries[$isoCountry]["vat"] = (float) $tabLine["vat"];
        }
    }

    /**
     * Check if a measure unit exist in MeasureUnits map
     * @param string $unitName unit (ex: uk, us, centimeter, meter, foot|feet, etc...)
     * @return boolean true if unit exist else false
     */
    protected function existUnit($unitName)
    {
        !isset(self::$unitMap) ? $this->setUnitMap() : null;
        return key_exists($unitName, self::$unitMap);
    }

    /**
     * To get db line with country values
     * @param string $unitName unit (ex: uk, us, centimeter, meter, foot|feet, etc...)
     * @return string[] line with unit values
     */
    protected function getUnitLine($unitName)
    {
        !isset(self::$unitMap) ? $this->setUnitMap() : null;
        if (!key_exists($unitName, self::$unitMap)) {
            throw new Exception("This unit don't exist!");
        }
        return self::$unitMap[$unitName];
    }


    /**
     * Getter for db's MeasureUnits table
     * @return string[] db's MeasureUnits table
     */
    protected function getUnitsTable()
    {
        (!isset(self::$unitMap)) ? $this->setUnitMap() : null;
        return self::$unitMap;
    }

    /**
     * Set country map with db
     */
    private function setUnitMap()
    {
        self::$unitMap = [];
        $query = 'SELECT * FROM `MeasureUnits`';
        $tab = $this->select($query);
        foreach ($tab as $tabLine) {
            self::$unitMap[$tabLine["unitName"]]["measureUnit"] = $tabLine["measureUnit"];
            self::$unitMap[$tabLine["unitName"]]["toSystUnit"] = !empty($tabLine["toSystUnit"]) ? (float) $tabLine["toSystUnit"] : null;
        }
    }

    /**
     * To get box datas from db
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     * @return string[] box's datas in a box map
     */
    protected static function getBoxMap(Country $country, Currency $currency)
    {
        (!isset(self::$boxMap)) ? self::setBoxMap($country, $currency) : null;
        if (count(self::$boxMap) == 0) {
            throw new Exception("The box map can't be empty:");
        }
        return self::$boxMap;
    }

    /**
     * To get Box's advantage and drowback
     * @param string $boxColor box's color (GOLD, SILVER, REGULAR, ...)
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     * @return string[] map with box's advantage and drowback
     * + $arguments = [
     *      "advantage" => [    // ordered from lower index to highest
     *              index{int} => string
     *          ]
     *      "drawback" => [    // ordered from lower index to highest
     *              index{int} => string
     *          ]
     * ]
     */
    protected static function getBoxArguments($boxColor, Country $country, Currency $currency)
    {
        $boxMap = self::getBoxMap($country, $currency);
        (!isset($boxMap[$boxColor]["arguments"])) ? self::setBoxArguments($country, $currency) : null;
        if (count(self::$boxMap[$boxColor]["arguments"]) == 0) {
            throw new Exception("The box map can't be empty:");
        }
        return self::$boxMap[$boxColor]["arguments"];
    }

    // /**
    //  * Check if a boxMap's attribut is set for each box
    //  * @param string $attr access key of one boxMap's attribute
    //  * @return boolean truee if it set else false
    //  */
    // private function boxAttrIsset($attr)
    // {
    //     if (isset(self::$boxMap)) {
    //         return false;
    //     }
    //     foreach (self::$boxMap as $datas) {
    //         if (!key_exists($attr, $datas)) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    /**
     * Setter for boxMap
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private static function setBoxMap(Country $country, Currency $currency)
    {
        self::$boxMap = [];
        $countryName = $country->getCountryName();
        $isocurrency = $currency->getIsoCurrency();
        $sql = "SELECT * 
        FROM `BoxColors` bc
        JOIN `BoxPrices` bp ON bc.boxColor  = bp.box_color
        JOIN `BoxShipping` bs ON bc.boxColor  = bs.box_color
        LEFT JOIN `BoxDiscounts` bd ON bc.boxColor  = bd.box_color
        WHERE bp.country_ = '$countryName' AND bp.iso_currency = '$isocurrency' 
        AND bs.country_ = '$countryName' AND bs.iso_currency = '$isocurrency'
        AND (bd.country_ = '$countryName' OR bd.country_ IS NULL)";
        $tab = self::select($sql);
        foreach ($tab as $tabLine) {
            self::$boxMap[$tabLine["boxColor"]]["sizeMax"] = (int) $tabLine["sizeMax"];
            self::$boxMap[$tabLine["boxColor"]]["weight"] = (float) $tabLine["weight"];
            self::$boxMap[$tabLine["boxColor"]]["boxColorRGB"] = $tabLine["boxColorRGB"];
            self::$boxMap[$tabLine["boxColor"]]["priceRGB"] = $tabLine["priceRGB"];
            self::$boxMap[$tabLine["boxColor"]]["textualRGB"] = $tabLine["textualRGB"];
            self::$boxMap[$tabLine["boxColor"]]["boxPicture"] = $tabLine["boxPicture"];
            self::$boxMap[$tabLine["boxColor"]]["stock"] = (int) $tabLine["stock"];
            self::$boxMap[$tabLine["boxColor"]]["price"] = (float) $tabLine["price"];
            self::$boxMap[$tabLine["boxColor"]]["shipping"]["shipPrice"] = (float) $tabLine["shipPrice"];
            self::$boxMap[$tabLine["boxColor"]]["shipping"]["minTime"] = (int) $tabLine["minTime"];
            self::$boxMap[$tabLine["boxColor"]]["shipping"]["maxTime"] = (int) $tabLine["maxTime"];
            self::$boxMap[$tabLine["boxColor"]]["discount"]["value"] = (float) $tabLine["discount_value"];
            self::$boxMap[$tabLine["boxColor"]]["discount"]["beginDate"] = $tabLine["beginDate"];
            self::$boxMap[$tabLine["boxColor"]]["discount"]["endDate"] = $tabLine["endDate"];
        }
    }

    /**
     * Setter for box's arguments
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private static function setBoxArguments(Country $country, Currency $currency)
    {
        $boxMap = self::getBoxMap($country, $currency);
        $sql = "SELECT * FROM `BoxArguments`";
        $tab = self::select($sql);
        foreach ($tab as $tabLine) {
            $boxColor = $tabLine["box_color"];
            $argID = (int) $tabLine["argID"];
            $argType = $tabLine["argType"];
            $boxMap[$boxColor]["arguments"][$argType][$argID] = $tabLine["argValue"];
        }
        foreach ($boxMap as $boxColor => $datas) {
            (!empty($boxMap[$boxColor]["arguments"]["advantage"])) ? ksort($boxMap[$boxColor]["arguments"]["advantage"])
                : $boxMap[$boxColor]["arguments"]["advantage"] = [];
            (!empty($boxMap[$boxColor]["arguments"]["drawback"])) ? ksort($boxMap[$boxColor]["arguments"]["drawback"])
                : $boxMap[$boxColor]["arguments"]["drawback"] = [];
        }
        self::$boxMap = $boxMap;
    }

    /**
     * Setter for the Cuts table from db
     */
    private static function setCutsTable()
    {
        self::$cuts = [];
        $sql = "SELECT * FROM `Cuts`";
        $tab = self::select($sql);
        foreach ($tab as $tabLine) {
            $cutName = $tabLine["cutName"];
            $cutMeasure = $tabLine["cutMeasure"];
            $unit_name = $tabLine["unit_name"];
            self::$cuts[$cutName]["cutMeasure"] = (float) $cutMeasure;
            self::$cuts[$cutName]["unit_name"] = $unit_name;
        }
    }

    /**
     * To get values from some tables
     * @return string[] one column table containing value used in this table
     */
    protected static function getTableValues($tableName)
    {
        $table = [];
        switch ($tableName) {
            case "collections":
                (!isset(self::$collectionsMap)) ? self::$collectionsMap = self::getTable("SELECT DISTINCT `collection_name` FROM `Products-Collections`")
                    : null;
                $table = self::$collectionsMap;
                break;
            case "product_types":
                (!isset(self::$product_types)) ? self::$product_types = self::getTable("SELECT DISTINCT `product_type` FROM `Products`")
                    : null;
                $table = self::$product_types;
                break;
            case "functions":
                (!isset(self::$functions)) ? self::$functions = self::getTable("SELECT DISTINCT `function_name` FROM `Products-ProductFunctions`")
                    : null;
                $table = self::$functions;
                break;
            case "categories":
                (!isset(self::$categoriesMap)) ? self::$categoriesMap = self::getTable("SELECT DISTINCT `category_name` FROM `Products-Categories`")
                    : null;
                $table = self::$categoriesMap;
                break;
            case "sizes":
                (!isset(self::$sizes)) ? self::$sizes = self::getTable("SELECT DISTINCT `size_name` FROM `Products-Sizes`")
                    : null;
                $table = self::$sizes;
                break;
            case "supoortedSizes":
                (!isset(self::$supoortedSizes)) ? self::$supoortedSizes = self::getTable("SELECT * FROM `Sizes`")
                    : null;
                $table = self::$supoortedSizes;
                break;
            case "cuts":
                (!isset(self::$cuts)) ? self::setCutsTable() : null;
                $table = self::$cuts;
                break;
            case "colors":
                (!isset(self::$colors)) ? self::$colors = self::getTable("SELECT DISTINCT `colorName` FROM `Products`")
                    : null;
                $table = self::$colors;
                break;
            case "productIDList":
                (!isset(self::$productIDList)) ? self::$productIDList = self::getTable("SELECT `prodID` FROM `Products` ORDER BY `Products`.`prodID` ASC")
                    : null;
                $table = self::$productIDList;
                break;
            case "Sexes":
                (!isset(self::$sexesMap)) ? self::$sexesMap = self::getTable("SELECT * FROM `Sexes`")
                    : null;
                $table = self::$sexesMap;
                break;
            default:
                throw new Exception("This table don't exist");
        }
        return $table;
    }

    /**
     * Extract from a database table all the value of all column and push them in one array
     * @param string $query a SQL query
     * @return string[] an array containing value of all column of a database table
     */
    private static function getTable($query)
    {
        $table = [];
        $queryTable = self::select($query);

        $stringKey = self::getStringKey($queryTable);
        $nbKey = count($stringKey);
        foreach ($queryTable as $line) {
            for ($i = 0; $i < $nbKey; $i++) {
                array_push($table, $line[$stringKey[$i]]);
            }
        }
        return $table;
    }

    /**
     * Extract from array given in param all the string key
     * @return string[] array of string key of the array given in param
     */
    private static function getStringKey($table)
    {
        $keys = array_keys($table[0]);
        $stringKey = [];

        foreach ($keys as $key) {
            if (preg_match("#^[a-zA-Z-_]*$#", $key) == 1) {
                array_push($stringKey, $key);
            }
        }

        return $stringKey;
    }

    /**
     * Getter for db's BrandsMeasures table
     * @return string[] db's BrandsMeasures table
     */
    protected function getBrandMeasuresTable()
    {
        (!isset(self::$brandsMeasures)) ? $this->setBrandsMeasures() : null;
        return self::$brandsMeasures;
    }

    /**
     * Setter for BrandsMeasures table
     */
    private function setBrandsMeasures()
    {
        self::$brandsMeasures = [];
        // $sql = "SELECT * 
        // FROM `BrandsMeasures` bm
        // JOIN `BrandsPictures` bp ON bm.brandName = bp.brand_name";
        $sql = "SELECT *
        FROM `BrandsMeasures` bm
        JOIN `BrandsPictures` bp ON bm.brandName = bp.brand_name";
        $tab = $this->select($sql);
        foreach ($tab as $tabLine) {
            $brandName = $tabLine["brandName"];
            $size_name = $tabLine["size_name"];
            $body_part = $tabLine["body_part"];
            $unit_name = $tabLine["unit_name"];
            $minMax = $tabLine["minMax"];
            $value = !empty($tabLine["value"]) ? (float) $tabLine["value"] : null;
            $pictureID = $tabLine["pictureID"];
            $picture = $tabLine["picture"];
            self::$brandsMeasures[$brandName][$size_name][$body_part][$unit_name][$minMax] = $value;
            self::$brandsMeasures[$brandName]["brandPictures"][$pictureID] = $picture;
        }
    }

    /**
     * To get cookies datas from db to config cookies
     * @return Map cookies datas
     */
    protected static function getCookiesMap()
    {
        (!isset(self::$cookiesMap)) ? self::setCookiesMap() : null;
        return self::$cookiesMap;
    }

    /**
     * To set cookiesMap
     */
    private static function setCookiesMap()
    {
        self::$cookiesMap = new Map();
        $sql = "SELECT * FROM `Cookies`";
        $tab = self::select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                // self::$cookiesMap->put($tabLine["cookieID"], Map::cookieID);
                $cookieID = $tabLine["cookieID"];
                $period = (int)$tabLine["cookiePeriod"];
                self::$cookiesMap->put($period, $cookieID, Map::period);
                self::$cookiesMap->put($tabLine["cookieDomain"], $cookieID, Map::domain);
                self::$cookiesMap->put($tabLine["cookiePath"], $cookieID, Map::path);

                $cookieSecure = (bool)$tabLine["cookieSecure"];
                self::$cookiesMap->put($cookieSecure, $cookieID, Map::secure);

                $cookieHttponly = (bool)$tabLine["cookieHttponly"];
                self::$cookiesMap->put($cookieHttponly, $cookieID, Map::httponly);
            }
        }
    }

    /**
     * To get Visitor's cookies
     * @param string $userID Visitor's id
     * @return Map Visitor's cookies
     */
    protected function getUsersCookiesMap($userID)
    {
        (isset(self::$usersCookiesMap) && (self::$usersCookiesMap->get(Map::userID) == $userID))
            ?  null
            : self::setUsersCookiesMap($userID);
        self::setUsersCookiesMap($userID);
        return self::$usersCookiesMap;
    }

    /**
     * To set cookiesMap
     * @param string $userID Visitor's id
     */
    private static function setUsersCookiesMap($userID)
    {
        self::$usersCookiesMap = new Map();
        $sql = "SELECT * FROM `Users-Cookies` WHERE `userId` = '$userID'";
        $tab = self::select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $cookieID = $tabLine["cookieId"];
                // self::$usersCookiesMap->put($tabLine["cookieId"], Map::cookieID);
                // self::$usersCookiesMap->put($userID, Map::userID);
                self::$usersCookiesMap->put($tabLine["cookieValue"], $cookieID, Map::value);
                self::$usersCookiesMap->put($tabLine["setDate"], $cookieID, Map::setDate);
                self::$usersCookiesMap->put($tabLine["settedPeriod"], $cookieID, Map::settedPeriod);
            }
        }
    }

    /**
     * To get from db supported payement methods and their datas
     * @return Map supported payement methods and their datas
     * + payementMap[Map::payID] => [
     * + + Map::payMethod
     * + + Map::company
     * + + Map::cancelPath
     * + + Map::successPath
     * + ]
     */
    protected static function getPayementMap()
    {
        (!isset(self::$payementMap)) ? self::setPayementMap() : null;
        return self::$payementMap;
    }

    /**
     * To initialize the payementMap
     */
    private static function setPayementMap()
    {
        self::$payementMap = new Map();
        $sql = "SELECT * FROM `Payements`";
        $tab = self::select($sql);
        if (!empty($tab)) {
            foreach ($tab as $tabLine) {
                //  = $tab[0];
                $payID = $tabLine["payID"];
                self::$payementMap->put($tabLine["payMethod"], $payID, Map::payMethod);
                self::$payementMap->put($tabLine["company_"], $payID, Map::company);
                self::$payementMap->put($tabLine["cancelPath"], $payID, Map::cancelPath);
                self::$payementMap->put($tabLine["successPath"], $payID, Map::successPath);
            }
        }
    }

    /**
     * 
     */
    protected static function getCompanyMap()
    {
        (!isset(self::$INFOS_COMPANY)) ? self::setCompanyMap() : null;
        return self::$INFOS_COMPANY;
    }

    /**
     * To set company datas
     */
    private static function setCompanyMap()
    {
        self::$INFOS_COMPANY = "INFOS_COMPANY";
        $json = self::getConstantLine(self::$INFOS_COMPANY)["jsonValue"];
        $companyMap = json_decode($json, true);
        self::$INFOS_COMPANY = new Map($companyMap);
    }

    /**
     * To get turial map with the given id
     * @param string $tutoID    id of the Tutorial datas to get
     * @return Map  turial map
     */
    protected static function getTutorialMap(string $tutoID)
    {
        if (!isset(self::$tutorialsMap)) {
            self::addTutorial($tutoID);
            $steps = self::$tutorialsMap->get($tutoID);
        } else {
            $steps = self::$tutorialsMap->get($tutoID);
            (empty($steps)) ? self::addTutorial($tutoID) : null;
            $steps = (empty($steps)) ? self::$tutorialsMap->get($tutoID) : $steps;
        }
        if(empty($steps)){
            throw new Exception("There's no Tutorial with this id '$tutoID'");
        }
        return new Map($steps);
    }

    /**
     * To add a new tutorial in TutorialsMap
     */
    private static function addTutorial(string $tutoID)
    {
        (!isset(self::$tutorialsMap)) ? self::$tutorialsMap = new Map() : null;
        $sql = "SELECT * FROM `Tutorials` WHERE `tutoID`='$tutoID'  
                ORDER BY `Tutorials`.`stepID` ASC";
        $tab = self::select($sql);
        if(!empty($tab)){
            foreach($tab as $tabLine){
                $id = $tabLine["tutoID"];
                $stepID = (int) $tabLine["stepID"];
                self::$tutorialsMap->put($id,                    $id, $stepID, Map::id);
                self::$tutorialsMap->put($stepID,                $id, $stepID, Map::index);
                self::$tutorialsMap->put($tabLine["event_code"], $id, $stepID, Map::code);
                self::$tutorialsMap->put($tabLine["stepName"],   $id, $stepID, Map::name);
                self::$tutorialsMap->put($tabLine["direction"],  $id, $stepID, Map::direction);
                self::$tutorialsMap->put($tabLine["content"],    $id, $stepID, Map::content);
                self::$tutorialsMap->put($tabLine["cookieId"],    $id, $stepID, Map::cookieID);
            }
        }
    }

    /*———————————————————————————— STATIC TABLES ACCESS UP ——————————————————*/
    /*———————————————————————————— PRODUCT ACCESS DOWN ——————————————————————*/

    /**
     * Check if a product exist in db's Products table
     * @param string $prodID Product's id
     * @return boolean true if product exist else false
     */
    protected function existProductInDb($prodID)
    {
        if (!isset(self::$productMap) || (!key_exists($prodID, self::$productMap))) {
            $sql = "SELECT * FROM `Products` WHERE `prodID` = '$prodID'";
            $this->setProductMap($sql);
        }
        // return (count(self::$productMap) == 1);
        return (key_exists($prodID, self::$productMap));
    }

    /**
     * Check if a product exist in Product map
     * @param string $prodID Product's id
     * @return boolean true if product exist else false
     */
    protected function existProductInMap($prodID)
    {
        return (!isset(self::$productMap)) ? false : key_exists($prodID, self::$productMap);
    }

    /**
     * To get db line with product's values
     * @param string $prodID Product's id
     * @param string $sql sql query for db's Products table
     * @return string[] line with product's values
     */
    protected function searchProduct($sql)
    {
        $this->setProductMap($sql);
        return self::$productMap;
    }

    /**
     * To get db line with product's values
     * @param string $prodID Product's id
     * @return string[] line with product's values
     */
    protected function getProductLine($prodID)
    {
        if ((!isset(self::$productMap)) || (!key_exists($prodID, self::$productMap))) {
            $this->existProductInDb($prodID);
            if ((!isset(self::$productMap)) || (!key_exists($prodID, self::$productMap))) {
                throw new Exception("This product don't exist!");
            }
        }
        return self::$productMap[$prodID];
    }

    /**
     * Set product map with db
     */
    private function setProductMap($sql)
    {
        self::$productMap = [];
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                self::$productMap[$tabLine["prodID"]]["isAvailable"] = ($tabLine["isAvailable"] == 1);
                self::$productMap[$tabLine["prodID"]]["groupID"] = $tabLine["groupID"];
                self::$productMap[$tabLine["prodID"]]["product_type"] = $tabLine["product_type"];
                self::$productMap[$tabLine["prodID"]]["addedDate"] = $tabLine["addedDate"];
                self::$productMap[$tabLine["prodID"]]["colorName"] = $tabLine["colorName"];
                self::$productMap[$tabLine["prodID"]]["colorRGB"] = $tabLine["colorRGB"];
                self::$productMap[$tabLine["prodID"]]["weight"] = empty($tabLine["weight"]) ? null : (float) $tabLine["weight"];
                self::$productMap[$tabLine["prodID"]]["price"] = empty($tabLine["price"]) ? null : (float) $tabLine["price"];
            }
        }
    }
    /*———————————————————————————— PRODUCT ACCESS UP ————————————————————————*/
    /*———————————————————————————— CHECK DATAS DOWN —————————————————————————*/

    /**
     * To get the column's length from db
     * @param string $table db's table name
     * @param string $column column name from table
     * @return int|null column's length from db
     */
    public function getDataLength($table, $column)
    {
        (isset(self::$desciptions) && isset(self::$desciptions[$table])) ? null : $this->setDesciption($table);
        $length = self::$desciptions[$table][$column];
        return ($length > 0) ? $length : null;
    }

    /**
     * Setter for description and its tables
     * @param string $table 
     */
    private function setDesciption($table)
    {
        (!isset(self::$desciptions)) ? self::$desciptions = [] : null;
        self::$desciptions[$table] = [];
        $tab = $this->select("DESCRIBE " . $table);

        foreach ($tab as $tabLine) {
            $column = $tabLine["Field"];
            $typeCol = $tabLine["Type"];
            self::$desciptions[$table][$column] = $this->getTypeToLength($typeCol);
        }
    }

    /**
     * Indentifie the type and exctract its length
     * @return int $typeCol the type's length
     */
    private function getTypeToLength($typeCol)
    {
        $types = [];
        // preg_match("#[a-zA-Z]+#", $typeCol, $type);
        if (preg_match("#[a-zA-Z]+#", $typeCol, $types) != 1) {
            throw new Exception("The table type [$typeCol] is not handled!");
        }

        $type = strtolower($types[0]);
        $filtre = [$type, "(", ")"];
        switch ($type) {
            case "varchar":
                $length = str_replace($filtre, "", $typeCol);
                break;

            case "int":
                $length = str_replace($filtre, "", $typeCol);
                break;

            case "double":
                // $length = 11;
                $jsonLine = $this->getConstantLine(self::DB_TYPES_LENGTH);
                $typeMap = json_decode($jsonLine["jsonValue"]);
                $length = $typeMap->double;
                break;

            case "datetime":
                // $length = 25; // {2017-01-08 00:00:00} length = 19
                $jsonLine = $this->getConstantLine(self::DB_TYPES_LENGTH);
                $typeMap = json_decode($jsonLine["jsonValue"]);
                $length = $typeMap->datetime;
                break;

            case "date":
                // $length = 15; // {1993-02-27} length = 10
                $jsonLine = $this->getConstantLine(self::DB_TYPES_LENGTH);
                $typeMap = json_decode($jsonLine["jsonValue"]);
                $length = $typeMap->date;
                break;

            case "tinyint": // boolean
                // $length = 5;  // {0}, {1} length = 1
                $jsonLine = $this->getConstantLine(self::DB_TYPES_LENGTH);
                $typeMap = json_decode($jsonLine["jsonValue"]);
                $length = $typeMap->tinyint;
                break;

            case "json":
                // $length = 16776192;
                $jsonLine = $this->getConstantLine(self::DB_TYPES_LENGTH);
                $typeMap = json_decode($jsonLine["jsonValue"]);
                $length = $typeMap->json;
                break;

            case "enum":
                // $length = -1;
                $jsonLine = $this->getConstantLine(self::DB_TYPES_LENGTH);
                $typeMap = json_decode($jsonLine["jsonValue"]);
                $length = $typeMap->enum;
                break;

            case "text":
                // $length = 2147483647;
                $jsonLine = $this->getConstantLine(self::DB_TYPES_LENGTH);
                $typeMap = json_decode($jsonLine["jsonValue"]);
                $length = $typeMap->text;
                break;
        }
        return (int) $length;
    }


    /*———————————————————————————— CHECK DATAS UP ———————————————————————————*/
    /*———————————————————————————— SHORTCUT DOWN ————————————————————————————*/
    /**
     * To get today's date into format ["YYYY-MM-DD HH-MM-SS"]. 
     * + NOTE: the time zone is set in ControllerSecured's secureSession function.
     * @return string today's date into format ["YYYY-MM-DD HH-MM-SS"]
     */
    protected static function getDateTime()
    {
        // return date('Y-m-d H:i:s');
        return date(self::DATE_FORMAT);
    }

    /**
     * Generate a alpha numerique sequence in specified length
     * @param int $length
     * @return string alpha numerique sequence in specified length
     */
    protected static function generateCode($length, string $set = '0123456789abcdefghijklmnopqrstuvwxyz')
    {
        if (empty($set)) {
            throw new Exception("Charset can't be empty");
        }
        $characters = $set;
        $sequence = '';
        $nbChar = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, $nbChar);
            $sequence .= $characters[$index];
        }

        return $sequence;
    }

    /**
     * Genarate a sequence code of $length characteres in format 
     * CC...YYMMDDHHmmSSssCC... where C is a alpha numerique sequence. 
     * + NOTE: length must be strictly over 14 characteres cause it's the size of the 
     * date time sequence
     * @param int $length the total length
     * @throws Exception if $length is under or equals 14
     * @return string a alpha numerique sequence with more than 14 
     * characteres 
     */
    public static function generateDateCode($length)
    {
        $sequence = date("YmdHis");
        $sequence = ++self::$counter . $sequence;
        $nbChar = strlen($sequence);
        if ($length <= $nbChar) {
            throw new Exception('$length must be strictly over 14');
        }
        $nbCharToAdd = $length - $nbChar;
        $sequence = ($nbCharToAdd > 0) ? $sequence . self::generateCode($nbCharToAdd) : substr($sequence, 0, $length);
        $sequence = strtolower($sequence);
        return str_shuffle($sequence);
    }

    /**
     * Provide a protected copy of any map containing Object, array or primitives variables. 
     * + NOTE: Objects inside the map must implement a method getCopy() that return the copy
     *  of the Object
     * @param array[array[...]] map to copy
     * @return array[array[...]] a protected copy of the map given in param
     */
    protected function cloneMap($Map)
    {
        // public static function cloneMap($Map){
        // $copyMap = [];
        // $copyMap = $this->cloneMapRec($Map);
        // return $copyMap;
        return $Map;
    }

    /**
     * @param array[array[...]] map to copy
     * @return array[array[...]] a protected copy of the map given in param
     */
    private function cloneMapRec($Map)
    {
        $copyMapRec = [];
        foreach ($Map as $key => $value) {
            switch (gettype($value)) {
                case "array":
                    $copyMapRec[$key] = $this->cloneMapRec($value, $copyMapRec);
                    break;
                case "object":
                    $copyMapRec[$key] = $value->getCopy();
                    break;
                default:
                    $copyMapRec[$key] = $value;
                    break;
            }
        }
        return $copyMapRec;
    }

    /**
     * Build a map that use array's value as key and as value
     * @param string[] $values list of value
     * @return string[] map that use array's value as key and as value
     */
    protected function arrayToMap($values)
    {
        $map = [];
        foreach ($values as $value) {
            $map[$value] = $value;
        }
        return $map;
    }

    /**
     * Fill a array given in param with values of another array given too in param
     * @param string[] $array the array to fill with value of the other array
     * @param string[] $values the array of values to push in the other array
     * @return string[] the array to fill ($array) filled with the values in the passed param $values
     */
    public static function fillArrayWithArray($array, $values) // => array_merge($array, $values)
    {
        // $valueKeys = array_keys($values);
        // $nbValue = count($values);
        // for ($i = 0; $i < $nbValue; $i++) {
        //     array_push($array, $values[$i]);
        // }
        // foreach ($valueKeys as $key) {
        //     if (array_key_exists($key, $array)) {
        //         array_push($array, $values[$key]);
        //     } else {
        //         $array[$key] = $values[$key];
        //     }
        // }
        // return $array;
    }

    /**
     * To convert keys of a array to int
     * + int keys of the first element is 0, the second is 1, and go on
     * @return array with int keys
     */
    protected static function keysToAscInt(array $map)
    {
        $keys = array_keys($map);
        $intKeys = array_keys($keys);
        $intKeysMap = array_combine($intKeys, $map);
        return $intKeysMap;
    }

    /**
     * To get the class calling the function that call this one
     * @return string the class calling the function that call this one
     */
    protected static function getCallingClass()
    {
        $trace = debug_backtrace(null, 5);
        $keyClass = 'class';
        if(!key_exists(2, $trace)){
            throw new Exception("There is not calling class");
        }
        if(!key_exists($keyClass, $trace[2])){
            throw new Exception("The calling file is not a class");
        }
        $class = $trace[2][$keyClass];
        return $class;
    }
    /*———————————————————————————— SHORTCUT UP ——————————————————————————————*/
    /*———————————————————————————— COMMON DOWN ——————————————————————————————*/

    private function copyDebug($obj, $copy)
    {
        $map = get_object_vars($obj);
        $copy = clone $obj;
        var_dump(get_class($obj));
        echo "<hr>";
        // echo "<hr>";
        // var_dump($copy);
        echo "#object is same: ";
        var_dump($obj === $copy);
        echo "<br>";
        foreach ($map as $attr => $value) {
            echo "*[" . gettype($this->{$attr}) . "] $attr is same: ";
            var_dump($obj->{$attr} === $copy->{$attr});
            echo "<br>";
        }
        echo "<hr>";
        echo "<hr>";
    }

    /**
     * Convert value to stable float value
     * @param mixed $value      value to convert
     * @param int $precision    number of decimal
     * @return float value converted to stable float value
     */
    public static function toFloat($value, int $precision = 5)
    {
        return round(((float)$value), $precision);
    }

    /**
     * Encrypt a string
     * @param string $str string to encrypt
     * @return string string encrypted
     */
    public static function encryptString(string $str)
    {
        $strs = str_split(strtolower($str));
        $code = "";
        $abc = [
            "a" => 0,
            "b" => 1,
            "c" => 2,
            "d" => 3,
            "e" => 4,
            "f" => 5,
            "g" => 6,
            "h" => 7,
            "i" => 8,
            "j" => 9,
            "k" => 10,
            "l" => 11,
            "m" => 12,
            "n" => 13,
            "o" => 14,
            "p" => 15,
            "q" => 16,
            "r" => 17,
            "s" => 18,
            "t" => 19,
            "u" => 20,
            "v" => 21,
            "w" => 22,
            "x" => 23,
            "y" => 24,
            "z" => 25
        ];
        // var_dump("strs", $strs);
        $last = count($strs) - 1;
        $i = 0;
        foreach ($strs as $c) {
            $code .= $abc[$c];
            $code .=  ($i < $last) ? "." : "";
            $i++;
        }
        return $code;
    }

    /**
     * Decrypt a string encrypted with encryptString()
     * @param string $code string to encrypt
     * @return string string encrypted
     */
    protected function decryptString($code)
    {
        $codes = explode(".", $code);
        $word = "";
        $abc = [
            "a" => 0,
            "b" => 1,
            "c" => 2,
            "d" => 3,
            "e" => 4,
            "f" => 5,
            "g" => 6,
            "h" => 7,
            "i" => 8,
            "j" => 9,
            "k" => 10,
            "l" => 11,
            "m" => 12,
            "n" => 13,
            "o" => 14,
            "p" => 15,
            "q" => 16,
            "r" => 17,
            "s" => 18,
            "t" => 19,
            "u" => 20,
            "v" => 21,
            "w" => 22,
            "x" => 23,
            "y" => 24,
            "z" => 25
        ];
        $cba = array_flip($abc);
        foreach ($codes as $n) {
            $word .= $cba[$n];
        }
        return $word;
    }

    /**
     * Execute file with datas given and return the result
     * @param string $file Chemin du fichier vue à générer
     * @param array $datas Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */
    protected static function generateFile($file, $datas)
    {
        if (file_exists($file)) {
            extract($datas);
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }
    /*———————————————————————————— COMMON UP ————————————————————————————————*/
}
