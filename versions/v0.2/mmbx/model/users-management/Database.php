<?php
class Database
{
    private static $db;

    const INSERT_STATUS_KEY = "insert_status";
    const DELETE_STATUS_KEY = "delete_status";
    const UPDATE_STATUS_KEY = "update_status";

    function __construct()
    {
        self::$db = Database_Connection::connect();
    }

    private function getDb()
    {
        return self::$db;
    }

    function disconnect()
    {
        self::$db = null;
    }

    /**
     * Execute a SQL query on the  db and return the résulte in a array
     * @param string the query like "SELECT * FROM ... WHERE ... etc..."
     * @return array the résulte of the query
     */
    public function select($query)
    {
        $select = self::$db->query($query);

        if ($select->rowCount() > 0) {
            return $select->fetchAll();
        } else {
            return [];
        }
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
        $response = new Response();
        $prepare = self::$db->prepare($query);
        $isSuccess = $prepare->execute($values);

        ($isSuccess) ? $response->addResult(self::INSERT_STATUS_KEY, $prepare->errorInfo()[0])
            : $response->addError($prepare->errorInfo()[2], self::INSERT_STATUS_KEY);
        return $response;
    }
    
    /**
     * Execute a SQL DELETE with the query given in param
     * @param string $query the complete query ex: "DELETE FROM `UsersMeasures` WHERE ..."
     * @return Response if its success Response.results[DELETE_STATUS_KEY] contain the success code else it
     *  contain the error thrown
     */
    public function delete($query)
    {
        $response = new Response();
        $prepare = self::$db->prepare($query);
        $isSuccess = $prepare->execute();

        ($isSuccess) ? $response->addResult(self::DELETE_STATUS_KEY, $prepare->errorInfo()[0])
            : $response->addError($prepare->errorInfo()[2], self::DELETE_STATUS_KEY);
        return $response;
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
        $response = new Response();
        $prepare = self::$db->prepare($query);
        $isSuccess = $prepare->execute($values);
        
        ($isSuccess) ? $response->addResult(self::UPDATE_STATUS_KEY, $prepare->errorInfo()[0])
        : $response->addError($prepare->errorInfo()[2], self::UPDATE_STATUS_KEY);
        return $response;
        
    }

    /**
     * Build bracket for SQL INSERT
     * @param int $nb how musch $bracket is needed
     * @param string $bracket = "(?,?,?,?,...)";
     */
    public static function buildBracketInsert($nb, $bracket)
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

    /**
     * Extract from a database table all the value of all column and push them in one array
     * @param string $query a SQL query
     * @return string[] an array containing value of all column of a database table
     */
    public function getTable($query)
    {
        $table = [];
        $queryTable = $this->select($query);

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
     * Extract from a database table the enum values of a column
     * @param string database table's name where to extract the enum value
     * @param string name of the column of the table of the database where to 
     * extract the enum
     * @return string[] a list of enum values of a column of a database table
     */
    function getEnumValues($tableName, $columnName)
    {
        $query = "describe " . $tableName . " " . $columnName;
        $describeTable = self::select($query);
        $type = $describeTable[0]["Type"];
        $filtre = ["enum(", "'", ")"];
        $type = str_replace($filtre, "", $type);
        $enumValues = explode(",", $type);
        return $enumValues;
    }


    /**
     * Get description of tables from database
     * @return string[] table containing the max size of each column
     */
    public function getTablesDescriptions()
    {
        $tableNames = [
            "UsersMeasures"
        ];
        $tableDesc = [];
        foreach ($tableNames as $tabName) {
            $tableDesc[$tabName] = self::buildTableDescription($tabName);
        }
        return $tableDesc;
    }

    /**
     * Build a map that contain the description of the table given in param
     * @return string[] a map that contain the description of the table given in param
     */
    private function buildTableDescription($tabName)
    {
        $table = $this->select("DESCRIBE " . $tabName);
        $description = [];

        foreach ($table as $line) {
            $key = $line["Field"];
            $typeCol = $line["Type"];
            $description[$key] = self::getTypeToLength($typeCol);
        }
        return $description;
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
                $length = 11;
                break;

            case "datetime":
                $length = 25; // {2017-01-08 00:00:00} length = 19
                break;

            case "date":
                $length = 15; // {1993-02-27} length = 10
                break;

            case "tinyint": // boolean
                $length = 5;  // {0}, {1} length = 1
                break;

            case "json":
                $length = 16776192;
                break;

            case "enum":
                $length = -1;
                break;

            case "text":
                $length = 2147483647;
                break;
        }
        return (int) $length;
    }

    public function getUserMap($userID)
    {
        $usersMap = [];
        $query =
            'SELECT u.`userID`, `lang_`, `mail`, `password`, `firstname`, `lastname`, `birthday`, `newsletter`, `sexe_`, u.`setDate` as "userSetDate",
            `address`, `zipcode`, `country_`, `appartement`, `province`, `city`, `phoneNumber`, `isActive`, a.`setDate` as "addressSetDate"
            FROM `Users` u
            LEFT JOIN `Addresses` a ON u.userID = a.userId
            WHERE u.userID = "' . $userID . '"';
        $userAddressTable = $this->select($query);

        foreach ($userAddressTable as $line) {
            if (count($usersMap["userDatas"]) == 0) {
                $usersMap["userDatas"]["userID"] = (int) $line["userID"];
                $usersMap["userDatas"]["lang_"] = $line["lang_"];
                $usersMap["userDatas"]["mail"] = $line["mail"];
                $usersMap["userDatas"]["firstname"] = $line["firstname"];
                $usersMap["userDatas"]["lastname"] = $line["lastname"];
                $usersMap["userDatas"]["birthday"] = $line["birthday"];
                $usersMap["userDatas"]["newsletter"] = $line["newsletter"] == 1;
                $usersMap["userDatas"]["sexe_"] = $line["sexe_"];
                $usersMap["userDatas"]["userSetDate"] = $line["userSetDate"];
            }
            $key = strtotime($line["addressSetDate"]);
            $usersMap["addresses"][$key]["address"] = $line["address"];
            $usersMap["addresses"][$key]["appartement"] = $line["appartement"];
            $usersMap["addresses"][$key]["zipcode"] = $line["zipcode"];
            $usersMap["addresses"][$key]["country_"] = $line["country_"];
            $usersMap["addresses"][$key]["province"] = $line["province"];
            $usersMap["addresses"][$key]["city"] = $line["city"];
            $usersMap["addresses"][$key]["phoneNumber"] = $line["phoneNumber"];
            $usersMap["addresses"][$key]["isActive"] = $line["isActive"];
            $usersMap["addresses"][$key]["setDate"] = $line["addressSetDate"];
        }
        // ksort($usersMap["addresses"]);

        $usersMap = self::getUserMeasures($userID, $usersMap);

        return $usersMap;
    }

    public function getLanguageMap()
    {
        $languageMap = [];
        $langTable = $this->select("SELECT * FROM `Languages`");
        foreach ($langTable as $line) {
            $languageMap[$line["langIsoCode"]]["langName"] = $line["langName"];
            $languageMap[$line["langIsoCode"]]["langLocalName"] = $line["langLocalName"];
        }

        return $languageMap;
    }

    /**
     * @return array of the table TranslationStations of the database
     */
    public function getStationMap()
    {
        $stationMap = [];
        $stationTable = $this->select("SELECT * FROM `TranslationStations`");
        foreach ($stationTable as $line) {
            $fileName = $line["usedInside"];
            $station = $line["station"];
            $iso_lang = $line["iso_lang"];
            $translation = $line["translation"];
            $stationMap[$fileName][$station][$iso_lang] = $translation;
        }

        return $stationMap;
    }

    /**
     * @return array of the table Translation of the database
     */
    public function getTranslationMap()
    {
        $translationMap = [];
        $translationTable = $this->select("SELECT * FROM `Translations`");
        $defaultLang = $this->select('SELECT * FROM `Constants` WHERE constName = "DEFAULT_LANGUAGE"')[0]["stringValue"]; // "en" (english)

        $stringKey = self::getStringKey($translationTable);

        $nbKey = count($stringKey);
        foreach ($translationTable as $line) {
            $translation = $line[$defaultLang];
            $translationMap[$translation] = [];
            for ($i = 1; $i < $nbKey; $i++) {
                $iso_lang = $stringKey[$i];
                $translationMap[$translation][$iso_lang] = $line[$iso_lang];
            }
        }
        return $translationMap;
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
     * $countryMap = [
     *     country_ => [
     *         "isoCountry" => string,
     *         "isoCurrency" => string,
     *         "isUE" => boolean,
     *         "vat" => double,
     *     ]
     * ]
     * @return array of country and their datas
     */
    public function getCountryMap()
    {
        $query = 'SELECT * FROM `Countries`';
        $countryTable = $this->select($query);
        $countryMap = [];

        foreach ($countryTable as $line) {
            $countryMap[$line["country"]]["isoCountry"] = $line["isoCountry"];
            $countryMap[$line["country"]]["iso_currency"] = $line["iso_currency"];
            $countryMap[$line["country"]]["isUE"] = $line["isUE"] == 1;
            $countryMap[$line["country"]]["vat"] = (float) $line["vat"];
        }

        return $countryMap;
    }

    /**
     * To get table of countries where we buy stock
     * $countryMap = [
     *     country_ => [
     *         "isoCountry" => string,
     *         "isoCurrency" => string,
     *         "isUE" => boolean,
     *         "vat" => double,
     *     ]
     * ]
     * @return array of country and their datas
     */
    public function getBuyCountryMap()
    {
        $query = 'SELECT * FROM `BuyCountries`';
        $countryTable = $this->select($query);
        $buyCountryMap = [];

        foreach ($countryTable as $line) {
            $buyCountryMap[$line["buyCountry"]]["isoCountry"] = $line["isoCountry"];
            $buyCountryMap[$line["buyCountry"]]["iso_currency"] = $line["iso_currency"];
            $buyCountryMap[$line["buyCountry"]]["isUE"] = $line["isUE"] == 1;
            $buyCountryMap[$line["buyCountry"]]["vat"] = (float) $line["vat"];
        }

        return $buyCountryMap;
    }

    /**
     * $countryMap = [
     *     country_ => [
     *         "isoCountry" => string,
     *         "isoCurrency" => string,
     *         "isUE" => boolean,
     *         "vat" => double,
     *     ]
     * ]
     * @return array of country and their datas
     */
    public function getCurrencyMap()
    {
        $query = 'SELECT * FROM `Currencies`';
        $currencyTable = $this->select($query);
        $currencyMap = [];

        foreach ($currencyTable as $line) {
            $currencyMap[$line["isoCurrency"]]["currencyName"] = $line["currencyName"];
            $currencyMap[$line["isoCurrency"]]["symbol"] = $line["symbol"];
            $currencyMap[$line["isoCurrency"]]["euroToCurrency"] = (float) $line["EURtoCurrency"];
            $currencyMap[$line["isoCurrency"]]["isDefault"] = $line["isDefault"]  == 1;

            if ($currencyMap[$line["isoCurrency"]]["isDefault"]) {
                $currencyMap["default"]["isoCurrency"] = $line["isoCurrency"];
                $currencyMap["default"]["currencyName"] = $line["currencyName"];
                $currencyMap["default"]["symbol"] = $line["symbol"];
                $currencyMap["default"]["euroToCurrency"] = (float) $line["EURtoCurrency"];
                $currencyMap["default"]["isDefault"] = $line["isDefault"]  == 1;
            }
        }

        return $currencyMap;
    }

    public function getConstantMap()
    {
        $query = "SELECT * FROM `Constants`";
        $constanteTable = $this->select($query);
        $constantMap = [];
        foreach ($constanteTable as $line) {
            $constantMap[$line["constName"]]["stringValue"] = $line["stringValue"];
            $constantMap[$line["constName"]]["jsonValue"] = $line["jsonValue"];
            $constantMap[$line["constName"]]["setDate"] = $line["setDate"];
            $constantMap[$line["constName"]]["description"] = $line["description"];
        }
        return $constantMap;
    }

    public function getBoxMap($userID)
    {
        $boxMap = [];
        $query =
            'SELECT bb.userId, bb.boxId, b.boxID, b.box_color, b.setDate, bp.boxId, bp.prodId, bp.size_name, bp.quantity
            FROM `Baskets-Box` bb
            JOIN `Boxes` b ON bb.boxId = b.boxID
            LEFT JOIN `Box-Products` bp ON bb.boxId = bp.boxId
            WHERE bb.userId = "' . $userID . '"
            ORDER BY b.boxID';
        $boxTable = $this->select($query);

        $boxMap = Database::getBoxes($boxTable, $boxMap);

        $boxMap = Database::getBoxesdatas($boxMap);
        $boxMap = Database::getBoxesShippings($boxMap);
        $boxMap = Database::getBoxesPrices($boxMap);
        $boxMap = Database::getBoxesDiscounts($boxMap);

        return $boxMap;
    }

    public function getDiscountCodeMap($userID)
    {
        $discountCodeMap = [];
        $query =
            'SELECT *
            FROM `Basket-DiscountCodes` bd
            JOIN `DiscountCodes` d ON bd.discount_code = d.discountCode
            JOIN `DiscountCodes-Countries` dc ON  d.discountCode = dc.discount_code
            WHERE bd.userId = "' . $userID . '"';
        $discountTable = $this->select($query);

        foreach ($discountTable as $line) {
            if (!array_key_exists($line["discountCode"], $discountCodeMap)) {
                $discountCodeMap[$line["discountCode"]]["setDate"] = $line["setDate"];
                $discountCodeMap[$line["discountCode"]]["discount_type"] = $line["discount_type"];
                $discountCodeMap[$line["discountCode"]]["value"] = (float) $line["value"];
                $discountCodeMap[$line["discountCode"]]["minAmount"] = (float) $line["minAmount"];
                $discountCodeMap[$line["discountCode"]]["nbUse"] = (int) $line["nbUse"];
                $discountCodeMap[$line["discountCode"]]["isCombinable"] = ($line["isCombinable"] == 1);
            }
            if (!array_key_exists($line["country_"], $discountCodeMap[$line["discountCode"]]["availableCountries"])) {
                $dates = [
                    "beginDate" => $line["beginDate"],
                    "endDate" => $line["endDate"]
                ];
                $discountCodeMap[$line["discountCode"]]["availableCountries"][$line["country_"]] = $dates;
            }
        }

        return $discountCodeMap;
    }

    /**
     * Get from database all data about each product owned by the user
     * @param int
     */
    public function getProductMap($userID)
    {
        $productMap = [];
        $prodIdList = [];

        $basketBoxQuery =
            'SELECT bp.boxId, bp.prodId, bp.sequenceID, bp.size_name, bp.brand_name, bp.measureId, bp.cut_name, bp.quantity, bp.setDate, bb.userId, bb.boxId, p.prodID, p.prodName, p.isAvailable, p.product_type, p.addedDate, p.colorName, p.colorRGB, p.weight, b.boxID, b.box_color as "current_box_color", b.setDate as "box_setDate", pbp.prodId, pbp.buyDate, pbp.buy_country, pbp.iso_currency, pbp.buyPrice, bcp.prodId, bcp.box_color 
            FROM `Box-Products` bp 
            LEFT JOIN `Baskets-Box`bb ON bp.boxId = bb.boxId 
            LEFT JOIN `Products`p ON bp.prodId = p.prodID 
            LEFT JOIN `Boxes` b ON bp.boxId = b.boxID 
            LEFT JOIN `ProductBuyPrice` pbp ON p.prodID = pbp.prodId 
            LEFT JOIN `BoxColors-Products` bcp ON p.prodID = bcp.prodId 
            WHERE bb.userId = "' . $userID . '" 
            ORDER BY pbp.buyDate DESC';
        $basketBoxTable = $this->select($basketBoxQuery);

        $array = Database::getProdDatas($basketBoxTable, $productMap, $prodIdList);
        $productMap = $array[0];
        $prodIdList = $array[1];

        $basketProdQuery =
            'SELECT * 
            FROM `Baskets-Products` bp 
            LEFT JOIN `Products`p ON bp.prodId = p.prodID 
            LEFT JOIN `ProductBuyPrice` pbp ON bp.prodID = pbp.prodId 
            WHERE bp.userId = "' . $userID . '"';
        $basketProdTable = $this->select($basketProdQuery);

        $array = Database::getProdDatas($basketProdTable, $productMap, $prodIdList);
        $productMap = $array[0];
        $prodIdList = $array[1];

        $queryWHERE_prodId = "";
        $i = 0;
        foreach ($prodIdList as $prodId => $true) {
            if ($i == 0) {
                $queryWHERE_prodId .= " WHERE prodId = " . $prodId;
                $i++;
            } else {
                $queryWHERE_prodId .= " OR prodId = " . $prodId;
            }
        }

        $productMap = Database::getProdDescription($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdPrices($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdShippings($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdDiscounts($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdPictures($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdSizes($productMap, $queryWHERE_prodId);
        $productMap = Database::getBoxProdSizes($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdCollections($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdFunctions($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdCategories($productMap, $queryWHERE_prodId);
        $productMap = Database::getProdMeasures($productMap, $queryWHERE_prodId);

        return $productMap;
    }

    /**
     * Get from database all data about each product matching the criterion
     * @param Search the search that content all the criterion to look for
     * @return string[string[...]] a productMap with product witch match all the criterion 
     */
    public function getProductMapSearch($queryWhereOrderBy)
    {
        $productMap_search = [];
        $prodIdList = [];
        $productQuery =
            'SELECT *
            FROM `Products` p
            LEFT JOIN `ProductBuyPrice` pbp ON p.prodID = pbp.prodId 
            LEFT JOIN `BoxColors-Products` bcp ON p.prodID = bcp.prodId
            LEFT JOIN `Products-Collections` pco ON p.prodID = pco.prodId
            LEFT JOIN `Products-ProductFunctions` pf ON p.prodID = pf.prodId
            LEFT JOIN `Products-Categories` pca ON p.prodID = pca.prodId
            LEFT JOIN `Products-Sizes` ps ON p.prodID = ps.prodId
            LEFT JOIN `ProductsPrices` pp ON p.prodID = pp.prodId
            ' . $queryWhereOrderBy;
        // Helper::printLabelValue("productQuery", $productQuery);
        $productTable = $this->select($productQuery);
        $array = Database::getProdDatas($productTable, $productMap_search, $prodIdList);
        $productMap_search = $array[0];
        $prodIdList = $array[1];

        $queryWHERE_prodId = "";
        $i = 0;
        foreach ($prodIdList as $prodId => $true) {
            if ($i == 0) {
                $queryWHERE_prodId .= " WHERE prodId = " . $prodId;
                $i++;
            } else {
                $queryWHERE_prodId .= " OR prodId = " . $prodId;
            }
        }

        $productMap_search = Database::getProdDescription($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdPrices($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdShippings($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdDiscounts($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdPictures($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdSizes($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getBoxProdSizes($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdCollections($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdFunctions($productMap_search, $queryWHERE_prodId);
        $productMap_search = Database::getProdCategories($productMap_search, $queryWHERE_prodId);

        return $productMap_search;
    }

    /**
     * Get from database measures of all the brand
     * @return string[...] measures of all the brand
     */
    public function getBrandsMeasures()
    {
        $query =
            'SELECT * 
            FROM `BrandsMeasures` bm
            JOIN `BrandsPictures` bp ON bm.brandName = bp.brand_name';

        $brandTable = self::select($query);
        $brandsMeasures = [];
        foreach ($brandTable as $line) {
            $brandName = $line["brandName"];
            $size_name = $line["size_name"];
            $body_part = $line["body_part"];
            $unit_name = $line["unit_name"];
            $minMax = $line["minMax"];
            $value = !empty($line["value"]) ? (float) $line["value"] : null;
            $pictureID = $line["pictureID"];
            $picture = $line["picture"];
            $brandsMeasures[$brandName][$size_name][$body_part][$unit_name][$minMax] = $value;
            $brandsMeasures[$brandName]["brandsPictures"][$pictureID] = $picture;
        }
        return $brandsMeasures;
    }

    /**
     * Get from database measures unit
     * @return string[...] measures unit
     */
    public function getMeasureUnits()
    {
        $unitTable = self::select("SELECT * FROM `MeasureUnits`");
        $measureUnits = [];
        foreach ($unitTable as $line) {
            $measureUnits[$line["unitName"]]["measureUnit"] = $line["measureUnit"];
            $measureUnits[$line["unitName"]]["toSystUnit"] = !empty($line["toSystUnit"]) ? (float) $line["toSystUnit"] : null;
        }
        return $measureUnits;
    }

    /**
     * Get Cuts table from database
     * @return string[...] Cuts map
     */
    public function getCutsMap()
    {
        $cutTable = self::select("SELECT * FROM `Cuts`");
        $cuts = [];
        foreach ($cutTable as $line) {
            $cutName = $line["cutName"];
            $cutMeasure = $line["cutMeasure"];
            $unit_name = $line["unit_name"];
            $cuts[$cutName]["cutMeasure"] = $cutMeasure;
            $cuts[$cutName]["unit_name"] = $unit_name;
        }
        return $cuts;
    }

    /**
     * @param array of prroduct from database
     */
    private static function getProdDatas($prodTable, $productMap, $prodIdList)
    {
        $queryPosition = 0;

        /**
         * $prodNames = [
         *      prodName => [
         *          index => prodID
         *      ]
         * ]
         */
        $prodNames = [];
        foreach ($prodTable as $line) {
            $prodIdList[$line["prodID"]] = true;

            if (
                !array_key_exists($productMap[$line["product_type"]], $line["prodID"])
                && !isset($productMap[$line["product_type"]][$line["prodID"]]["datas"]["queryPosition"])
            ) {
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["queryPosition"] = $queryPosition;
                $queryPosition++;
                if (!isset($prodNames[$line["prodName"]])) {
                    $prodNames[$line["prodName"]] = [];
                }
                array_push($prodNames[$line["prodName"]], $line["prodID"]);
            }

            if (strtotime($productMap[$line["product_type"]][$line["prodID"]]["datas"]["buyPriceDatas"]["setdate"]) < strtotime($line["buyDate"])) {
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["buyPriceDatas"]["setdate"] = $line["buyDate"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["buyPriceDatas"]["buy_country"] = $line["buy_country"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["buyPriceDatas"]["iso_currency"] = $line["iso_currency"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["buyPriceDatas"]["buyPrice"] = (float) $line["buyPrice"];
            }
            if (array_key_exists("box_color", $line)) {
                $productColors = Database::getProductColors($line["prodID"], $prodTable);
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["box_color"] = $productColors;

                // if (!array_key_exists($line["size_name"], $productMap[$line["product_type"]][$line["prodID"]]["datas"]["size_name"])) {
                //     $productMap[$line["product_type"]][$line["prodID"]]["datas"]["size_name"][$line["size_name"]] = $line["setDate"];
                // }

                // basket size
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["boxId"]][$line["sequenceID"]]["size_name"] = $line["size_name"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["boxId"]][$line["sequenceID"]]["brand_name"] = $line["brand_name"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["boxId"]][$line["sequenceID"]]["measureId"] = $line["measureId"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["boxId"]][$line["sequenceID"]]["cut_name"] = $line["cut_name"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["boxId"]][$line["sequenceID"]]["quantity"] = (int) $line["quantity"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["boxId"]][$line["sequenceID"]]["setDate"] = $line["setDate"];

                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["quantity"] = (int) $line["quantity"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["setDate"] = $line["setDate"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["prodName"] = $line["prodName"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["isAvailable"] = $line["isAvailable"] == 1;
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["addedDate"] = $line["addedDate"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["colorName"] = $line["colorName"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["colorRGB"] = $line["colorRGB"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["weight"] = (float) $line["weight"];
            } else {
                // basket 
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["userId"]][$line["sequenceID"]]["size_name"] = $line["size_name"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["userId"]][$line["sequenceID"]]["brand_name"] = $line["brand_name"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["userId"]][$line["sequenceID"]]["measureId"] = $line["measureId"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["userId"]][$line["sequenceID"]]["cut_name"] = $line["cut_name"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["userId"]][$line["sequenceID"]]["quantity"] = (int) $line["quantity"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["basket"][$line["userId"]][$line["sequenceID"]]["setDate"] = $line["setDate"];

                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["quantity"] = (int) $line["quantity"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["setDate"] = $line["setDate"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["prodName"] = $line["prodName"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["isAvailable"] = $line["isAvailable"] == 1;
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["addedDate"] = $line["addedDate"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["colorName"] = $line["colorName"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["colorRGB"] = $line["colorRGB"];
                $productMap[$line["product_type"]][$line["prodID"]]["datas"]["weight"] = (float) $line["weight"];
            }
        }

        $productMap = self::addSameNameProduct($prodNames, $productMap);

        return [0 => $productMap, 1 => $prodIdList];
    }

    /**
     * Search in database the product with the same name that the one inside 
     * $productMap and add the same product in $productMap.
     * @param string[string[int[]]] $prodNames containt productName of product 
     * inside productMap and the product id that share the same name
     * @param string[string[...]] $productMap map of product's datas
     * @return string[string[...]] $productMap map of product's datas where 
     * each product include a list of its similar product
     */
    private function addSameNameProduct($prodNames, $productMap)
    {
        $queryWHERE = "";
        $nbName = count($prodNames);
        $i = 0;
        foreach ($prodNames as $prodName => $prodIDList) {
            if ($i == 0) {
                $queryWHERE .= "WHERE (prodName = '$prodName'";
            } else {
                $queryWHERE .= " OR prodName = '$prodName'";
            }
            $i++;
            $queryWHERE .= $i == $nbName ? ")" : "";
        }

        $queryName = "SELECT prodID, prodName, colorName, colorRGB FROM `Products` " . $queryWHERE;
        $productNameTable = self::select($queryName);
        /**
         * $productNameMap = [
         *      prodName => [
         *          prodID => [
         *              "prodName" => string,
         *              "colorName" => string,
         *              "colorRGB" => string
         *          ]
         *      ]
         * ]
         */
        $productNameMap = [];
        foreach ($productNameTable as $line) {
            $prodID = $line["prodID"];
            $prodName = $line["prodName"];
            $colorName = $line["colorName"];
            $colorRGB = $line["colorRGB"];
            if (!isset($productNameMap[$prodName])) {
                $productNameMap[$prodName] = [];
                $productNameMap[$prodName][$prodID] = [];
            }
            $productNameMap[$prodName][$prodID]["prodName"] = $prodName;
            $productNameMap[$prodName][$prodID]["colorName"] = $colorName;
            $productNameMap[$prodName][$prodID]["colorRGB"] = $colorRGB;
        }

        foreach ($productNameMap as $prodName => $prodIDList) {
            foreach ($prodIDList as $prodID => $datas) {
                foreach ($productMap as $product_type => $products) {
                    if (array_key_exists($prodID, $productMap[$product_type])) {
                        foreach ($prodIDList as $id => $idDatas) {
                            if ($prodID != $id) {
                                $productMap[$product_type][$prodID]["datas"]["sameNameProd"][$id] = $idDatas;
                            }
                        }
                    }
                }
            }
        }
        return $productMap;
    }

    /**
     * @param string id of the product
     * @param array of prroduct from database
     * @return string[] of colors
     */
    private static function getProductColors($prodID, $prodTable)
    {
        $productColors = [];

        foreach ($prodTable as $line) {
            if ($line["prodID"] == $prodID && !array_key_exists($line["box_color"], $productColors)) {
                $productColors[$line["box_color"]] = $line["current_box_color"] == $line["box_color"];
            }
        }

        return $productColors;
    }

    private static function getProdDescription($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `ProductsDescriptions` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $descTable = self::select($query);

        foreach ($descTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    $productMap[$product_type][$line["prodId"]]["descriptions"][$line["lang_"]] = $line["description"];
                }
            }
        }

        return $productMap;
    }

    private static function getProdPrices($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `ProductsPrices` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $pricesTable = self::select($query);

        foreach ($pricesTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    $productMap[$product_type][$line["prodId"]]["prices"][$line["country_"]][$line["iso_currency"]] = (float) $line["price"];
                }
            }
        }

        return $productMap;
    }

    private static function getProdShippings($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `ProductsShippings` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $shipTable = self::select($query);

        foreach ($shipTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    $productMap[$product_type][$line["prodId"]]["shippings"][$line["country_"]][$line["iso_currency"]]["price"] = (float) $line["price"];
                    $productMap[$product_type][$line["prodId"]]["shippings"][$line["country_"]][$line["iso_currency"]]["time"] = (int) $line["time"];
                }
            }
        }

        return $productMap;
    }

    private static function getProdDiscounts($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `ProductsDiscounts` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $discountTable = self::select($query);

        foreach ($discountTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    $productMap[$product_type][$line["prodId"]]["discounts"][$line["country_"]]["discount_value"] = (float) $line["discount_value"];
                    $productMap[$product_type][$line["prodId"]]["discounts"][$line["country_"]]["beginDate"] = $line["beginDate"];
                    $productMap[$product_type][$line["prodId"]]["discounts"][$line["country_"]]["endDate"] = $line["endDate"];
                }
            }
        }

        return $productMap;
    }

    private static function getProdPictures($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `ProductsPictures` ' . $queryWHERE_prodId . ' ORDER BY prodId, pictureID';
        $picturetTable = self::select($query);

        foreach ($picturetTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $productMap[$product_type])) {
                    if ($productMap[$product_type][$line["prodId"]]["pictures"][$line["pictureID"]] != $line["picture"]) {
                        $productMap[$product_type][$line["prodId"]]["pictures"][$line["pictureID"]] = $line["picture"];
                    }
                }
            }
        }



        return $productMap;
    }

    private static function getProdSizes($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `Products-Sizes` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $sizeTable = self::select($query);
        foreach ($sizeTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                // foreach($prodList as $prodID => $product){

                if (array_key_exists($line["prodId"], $prodList)) {
                    $productMap[$product_type][$line["prodId"]]["sizes"][$line["size_name"]]["selected"] = false;
                    $productMap[$product_type][$line["prodId"]]["sizes"][$line["size_name"]]["stock"] = (int) $line["stock"];
                }
                // }
            }
        }

        return $productMap;
    }

    private static function getBoxProdSizes($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `BoxProducts-Sizes` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $boxProdSizeTable = self::select($query);

        foreach ($boxProdSizeTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    $productMap[$product_type][$line["prodId"]]["boxProdSizes"][$line["size_name"]] = (int) $line["stock"];
                }
            }
        }
        return $productMap;
    }

    private static function getProdCollections($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `Products-Collections` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $collectionsTable = self::select($query);

        foreach ($collectionsTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    if (gettype($productMap[$product_type][$line["prodId"]]["collections"]) != "array") {
                        $productMap[$product_type][$line["prodId"]]["collections"] = [];
                    }
                    $dates = [
                        "beginDate" => $line["beginDate"],
                        "endDate" => $line["endDate"]
                    ];
                    $productMap[$product_type][$line["prodId"]]["collections"][$line["collection_name"]] =  $dates;
                }
            }
        }

        return $productMap;
    }

    private function getProdFunctions($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `Products-ProductFunctions` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $fonctionsTable = self::select($query);

        foreach ($fonctionsTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    if (gettype($productMap[$product_type][$line["prodId"]]["functions"]) != "array") {
                        $productMap[$product_type][$line["prodId"]]["functions"] = [];
                    }
                    array_push($productMap[$product_type][$line["prodId"]]["functions"], $line["function_name"]);
                }
            }
        }

        return $productMap;
    }

    private function getProdCategories($productMap, $queryWHERE_prodId)
    {
        $query = 'SELECT * FROM `Products-Categories` ' . $queryWHERE_prodId . ' ORDER BY prodId';
        $categoriesTable = self::select($query);



        foreach ($categoriesTable as $line) {
            foreach ($productMap as $product_type => $prodList) {
                if (array_key_exists($line["prodId"], $prodList)) {
                    if (gettype($productMap[$product_type][$line["prodId"]]["categories"]) != "array") {
                        $productMap[$product_type][$line["prodId"]]["categories"] = [];
                    }
                    array_push($productMap[$product_type][$line["prodId"]]["categories"], $line["category_name"]);
                }
            }
        }

        return $productMap;
    }

    private function getBoxes($boxTable, $boxMap)
    {
        foreach ($boxTable as $line) {
            if (gettype($boxMap["boxes"][$line["boxID"]]["box_color"]) == "NULL") {
                $boxMap["boxes"][$line["boxID"]]["box_color"] = $line["box_color"];
            }
            if (gettype($boxMap["boxes"][$line["boxID"]]["setDate"]) == "NULL") {
                $boxMap["boxes"][$line["boxID"]]["setDate"] = $line["setDate"];
            }
            if (gettype($boxMap["boxes"][$line["boxID"]]["boxProducts"]) != "array") {
                $boxMap["boxes"][$line["boxID"]]["boxProducts"] = [];
            }
            if (!array_key_exists($line["prodId"], $boxMap["boxes"][$line["boxID"]]["boxProducts"])) {
                $boxMap["boxes"][$line["boxID"]]["boxProducts"][$line["prodId"]] = $line["prodId"];
            }
        }
        return $boxMap;
    }

    private static function getBoxesdatas($boxMap)
    {
        $query =
            'SELECT * 
            FROM `BoxColors` bc
            JOIN `BoxBuyPrice` bbp ON bc.boxColor = bbp.box_color
            ORDER BY bbp.setDate DESC';
        $boxColorsTable = self::select($query);

        foreach ($boxColorsTable as $line) {
            if (gettype($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["sizeMax"]) == "NULL") {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["sizeMax"] = (int) $line["sizeMax"];
            }
            if (gettype($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["weight"]) == "NULL") {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["weight"] = (float) $line["weight"];
            }
            if (gettype($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["boxColorRGB"]) == "NULL") {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["boxColorRGB"] = $line["boxColorRGB"];
            }
            if (gettype($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["priceRGB"]) == "NULL") {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["priceRGB"] = $line["priceRGB"];
            }
            if (gettype($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["textualRGB"]) == "NULL") {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["textualRGB"] =  $line["textualRGB"];
            }
            if (gettype($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["boxPicture"]) == "NULL") {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["boxPicture"] = $line["boxPicture"];
            }
            if (gettype($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["stock"]) == "NULL") {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["stock"] = (int) $line["stock"];
            }
            if (strtotime($boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["buyPriceDatas"]["setdate"]) < strtotime($line["setDate"])) {
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["buyPriceDatas"]["setdate"] = $line["setDate"];
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["buyPriceDatas"]["buy_country"] = $line["buy_country"];
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["buyPriceDatas"]["iso_currency"] = $line["iso_currency"];
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["buyPriceDatas"]["buyPrice"] = $line["buyPrice"];
                $boxMap["boxesProperties"][$line["boxColor"]]["boxDatas"]["buyPriceDatas"]["quantity"] = $line["quantity"];
            }
        }

        return $boxMap;
    }

    private static function getBoxesShippings($boxMap)
    {
        $query = 'SELECT * FROM `BoxShipping`';
        $Table = self::select($query);

        foreach ($Table as $line) {
            $boxMap["boxesProperties"][$line["box_color"]]["shippings"][$line["country_"]][$line["iso_currency"]]["price"] = (float) $line["price"];
            $boxMap["boxesProperties"][$line["box_color"]]["shippings"][$line["country_"]][$line["iso_currency"]]["time"] = (int) $line["time"];
        }
        return $boxMap;
    }

    private static function getBoxesPrices($boxMap)
    {
        $query = 'SELECT * FROM `BoxPrices`';
        $Table = self::select($query);

        foreach ($Table as $line) {
            $boxMap["boxesProperties"][$line["box_color"]]["prices"][$line["country_"]][$line["iso_currency"]] = (float) $line["price"];
        }
        return $boxMap;
    }

    private static function getBoxesDiscounts($boxMap)
    {
        $query = 'SELECT * FROM `BoxDiscounts`';
        $Table = self::select($query);

        foreach ($Table as $line) {
            $boxMap["boxesProperties"][$line["box_color"]]["discounts"][$line["country_"]]["discount_value"] = (float) $line["discount_value"];
            $boxMap["boxesProperties"][$line["box_color"]]["discounts"][$line["country_"]]["beginDate"] = $line["beginDate"];
            $boxMap["boxesProperties"][$line["box_color"]]["discounts"][$line["country_"]]["endDate"] = $line["endDate"];
        }
        return $boxMap;
    }

    /**
     * Fill the user's data map with his measures
     * @return string[string[string]]
     */
    private function getUserMeasures($userID, $usersMap)
    {
        $usersMeasuresTable = self::select("SELECT * FROM `UsersMeasures` WHERE `userId` = '$userID'  ");
        $usersMap["usersMeasures"] = [];
        foreach ($usersMeasuresTable as $line) {
            $measure = [];
            $measure["measureID"] = $line["measureID"];
            $measure["measure_name"] = $line["measureName"];
            $measure["userBust"] = !empty($line["userBust"]) ? (float) $line["userBust"] : null;
            $measure["userArm"] = !empty($line["userArm"]) ? (float) $line["userArm"] : null;
            $measure["userWaist"] = !empty($line["userWaist"]) ? (float) $line["userWaist"] : null;
            $measure["userHip"] = !empty($line["userHip"]) ? (float) $line["userHip"] : null;
            $measure["userInseam"] = !empty($line["userInseam"]) ? (float) $line["userInseam"] : null;
            $measure["unit_name"] = $line["unit_name"];
            $measure["size_name"] = $line["size_name"];
            $measure["brand_name"] = $line["brand_name"];
            $measure["setDate"] = $line["setDate"];
            // array_push($usersMap["usersMeasures"], $measure);
            $usersMap["usersMeasures"][$line["measureID"]] = $measure;
        }
        return $usersMap;
    }

    /**
     * Add to each product its measures
     * @return string[string[string...]]
     */
    private function getProdMeasures($productMap, $queryWHERE_prodId)
    {
        $productsMeasureTable = self::select("SELECT * FROM `ProductsMeasures` " . $queryWHERE_prodId);
        foreach ($productsMeasureTable as $line) {
            foreach ($productMap as $prodType => $products) {
                if (array_key_exists($line["prodId"], $products)) {
                    $prodId = $line["prodId"];
                    $size_name = $line["size_name"];
                    $body_part = $line["body_part"];
                    $value = !empty($line["value"]) ? (float) $line["value"] : null;
                    $productMap[$prodType][$prodId]["prodMeasures"][$size_name][$body_part]["value"] = $value;
                    $productMap[$prodType][$prodId]["prodMeasures"][$size_name][$body_part]["unit_name"] = $line["unit_name"];
                }
            }
        }

        return $productMap;
    }
}
