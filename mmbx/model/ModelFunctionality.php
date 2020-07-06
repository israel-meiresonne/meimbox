<?php

require_once 'framework/Model.php';

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
    private static $colors;
    private static $productIDList;

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
     * PDOStatement success code
     * @var string
     */
    private const PDO_SUCCEESS = "00000";

    const CRUD_STATUS = "insert_status";

    /*———————————————————————————— CRUD DOWN ————————————————————————————————*/

    /**
     * Execute a SQL INSERT of values passed in param with the query
     * @param string $sql the complete sql query ex: "INSERT INTO `Products`(`prodID`, `prodName`) VALUES (?,?), (?,?), etc..."
     * @param mixed[] $params list of values to insert
     * @return Response if its success Response.results[INSERT_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    protected function insert($sql, $params)
    {
        $response = new Response();
        $pdo = parent::executeRequest($sql, $params);
        $pdoStatus = $pdo->errorInfo()[0];

        ($pdoStatus == self::PDO_SUCCEESS) ? $response->addResult(self::CRUD_STATUS, $pdoStatus)
            : $response->addError($pdoStatus->errorInfo()[2], self::CRUD_STATUS);
        return $response;
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
    protected function update($sql, $params)
    {
        return $this->insert($sql, $params);
    }

    /**
     * Execute a SQL DELETE with the query given in param
     * @param string $sql the complete sql query ex: "DELETE FROM `UsersMeasures` WHERE ..."
     * @return Response if its success Response.results[DELETE_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    public function delete($sql)
    {
        return $this->insert($sql, null);
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
    public function getTable($query)
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
        return $sequence;
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
        $copyMap = [];
        $copyMap = $this->cloneMapRec($Map);
        return $copyMap;
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
        $map = get_object_vars($this);
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
