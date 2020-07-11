<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';

class Search extends ModelFunctionality
{
    /**
     * Holds a list product id
     * @var string[]
     */
    private $prodIdList;

    /**
     * Holds a list of collection witch match the search
     * @var string[]
     */
    private $collections;

    /**
     * Indicate the order to display the result of the search.
     * 
     * $order["value"] => ["newest" | "older" | "highttolow" | "lowtohight"];
     * $order["displayable"] => ["newest" | "older" | "hight to low" | "low to hight";
     * $order["orderSQL"] => "DESC" | "ASC";
     * 
     * • newest: => DESC
     * • older: => ASC
     * • highttolow: hight to low => DESC
     * • lowtohight: low to hight => ASC
     * @var string[string[]] $order available value: [newest | older | highttolow | lowtohight]
     */
    private $order;

    /**
     * Holds a list of product types witch match the search
     * @var string[]
     */
    private $product_types;

    /**
     * List of product's functions
     * @var string[]
     */
    protected $functions;

    /**
     * Holds a list of categories witch match the search
     * @var string[]
     */
    private $categories;

    /**
     * Holds a list of colors witch match the search
     * @var string[]
     */
    private $colors;

    /**
     * Holds a list of sizes witch match the search
     * @var string[]
     */
    private $sizes;

    /**
     * Holds the minimum and maximum price indicated in search
     * @var Price[] $prices $prices[minPrice] => Price, $prices["maxPrice"] => Price
     */
    private $prices;

    /**
     * Holds a list of products witch match the search
     * @var BoxProduct[]|BasketProduct[] $products
     */
    private $products;

    /**
     * Holds a list of Product ordered by criterion
     * @var string[string[Product]]
     */
    private $searchMap;

    public const NEWEST = "newest";
    public const OLDER = "older";
    public const HIGHT_TO_LOW = "highttolow";
    public const LOW_TO_HIGHT = "lowtohight";

    /**
     * Holds the search method for system's search
     * @var string
     */
    public const PROD_ID_GET_SEARCH = "prod_id_GET_search";
    /**
     * Holds the search method for system's search
     * @var string
     */
    public const SYSTEM_SEARCH = "SYSTEM_SEARCH";

    /**
     * Holds the search method for GET search
     * @var string
     */
    public const FILTER_GET_SEARCH = "filter_get_search";

    /**
     * Holds the search method for POST search
     * @var string
     */
    public const FILTER_POST_SEARCH = "filter_post_search";

    /**
     * Constuctor
     * @param  string $searchMode  PROD_ID_GET_SEARCH, SYSTEM_SEARCH, FILTER_GET_SEARCH, FILTER_POST_SEARCH...
     * @param Currency $currency the Visitor's current Currency
     * @param string[] $params search params like collections, product_types, functions, categories, order etc...
     */
    public function __construct($searchMode, Currency $currency = null, array $params = null)
    {
        $this->products = [];
        $this->searchMap = [];
        $this->prodIdList = [];
        $this->collections = [];
        $this->product_types = [];
        $this->functions = [];
        $this->categories = [];
        $this->colors = [];
        $this->sizes = [];
        $this->prices["minPrice"] = [];
        $this->prices["maxPrice"] = [];
        switch ($searchMode) {
            case self::FILTER_GET_SEARCH:
                $this->filterGETSearch($currency);
                break;
            case self::FILTER_POST_SEARCH:
                $this->filterPOSTSearch($currency);
                break;
            case self::PROD_ID_GET_SEARCH:
                $prodId = Query::existParam("prodid") ? [(int)Query::getParam("prodid")] : [];
                $this->prodIdSearch($prodId);
                break;
            case self::SYSTEM_SEARCH:
                $this->systemSearch($params);
                break;
        }
    }

    /**
     * Constuctor
     * @param $method the search method
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
     * @param Currency $currency the Visitor's current Currency
     */
    private function systemSearch($criterions, Currency $currency = null)
    {

        $prodIdList = isset($criterions["prodID"]) ? $criterions["prodID"] : null;
        $this->prodIdList = $this->filterValidValues("productIDList", $prodIdList);

        $collections = isset($criterions["collections"]) ? $criterions["collections"] : null;
        $product_types = isset($criterions["product_types"]) ? $criterions["product_types"] : null;
        $functions = isset($criterions["functions"]) ? $criterions["functions"] : null;
        $categories = isset($criterions["categories"]) ? $criterions["categories"] : null;
        $colors = isset($criterions["colors"]) ? $criterions["colors"] : null;
        $sizes = isset($criterions["sizes"]) ? $criterions["sizes"] : null;

        $this->collections = $this->filterValidValues("collections", $collections);
        $this->product_types = $this->filterValidValues("product_types", $product_types);
        $this->functions = $this->filterValidValues("functions", $functions);
        $this->categories = $this->filterValidValues("categories", $categories);
        $this->colors = $this->filterValidValues("colors", $colors);
        $this->sizes = $this->filterValidValues("sizes", $sizes);

        $order = isset($criterions["order"]) ? $criterions["order"] : null;
        $order = $this->filterOrders($order);
        $this->order =  $order;

        $prices["minprice"] = isset($criterions["minprice"]) ? $criterions["minprice"] : null;
        $prices["minprice"] = preg_match("#[.]{1}#", $prices["minprice"]) == 1
            ? $prices["minprice"]
            : $prices["minprice"] . "00";

        $prices["maxprice"] = isset($criterions["maxprice"]) ? $criterions["maxprice"] : null;
        $prices["maxprice"] = preg_match("#[.]{1}#", $prices["maxprice"]) == 1
            ? $prices["maxprice"]
            : $prices["maxprice"] . "00";
        $pricesObj = $this->filterPrices($prices, $currency);
        $this->prices["minPrice"] = key_exists("minprice", $pricesObj) ? $pricesObj["minprice"] : null;
        $this->prices["maxPrice"] = key_exists("maxprice", $pricesObj) ? $pricesObj["maxprice"] : null;
    }

    /**
     * This constructor set the attributs with the URL by using $_GET
     *  variable. NOTE: this method dont set products lsit and search map
     * @param Currency $currency the Visitor's current Currency
     */
    private function filterGETSearch(Currency $currency)
    {
        // if (Query::existParam("prodID")) {
        //     $prodIdList = explode(",", Query::getParam("prodID"));
        //     $this->prodIdList = $this->filterValidValues("productIDList", $prodIdList);
        // } else {
            $collections = Query::existParam("collections") ? explode(",", Query::getParam("collections")) : null;
            $product_types = Query::existParam("product_types") ? explode(",", Query::getParam("product_types")) : null;
            $functions = Query::existParam("functions") ? explode(",", Query::getParam("functions")) : null;
            $categories = Query::existParam("categories") ? explode(",", Query::getParam("categories")) : null;
            $colors = Query::existParam("colors") ? explode(",", Query::getParam("colors")) : null;
            $sizes = Query::existParam("sizes") ? explode(",", Query::getParam("sizes")) : null;

            $this->collections = $this->filterValidValues("collections", $collections);
            $this->product_types = $this->filterValidValues("product_types", $product_types);
            $this->functions = $this->filterValidValues("functions", $functions);
            $this->categories = $this->filterValidValues("categories", $categories);
            $this->colors = $this->filterValidValues("colors", $colors);
            $this->sizes = $this->filterValidValues("sizes", $sizes);

            $order = Query::existParam("order") ? Query::getParam("order") : null;
            $order = $this->filterOrders($order);
            $this->order =  $order;
            $prices = Query::existParam("prices") ? explode(",", Query::getParam("prices")) : null;
            $pricesObj = $this->filterPrices($prices, $currency);
            $this->prices["minPrice"] = key_exists(0, $pricesObj) ? $pricesObj[0] : null;
            $this->prices["maxPrice"] = key_exists(1, $pricesObj) ? $pricesObj[1] : null;
        // }
    }

    /**
     * This constructor set the attributs with the server request by using $_POST
     *  variable. 
     * + NOTE: this method dont set products list and search map
     * @param Currency $currency the Visitor's current Currency
     */
    private function filterPOSTSearch(Currency $currency)
    {
        $collections = [];
        $product_types = [];
        $functions = [];
        $categories = [];
        $colors = [];
        $sizes = [];
        $params = Query::getRegexParams("#_[0-9]+#");
        foreach ($params as $param => $value) {
            $shortParam = preg_replace("#_[0-9]+#", "", $param);
            switch ($shortParam) {
                case "collections":
                    array_push($collections, $value);
                    break;
                case "product_types":
                    array_push($product_types, $value);
                    break;
                case "functions":
                    array_push($functions, $value);
                    break;
                case "categories":
                    array_push($categories, $value);
                    break;
                case "colors":
                    array_push($colors, $value);
                    break;
                case "sizes":
                    array_push($sizes, $value);
                    break;
            }
        }

        $this->collections = $this->filterValidValues("collections", $collections);
        $this->product_types = $this->filterValidValues("product_types", $product_types);
        $this->functions = $this->filterValidValues("functions", $functions);
        $this->categories = $this->filterValidValues("categories", $categories);
        $this->colors = $this->filterValidValues("colors", $colors);
        $this->sizes = $this->filterValidValues("sizes", $sizes);

        $order = Query::existParam("order") ? Query::getParam("order") : null;
        $order = $this->filterOrders($order);
        $this->order =  $order;

        $prices["minprice"] = Query::existParam("minprice") ? Query::getParam("minprice") : null;
        $prices["minprice"] = (preg_match("#[.]{1}#", $prices["minprice"]) == 1)
            ? $prices["minprice"]
            : $prices["minprice"] . "00";

        $prices["maxprice"] = Query::existParam("maxprice") ? Query::getParam("maxprice") : null;
        $prices["maxprice"] = (preg_match("#[.]{1}#", $prices["maxprice"]) == 1)
            ? $prices["maxprice"]
            : $prices["maxprice"] . "00";

        $pricesObj = $this->filterPrices($prices, $currency);
        $this->prices["minPrice"] = key_exists("minprice", $pricesObj) ? $pricesObj["minprice"] : null;
        $this->prices["maxPrice"] = key_exists("maxprice", $pricesObj) ? $pricesObj["maxprice"] : null;
    }

    /**
     * This constructor set the attributs with the server request by using $_POST
     *  variable. 
     * + NOTE: this method dont set products list and search map
     * @param Currency $currency the Visitor's current Currency
     * @param int[]  $prodIdList list of product id
     */
    private function prodIdSearch($prodIdList){
        $this->prodIdList = $this->filterValidValues("productIDList", $prodIdList);
    }

    /**
     * Fill the Products attrribut with all product matching the search. 
     * Products are ordered following the order asked in the search else in a 
     * marketing order.
     * @param Language $lang Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currency
     */
    public function setProducts($lang, $country, $currency)
    {
        $sql = $this->getSql($country, $currency);
        $this->setProductMap($sql);
        $productMap = $this->getProductMap();
        foreach ($productMap as $prodID => $datas) {
            switch ($datas["product_type"]) {
                case BoxProduct::BOX_TYPE:
                    $boxProd = new BoxProduct($prodID);
                    $boxProd->CompleteProperties($lang);
                    array_push($this->products, $boxProd);
                    break;
                case BasketProduct::BASKET_TYPE:
                    $baskProd = new BasketProduct($prodID, $country, $currency);
                    $baskProd->CompleteProperties($lang, $country, $currency);
                    array_push($this->products, $baskProd);
                    break;
            }
        }
        $this->setSearchMap();
    }

    /**
     * Builds the searchMap using each criterion as key and filling them of all
     *  product witch match this criterion
     */
    private function setSearchMap()
    {
        foreach ($this->collections as $collection) {
            $this->searchMap["collections"][$collection] = [];
            $i = 0;
            foreach ($this->products as $product) {
                if ($product->collectionIsInside($collection)) {
                    array_push($this->searchMap["collections"][$collection], $this->products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->product_types as $product_type) {
            $this->searchMap["product_types"][$product_type] = [];
            $i = 0;
            foreach ($this->products as $product) {
                if ($product->getType() == $product_type) {
                    array_push($this->searchMap["product_types"][$product_type], $this->products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->functions as $function) {
            $this->searchMap["functions"][$function] = [];
            $i = 0;
            foreach ($this->products as $product) {
                if ($product->functionIsInside($function)) {
                    array_push($this->searchMap["functions"][$function], $this->products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->categories as $category) {
            $this->searchMap["categories"][$category] = [];
            $i = 0;
            foreach ($this->products as $product) {
                if ($product->categoryIsInside($category)) {
                    array_push($this->searchMap["categories"][$category], $this->products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->colors as $color) {
            $this->searchMap["colors"][$color] = [];
            $i = 0;
            foreach ($this->products as $product) {
                if ($product->getColorName() == $color) {
                    array_push($this->searchMap["colors"][$color], $this->products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->sizes as $size) {
            $this->searchMap["sizes"][$size] = [];
            $i = 0;
            foreach ($this->products as $product) {
                if ($product->sizeIsInside($size)) {
                    array_push($this->searchMap["sizes"][$size], $this->products[$i]);
                }
                $i++;
            }
        }
    }

    /**
     * Getter of the order
     * @return string the value of the order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Getter of the search's minPrice
     */
    public function getMinPrice()
    {
        return !empty($this->prices["minPrice"]) ? $this->prices["minPrice"]->getPrice() : null;
    }

    /**
     * Getter of the search's maxPrice
     */
    public function getMaxPrice()
    {
        return !empty($this->prices["maxPrice"]) ? $this->prices["maxPrice"]->getPrice() : null;
    }

    /**
     * Getter of the products
     * @return BoxProduct[]|BasketProduct[] a protected copy of products
     */
    public function getProducts()
    {
        return $this->cloneMap($this->products);
    }

    /**
     * Getter of the searchMap
     * @return string[string[BoxProduct|BasketProduct]] a protected copy of the searchMap
     */
    public function getSearchMap()
    {
        return $this->cloneMap($this->searchMap);
    }

    /**
     * Build a array with all criterion into string format.
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string[] list of criterion needed to build search stickers
     */
    public function getStickers($translator)
    {
        $stickers = [];
        if (
            !empty($this->order["value"])
            && !empty($this->order["displayable"])
            && !empty($this->order["orderSQL"])
        ) {
            $stickers[$this->order["displayable"]] = $this->order["value"];
        }

        if (count($this->prices) > 0) {
            if (!empty($this->prices["minPrice"])) {
                $minPrice = $this->prices["minPrice"]->getPrice();
                $minPriceDisplayable = $this->prices["minPrice"]->getMinPrice($translator);
                $stickers[$minPriceDisplayable] = $minPrice;
            }
            if (!empty($this->prices["maxPrice"])) {
                $maxPrice = $this->prices["maxPrice"]->getPrice();
                $maxPriceDisplayable = $this->prices["maxPrice"]->getMaxPrice($translator);
                $stickers[$maxPriceDisplayable] = $maxPrice;
            }
        }

        $product_types = $this->arrayToMap($this->product_types);
        $stickers = array_merge($stickers, $product_types);

        $functions = $this->arrayToMap($this->functions);
        $stickers = array_merge($stickers, $functions);

        $categories = $this->arrayToMap($this->categories);
        $stickers = array_merge($stickers, $categories);

        $colors = $this->arrayToMap($this->colors);
        $stickers = array_merge($stickers, $colors);

        $sizes = $this->arrayToMap($this->sizes);
        $stickers = array_merge($stickers, $sizes);

        return $stickers;
    }

    /**
     * To get list of available value form db
     * + NOTE: use available values as access key and table name as value
     * + [value => tableName]
     * @param string[] $tabNames list of criterion to get from serachMap
     * @return string[] map that use criterions values as key and criterion as value
     */
    public function getValToTableNameMap($tabNames)
    {
        $map = [];
        foreach ($tabNames as $tabName) {
            $values = $this->getTableValues($tabName);
            foreach ($values as $value) {
                $map[$value] = $tabName;
            }
        }
        return $map;
    }

    /**
     * To get list of criterions's search parameter
     * @param string[] $criterions liste of criterion name
     * @return string[] list of criterions's search parameter
     */
    public function geSearchParams($criterions)
    {
        $map = [];
        foreach ($criterions as $criterion) {
            if (key_exists($criterion, $this->searchMap)) {
                $params = array_keys($this->searchMap[$criterion]);
                $map = array_merge($map, $params);
            }
        }
        return $map;
    }

    /**
     * Check if all values exist in a database table
     * @param string $tableName a database table's name
     * @param string[] $values value to check if they exist in a database table
     * @return string[] all values existing in a database table
     */
    private function filterValidValues($tableName, $values)
    {
        $validValues = [];
        $tableVal = $this->getTableValues($tableName);
        if ((!empty($values)) && count($values) > 0)
            foreach ($values as $value) {
                in_array($value, $tableVal) ? array_push($validValues, $value)
                    : null;
            }
        return $validValues;
    }

    /**
     * Check if all max price and min price are float value and convert them to float
     * @param string[] list of price in string and int format (so there not decimal: 10.99 => 1099)
     * @param Currency the Visitor's current Currency
     * @return Price[] all valid price converted from string to float
     */
    private function filterPrices($prices, $currency)
    {
        $validPrices = [];
        if ((!empty($prices)) && count($prices) > 0) {
            $keys = array_keys($prices);
            foreach ($keys as $key) {
                if (preg_match("#^[1-9]+[0-9]*$#", $prices[$key]) == 1) {
                    $price = (float) $prices[$key] / 100;
                    // $price = (float) number_format($price, 2, ".", "");
                    $priceObj = new Price($price, $currency);
                    $validPrices[$key] = $priceObj;
                } else if (preg_match("#^[1-9]+[0-9]*[.]?[0-9]*$#", $prices[$key]) == 1) {
                    $price = (float) $prices[$key];
                    // $price = (float) number_format($price, 2, ".", "");
                    $priceObj = new Price($price, $currency);
                    $validPrices[$key] = $priceObj;
                }
            }
        }
        return $validPrices;
    }

    /**
     * Check check if the order values are autorised and convert them to SQL 
     * command (ASC or DESC)
     * @param string $order value to filter
     * @return string a valid order criterion
     */
    private function filterOrders($order)
    {
        $validOrder = [];
        switch ($order) {
            case "newest":
                $validOrder["value"] = "newest";
                $validOrder["displayable"] = "newest";
                $validOrder["orderSQL"] = "DESC";
                break;
            case "older":
                $validOrder["value"] = "older";
                $validOrder["displayable"] = "older";
                $validOrder["orderSQL"] = "ASC";
                break;
            case "highttolow":
                $validOrder["value"] = "highttolow";
                $validOrder["displayable"] = "hight to low";
                $validOrder["orderSQL"] = "DESC";
                break;
            case "lowtohight":
                $validOrder["value"] = "lowtohight";
                $validOrder["displayable"] = "low to hight";
                $validOrder["orderSQL"] = "ASC";
                break;
        }
        return $validOrder;
    }

    /*———————————————————————————— PRODUCT DB ACCESS DOWN ———————————————————*/
    /**
     * Build a WHERE clause for a sql request
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current currency
     * @return string a [WHERE] and [ORDER BY] SQL clause builded with all criterion
     */
    private function getSql($country, $currency)
    {
        $sql =
            'SELECT DISTINCT p.*, pp.price
        FROM `Products` p
        LEFT JOIN `ProductBuyPrice` pbp ON p.prodID = pbp.prodId 
        LEFT JOIN `BoxColors-Products` bcp ON p.prodID = bcp.prodId
        LEFT JOIN `Products-Collections` pco ON p.prodID = pco.prodId
        LEFT JOIN `Products-ProductFunctions` pf ON p.prodID = pf.prodId
        LEFT JOIN `Products-Categories` pca ON p.prodID = pca.prodId
        LEFT JOIN `Products-Sizes` ps ON p.prodID = ps.prodId
        LEFT JOIN `ProductsPrices` pp ON p.prodID = pp.prodId
        ';

        $sql .= " WHERE p.isAvailable = 1 AND ";
        $sql .= '(pp.country_ = "' . $country->getCountryName() . '" AND pp.iso_currency = "' . $currency->getIsoCurrency() . '"  OR product_type = "' . BoxProduct::BOX_TYPE . '")';
        $sql .= " AND ";
        $sql = $this->concatORGroup($sql, "p.prodID", $this->prodIdList);
        $sql .= " AND ";
        $sql = $this->concatORGroup($sql, "pco.collection_name", $this->collections);
        $sql .= " AND ";
        $sql = $this->concatORGroup($sql, "p.product_type", $this->product_types);
        $sql .= " AND ";
        $sql = $this->concatORGroup($sql, "pf.function_name", $this->functions);
        $sql .= " AND ";
        $sql = $this->concatORGroup($sql, "pca.category_name", $this->categories);
        $sql .= " AND ";
        $sql = $this->concatORGroup($sql, "p.colorName", $this->colors);
        $sql .= " AND ";
        $sql = $this->concatORGroup($sql, "ps.size_name", $this->sizes);
        $sql .= " AND ";
        $sql .= !empty($this->prices["minPrice"]) ? "pp.price >= " . $this->prices["minPrice"]->getPrice() : "(true)";
        $sql .= " AND ";
        $sql .= !empty($this->prices["maxPrice"]) ? "pp.price <= " . $this->prices["maxPrice"]->getPrice() : "(true)";
        if (
            !empty($this->order["value"])
            && !empty($this->order["displayable"])
            && !empty($this->order["orderSQL"])
        ) {
            switch ($this->order["value"]) {
                case "newest":
                    $sql .= " ORDER BY p.addedDate " . $this->order["orderSQL"];
                    break;
                case "older":
                    $sql .= " ORDER BY p.addedDate " . $this->order["orderSQL"];
                    break;
                case "highttolow":
                    $sql .= " ORDER BY pp.price " . $this->order["orderSQL"];
                    break;
                case "lowtohight":
                    $sql .= " ORDER BY pp.price " . $this->order["orderSQL"];
                    break;
            }
        }
        return $sql;
    }

    /**
     * Concatenate a SQL query given with a list criterion and attribute name 
     * like [query + (attribute = criterion1 OR attribute = criterion2 OR ...)]
     * @param string $query the query to concatenate with attribute and criterions
     * @param string $attribute the name of the column
     * @param string[] $criterions a list of criterion
     */
    private function concatORGroup($query, $attribute, $criterions)
    {
        if ((!empty($criterions)) && count($criterions) > 0) {
            $i = 0;
            $query .= " (";
            foreach ($criterions as $criterion) {
                ($i == 0) ? $query .= " $attribute = " . '"' . $criterion . '"'
                    : $query .= " OR $attribute = " . '"' . $criterion . '"';
                $i++;
            }
            $query .= " )";
        } else {
            $query .= "(true)";
        }
        return $query;
    }
    /*———————————————————————————— PRODUCT DB ACCESS UP —————————————————————*/
}
