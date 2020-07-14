<?php

require_once 'framework/Model.php';
require_once 'model/special/Query.php';
require_once 'model/special/MyError.php';

/**
 * This class provide to model's classes common function
 */
abstract class ModelFunctionality extends Model
{
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
    private static $collections;
    private static $product_types;
    private static $functions;
    private static $categories;
    private static $sizes;
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
     *                      "price" => float,
     *                      "time" => int,
     *                  ],
     *              "discount" => [
     *                      "value" => float,
     *                      "beginDate" => DATETIME,
     *                      "endDate" => DATETIME
     *                  ]
     *          ]
     * ]
     * @var string[]
     */
    private static $boxMap;

    /**
     * PDOStatement success code
     * @var string
     */
    private const PDO_SUCCEESS = "00000";

    const CRUD_STATUS = "crud_status";

    /*———————————————————————————— INPUT ATTRIBUTS DOWN ———————————————————————*/
    /**
     * Holds the input type
     */
    const CHECKBOX = "checckbox";
    const PSEUDO = "pseudo";
    const NAME = "name";  // handle space and `-`
    const EMAIL = "email";
    const PHONE_NUMBER = "phone";
    const PASSWORD = "psw";
    const BOOLEAN_TYPE = "boolean";
    const STRING_TYPE = "string";
    const NUMBER_FLOAT = "float";
    const NUMBER_INT = "int";
    const ALPHA_NUMERIC = "alpha_numeric";

    const FLOAT_REGEX = "#(^0{1}$)|(^0{1}[.,]{1}[0-9]+$)|(^[1-9]+[0-9]*[.,]?[0-9]*$)#";
    const STRING_REGEX = "#^[a-zA-Z]+$#";
    const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_ ]*$#";
    const PALPHA_NUMERIC_REGEX = "#^[a-zA-Z0-9]+$#";

    /*———————————————————————————— INPUT ATTRIBUTS UP ———————————————————————*/
    /*———————————————————————————— CRUD DOWN ————————————————————————————————*/

    /**
     * Execute a SQL INSERT of values passed in param with the query
     * @param string $sql the complete sql query ex: "INSERT INTO `Products`(`prodID`, `prodName`) VALUES (?,?), (?,?), etc..."
     * @param mixed[] $params list of values to insert
     * @return Response if its success Response.results[INSERT_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    protected function insert(Response $response, $sql, $params)
    {
        // $response = new Response();
        try {
            $pdo = parent::executeRequest($sql, $params);
            $pdoStatus = $pdo->errorInfo()[0];

            ($pdoStatus == self::PDO_SUCCEESS) ? $response->addResult(self::CRUD_STATUS, $pdoStatus)
                : $response->addError($pdoStatus->errorInfo()[2], self::CRUD_STATUS);
        } catch (\Throwable $e) {
            $response->addError($e->errorInfo, MyError::ADMIN_ERROR);
        }
    }

    /**
     * Execute a SQL query on the  db and return the résulte in a array
     * @param string $sql the sql query like "SELECT * FROM ... WHERE ... etc..."
     * @return string[] the résulte of the query
     */
    protected function select($sql)
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
    protected function update(Response $response, $sql, $params)
    {
        return $this->insert($response, $sql, $params);
    }

    /**
     * Execute a SQL DELETE with the query given in param
     * @param string $sql the complete sql query ex: "DELETE FROM `UsersMeasures` WHERE ..."
     * @return Response if its success Response.results[DELETE_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    public function delete(Response $response, $sql)
    {
        return $this->insert($response, $sql, null);
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
    protected function getConstantLine($key)
    {
        !isset(self::$constants) ? $this->setConstantsMap() : null;
        if (!key_exists($key, self::$constants)) {
            throw new Exception("This constante don't exist!");
        }
        return self::$constants[$key];
    }

    /**
     * Set constante map with db
     */
    private function setConstantsMap()
    {
        self::$constants = [];
        $sql = "SELECT * FROM `Constants`";
        $tab = $this->select($sql);
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
        !isset(self::$countries) ? $this->setCountrys() : null;
        return key_exists($countryName, self::$countries);
    }

    /**
     * To get db line with country values
     * @param string $countryName country's english name
     * @return string[] table with iso country values
     */
    protected function getCountryLine($countryName)
    {
        !isset(self::$countries) ? $this->setCountrys() : null;
        if (!key_exists($countryName, self::$countries)) {
            throw new Exception("This country don't exist!");
        }
        return self::$countries[$countryName];
    }

    /**
     * Set country map with db
     */
    private function setCountrys()
    {
        self::$countries = [];
        $query = 'SELECT * FROM `Countries`';
        $tab = $this->select($query);

        foreach ($tab as $tabLine) {
            self::$countries[$tabLine["country"]]["isoCountry"] = $tabLine["isoCountry"];
            self::$countries[$tabLine["country"]]["iso_currency"] = $tabLine["iso_currency"];
            self::$countries[$tabLine["country"]]["isUE"] = ($tabLine["isUE"] == 1);
            self::$countries[$tabLine["country"]]["vat"] = (float) $tabLine["vat"];
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
    protected function getBoxMap($country, $currency)
    {
        (!isset(self::$boxMap)) ? $this->setBoxMap($country, $currency) : null;
        if (count(self::$boxMap) == 0) {
            throw new Exception("The box map can't be empty:");
        }
        return self::$boxMap;
    }

    /**
     * Check if a boxMap's attribut is set for each box
     * @param string $attr access key of one boxMap's attribute
     * @return boolean truee if it set else false
     */
    private function boxAttrIsset($attr)
    {
        if (isset(self::$boxMap)) {
            return false;
        }
        foreach (self::$boxMap as $datas) {
            if (!key_exists($attr, $datas)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Setter for boxMap
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function setBoxMap($country, $currency)
    {
        self::$boxMap = [];
        $countryName = $country->getCountryName();
        $isocurrency = $currency->getIsoCurrency();
        $query = "SELECT * 
        FROM `BoxColors` bc
        JOIN `BoxPrices` bp ON bc.boxColor  = bp.box_color
        JOIN `BoxShipping` bs ON bc.boxColor  = bs.box_color
        JOIN `BoxDiscounts` bd ON bc.boxColor  = bd.box_color
        WHERE bp.country_ = '$countryName' AND bp.iso_currency = '$isocurrency' 
        AND bs.country_ = '$countryName' AND bs.iso_currency = '$isocurrency'
        AND bd.country_ = '$countryName'";
        $tab = $this->select($query);
        foreach ($tab as $tabLine) {
            self::$boxMap[$tabLine["boxColor"]]["sizeMax"] = (int) $tabLine["sizeMax"];
            self::$boxMap[$tabLine["boxColor"]]["weight"] = (float) $tabLine["weight"];
            self::$boxMap[$tabLine["boxColor"]]["boxColorRGB"] = $tabLine["boxColorRGB"];
            self::$boxMap[$tabLine["boxColor"]]["priceRGB"] = $tabLine["priceRGB"];
            self::$boxMap[$tabLine["boxColor"]]["textualRGB"] = $tabLine["textualRGB"];
            self::$boxMap[$tabLine["boxColor"]]["boxPicture"] = $tabLine["boxPicture"];
            self::$boxMap[$tabLine["boxColor"]]["stock"] = (int) $tabLine["stock"];
            self::$boxMap[$tabLine["boxColor"]]["price"] = (float) $tabLine["price"];
            self::$boxMap[$tabLine["boxColor"]]["shipping"]["price"] = (float) $tabLine["price"];
            self::$boxMap[$tabLine["boxColor"]]["shipping"]["time"] = (int) $tabLine["time"];
            self::$boxMap[$tabLine["boxColor"]]["discount"]["value"] = (float) $tabLine["discount_value"];
            self::$boxMap[$tabLine["boxColor"]]["discount"]["beginDate"] = $tabLine["beginDate"];
            self::$boxMap[$tabLine["boxColor"]]["discount"]["endDate"] = $tabLine["endDate"];
        }
    }

    /**
     * Setter for the Cuts table from db
     */
    private function setCutsTable()
    {
        self::$cuts = [];
        $sql = "SELECT * FROM `Cuts`";
        $tab = $this->select($sql);
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
    protected function getTableValues($tableName)
    {
        $table = [];
        switch ($tableName) {
            case "collections":
                (!isset(self::$collections)) ? self::$collections = $this->getTable("SELECT DISTINCT `collection_name` FROM `Products-Collections`")
                    : null;
                $table = self::$collections;
                break;
            case "product_types":
                (!isset(self::$product_types)) ? self::$product_types = $this->getTable("SELECT DISTINCT `product_type` FROM `Products`")
                    : null;
                $table = self::$product_types;
                break;
            case "functions":
                (!isset(self::$functions)) ? self::$functions = $this->getTable("SELECT DISTINCT `function_name` FROM `Products-ProductFunctions`")
                    : null;
                $table = self::$functions;
                break;
            case "categories":
                (!isset(self::$categories)) ? self::$categories = $this->getTable("SELECT DISTINCT `category_name` FROM `Products-Categories`")
                    : null;
                $table = self::$categories;
                break;
            case "sizes":
                (!isset(self::$sizes)) ? self::$sizes = $this->getTable("SELECT DISTINCT `size_name` FROM `Products-Sizes`")
                    : null;
                $table = self::$sizes;
                break;
            case "cuts":
                (!isset(self::$cuts)) ? $this->setCutsTable() : null;
                $table = self::$cuts;
                break;
            case "colors":
                (!isset(self::$colors)) ? self::$colors = $this->getTable("SELECT DISTINCT `colorName` FROM `Products`")
                    : null;
                $table = self::$colors;
                break;
            case "productIDList":
                (!isset(self::$productIDList)) ? self::$productIDList = $this->getTable("SELECT `prodID` FROM `Products` ORDER BY `Products`.`prodID` ASC")
                    : null;
                $table = self::$productIDList;
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
    private function getTable($query)
    {
        $table = [];
        $queryTable = $this->select($query);

        $stringKey = $this->getStringKey($queryTable);
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
    private function getStringKey($table)
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

    // /**
    //  * Setter for MeasureUnits table
    //  */
    // private function setMeasureUnits()
    // {
    //     self::$measureUnits = [];
    //     $sql = "SELECT * FROM `MeasureUnits`";
    //     $tab = $this->select($sql);
    //     foreach ($tab as $tabLine) {
    //         self::$measureUnits[$tabLine["unitName"]]["measureUnit"] = $tabLine["measureUnit"];
    //         self::$measureUnits[$tabLine["unitName"]]["toSystUnit"] = (!empty($tabLine["toSystUnit"])) ? (float) $tabLine["toSystUnit"] : null;
    //     }
    // }

    /*———————————————————————————— STATIC TABLES ACCESS UP ——————————————————*/
    /*———————————————————————————— PRODUCT ACCESS DOWN ——————————————————————*/
    /**
     * Check if a product exist in Product map
     * @param string $prodID Product's id
     * @return boolean true if product exist else false
     */
    protected function existProduct($prodID)
    {
        return (!isset(self::$productMap)) ? false : key_exists($prodID, self::$productMap);
    }

    /**
     * To get db line with product's values
     * @param string $prodID Product's id
     * @return string[] line with product's values
     */
    protected function getProductMap()
    {
        if (!isset(self::$productMap)) {
            throw new Exception("The product Map must first be initialized!");
        }
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
            throw new Exception("This product don't exist!");
        }
        return self::$productMap[$prodID];
    }

    /**
     * Set product map with db
     */
    protected function setProductMap($sql)
    {
        self::$productMap = [];
        $tab = $this->select($sql);
        foreach ($tab as $tabLine) {
            self::$productMap[$tabLine["prodID"]]["prodName"] = $tabLine["prodName"];
            self::$productMap[$tabLine["prodID"]]["isAvailable"] = ($tabLine["isAvailable"] == 1);
            self::$productMap[$tabLine["prodID"]]["product_type"] = $tabLine["product_type"];
            self::$productMap[$tabLine["prodID"]]["addedDate"] = $tabLine["addedDate"];
            self::$productMap[$tabLine["prodID"]]["colorName"] = $tabLine["colorName"];
            self::$productMap[$tabLine["prodID"]]["colorRGB"] = $tabLine["colorRGB"];
            self::$productMap[$tabLine["prodID"]]["weight"] = empty($tabLine["weight"]) ? null : (float) $tabLine["weight"];
            self::$productMap[$tabLine["prodID"]]["price"] = empty($tabLine["price"]) ? null : (float) $tabLine["price"];
        }
    }
    /*———————————————————————————— PRODUCT ACCESS UP ————————————————————————*/
    /*———————————————————————————— CHECK DATAS DOWN —————————————————————————*/

    /**
     * Check the input value passed in param and push error accured in Response
     * @param string $key the name input to check (in $_POST, $_GET or $_SESSION)
     * @param string[] $dataTypes the types of the filter to check input.
     * + NOTE: combinaison available => 
     *      [TYPE], 
     *      [CHECKBOX, TYPE]
     * @param boolean $required set true if value can be empty alse false
     * @param Response $response to push in error accured
     * @return boolean true if is success else false
     */
    public function checkData($key, $dataTypes, $response, $length = null, $required = true)
    {
        $keyExist = Query::existParam($key);
        if (($required) && (!$keyExist)) {
            $errorStation = ($dataTypes[0] == self::CHECKBOX) ? "ER5"
                : "ER2";
            $response->addErrorStation($errorStation, $key);
            return $response->isSuccess();
        }
        if (!$keyExist) {
            return false;
        }

        $value = Query::getParam($key);
        if (!empty($length) && (strlen($value) > $length)) {
            $errorStationTxt = "ER6";
            $errorStationTxt .= " " . $length; // translateError will split errorStation from the lenght
            $response->addErrorStation($errorStationTxt, $key);
            return $response->isSuccess();
        }

        switch ($dataTypes[0]) {
            case self::NUMBER_FLOAT:
                if (preg_match(self::FLOAT_REGEX, $value) != 1) {
                    $errorMsg = "ER3";
                    $response->addErrorStation($errorMsg, $key);
                } else {
                    Query::convertParam(self::NUMBER_FLOAT, $key);
                }
                break;

            case self::PSEUDO:
                if (preg_match(self::PSEUDO_REGEX, $value) != 1) {
                    $errorMsg = "ER4";
                    $response->addErrorStation($errorMsg, $key);
                } else {
                    Query::convertParam(self::PSEUDO, $key);
                }
                break;

            case self::ALPHA_NUMERIC:
                if (preg_match(self::PALPHA_NUMERIC_REGEX, $value) != 1) {
                    $errorMsg = "ER1";
                    $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                } else {
                    Query::convertParam(self::ALPHA_NUMERIC, $key);
                }
                break;

            case self::CHECKBOX:
                $cbxType = $dataTypes[1];

                switch ($cbxType) {
                    case self::STRING_TYPE:
                        if (preg_match(self::STRING_REGEX, $value) != 1) {
                            $errorMsg = "ER1";
                            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                        } else {
                            Query::convertParam(self::STRING_TYPE, $key);
                        }
                        break;
                }

                break;
        }
        return $response->isSuccess();
    }

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
    protected function getDateTime()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Generate a alpha numerique sequence in specified length
     * @param int $length
     * @return string alpha numerique sequence in specified length
     */
    protected function generateCode($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
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
    protected function generateDateCode($length)
    {
        $sequence = date("YmdHis");
        $nbChar = strlen($sequence);
        if ($length <= $nbChar) {
            throw new Exception('$length must be strictly over 14');
        }
        $nbCharToAdd = $length - $nbChar;
        switch ($nbCharToAdd % 2) {
            case 0:
                $nbCharLeft = $nbCharRight = ($nbCharToAdd / 2);
                break;
            case 1:
                $nbCharLeft = ($nbCharToAdd - 1) / 2;
                $nbCharRight = $nbCharLeft + 1;
                break;
        }
        $sequence = $this->generateCode($nbCharLeft) . $sequence . $this->generateCode($nbCharRight);
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
    /*———————————————————————————— SHORTCUT UP ——————————————————————————————*/
    /*———————————————————————————— COMMON DOWN ——————————————————————————————*/
    /**
     * To get Response's attributs
     * @return string[] Response's attributs in a map format
     */
    public function getAttributs()
    {
        return get_object_vars($this);
    }

    /**
     * To get a protected copy of a instance
     * @return object copy of the Country instance
     */
    protected function getCopy()
    {
        // $map = get_object_vars($this);
        $copy = clone $this;
        // foreach ($map as $attr => $value) {
        //     // var_dump(gettype($this->{$attr}));
        //     // echo "<br>";
        //     switch (gettype($this->{$attr})) {
        //         case "array":
        //             $copy->{$attr} = $this->cloneMap($this->{$attr});
        //             break;
        //         case "object":
        //             $copy->{$attr} = $value->getCopy();
        //             break;
        //         default:
        //             $copy->{$attr} = $value;
        //             break;
        //     }
        // }
        // $this->copyDebug($this, $copy);
        return $copy;
    }

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

    // function __toString()
    // {
    //     $map = get_object_vars($this);
    //     foreach($map as $attr => $value){

    //     }
    // }
    /*———————————————————————————— COMMON UP ————————————————————————————————*/
}
