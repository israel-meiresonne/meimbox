<?php

class Search
{
    /**
     * Holds a list product id
     * @var string[]
     */
    private $prodIDList;

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
     * @var string[] $products
     */
    private $products;

    /**
     * Holds a list of Product ordered by criterion
     * @var string[string[Product]]
     */
    private $searchMap;

    const NEWEST = "newest";
    const OLDER = "older";
    const HIGHT_TO_LOW = "highttolow";
    const LOW_TO_HIGHT = "lowtohight";

    /**
     * Holds the search method for system's search
     * @var string
     */
    const SYSTEM_SEARCH = "SYSTEM_SEARCH";

    /**
     * Holds the value of $_POST["qr"] that will execute a product Search
     * @var string the value of $_POST["qr"] that will execute a product Search
     */
    const QR_FILTER = "filter";

    

    function __construct()
    {
        $prodIDList = [];
        $this->collections = [];
        $this->product_types = [];
        $this->functions = [];
        $this->categories = [];
        $this->colors = [];
        $this->sizes = [];
        $this->prices["minPrice"] = [];
        $this->prices["maxPrice"] = [];
        $argv = func_get_args();
        switch (func_num_args()) {
            case 3:
                self::__construct3($argv[0], $argv[1], $argv[2]);
                break;
            case 4:
                self::__construct4($argv[0], $argv[1], $argv[2], $argv[3]);
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
     * @param Currency the Visitor's current Currency
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    private function __construct4($method, $criterions, $currency, $dbMap)
    {

        $prodIDList = isset($criterions["prodID"]) ? $criterions["prodID"] : null;
        $this->prodIDList = self::filterValidValues("productIDList", $prodIDList, $dbMap);

        $collections = isset($criterions["collections"]) ? $criterions["collections"] : null;
        $product_types = isset($criterions["product_types"]) ? $criterions["product_types"] : null;
        $functions = isset($criterions["functions"]) ? $criterions["functions"] : null;
        $categories = isset($criterions["categories"]) ? $criterions["categories"] : null;
        $colors = isset($criterions["colors"]) ? $criterions["colors"] : null;
        $sizes = isset($criterions["sizes"]) ? $criterions["sizes"] : null;

        $this->collections = self::filterValidValues("collections", $collections, $dbMap);
        $this->product_types = self::filterValidValues("product_types", $product_types, $dbMap);
        $this->functions = self::filterValidValues("functions", $functions, $dbMap);
        $this->categories = self::filterValidValues("categories", $categories, $dbMap);
        $this->colors = self::filterValidValues("colors", $colors, $dbMap);
        $this->sizes = self::filterValidValues("sizes", $sizes, $dbMap);

        $order = isset($criterions["order"]) ? $criterions["order"] : null;
        $order = self::filterOrders($order);
        $this->order =  $order;

        $prices["minprice"] = isset($criterions["minprice"]) ? $criterions["minprice"] : null;
        $prices["minprice"] = preg_match("#[.]{1}#", $prices["minprice"]) == 1
            ? $prices["minprice"]
            : $prices["minprice"] . "00";

        $prices["maxprice"] = isset($criterions["maxprice"]) ? $criterions["maxprice"] : null;
        $prices["maxprice"] = preg_match("#[.]{1}#", $prices["maxprice"]) == 1
            ? $prices["maxprice"]
            : $prices["maxprice"] . "00";
        $pricesObj = self::filterPrices($prices, $currency);
        $this->prices["minPrice"] = $pricesObj["minprice"];
        $this->prices["maxPrice"] = $pricesObj["maxprice"];

        $this->products = [];
        $this->searchMap = [];
    }

    /**
     * This constructor set the following attributs (first 6 attributs) with the
     *  URL by using GET variable: collections, product_types, categories, 
     * colors, sizes and prices
     * @param string $method request method of the search ["GET","POST"]
     * @param Currency the Visitor's current Currency
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    private function __construct3($method, $currency, $dbMap)
    {
        switch ($method) {
            case Query::GET_MOTHOD:
                self::setGETSearch($currency, $dbMap);
                break;
            case Query::POST_MOTHOD:
                self::setPOSTSearch($currency, $dbMap);
                break;
                // case self::SYSTEM_SEARCH:
                //     self::setSystemSearch($currency, $dbMap);
                //     break;
        }
    }

    /**
     * This constructor set the attributs with the URL by using $_GET
     *  variable. NOTE: this method dont set products lsit and search map
     * @param Currency the Visitor's current Currency
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    private function setGETSearch($currency, $dbMap)
    {
        if (isset($_GET["prodID"])) {
            $prodIDList = explode(",", GeneralCode::clean($_GET["prodID"]));
            $this->prodIDList = self::filterValidValues("productIDList", $prodIDList, $dbMap);
        } else {
            $collections = isset($_GET["collections"]) ? explode(",", GeneralCode::clean($_GET["collections"])) : null;
            $product_types = isset($_GET["product_types"]) ? explode(",", GeneralCode::clean($_GET["product_types"])) : null;
            $functions = isset($_GET["functions"]) ? explode(",", GeneralCode::clean($_GET["functions"])) : null;
            $categories = isset($_GET["categories"]) ? explode(",", GeneralCode::clean($_GET["categories"])) : null;
            $colors = isset($_GET["colors"]) ? explode(",", GeneralCode::clean($_GET["colors"])) : null;
            $sizes = isset($_GET["sizes"]) ? explode(",", GeneralCode::clean($_GET["sizes"])) : null;

            $this->collections = self::filterValidValues("collections", $collections, $dbMap);
            $this->product_types = self::filterValidValues("product_types", $product_types, $dbMap);
            $this->functions = self::filterValidValues("functions", $functions, $dbMap);
            $this->categories = self::filterValidValues("categories", $categories, $dbMap);
            $this->colors = self::filterValidValues("colors", $colors, $dbMap);
            $this->sizes = self::filterValidValues("sizes", $sizes, $dbMap);

            $order = isset($_GET["order"]) ? GeneralCode::clean($_GET["order"]) : null;
            $order = self::filterOrders($order);
            $this->order =  $order;
            $prices = isset($_GET["prices"]) ? explode(",", GeneralCode::clean($_GET["prices"])) : null;
            $pricesObj = self::filterPrices($prices, $currency);
            $this->prices["minPrice"] = $pricesObj[0];
            $this->prices["maxPrice"] = $pricesObj[1];
        }
        $this->products = [];
        $this->searchMap = [];
    }

    /**
     * This constructor set the attributs with the server request by using $_POST
     *  variable. NOTE: this method dont set products lsit and search map
     * @param Currency the Visitor's current Currency
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    private function setPOSTSearch($currency, $dbMap)
    {
        $collections = [];
        $product_types = [];
        $functions = [];
        $categories = [];
        $colors = [];
        $sizes = [];
        foreach ($_POST as $criterion => $value) {
            $shortCriterion = preg_replace("#_[0-9]+#", "", $criterion);
            switch ($shortCriterion) {
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

        $this->collections = self::filterValidValues("collections", $collections, $dbMap);
        $this->product_types = self::filterValidValues("product_types", $product_types, $dbMap);
        $this->functions = self::filterValidValues("functions", $functions, $dbMap);
        $this->categories = self::filterValidValues("categories", $categories, $dbMap);
        $this->colors = self::filterValidValues("colors", $colors, $dbMap);
        $this->sizes = self::filterValidValues("sizes", $sizes, $dbMap);

        $order = isset($_POST["order"]) ? GeneralCode::clean($_POST["order"]) : null;
        $order = self::filterOrders($order);
        $this->order =  $order;

        $prices["minprice"] = isset($_POST["minprice"]) ? GeneralCode::clean($_POST["minprice"]) : null;
        $prices["minprice"] = preg_match("#[.]{1}#", $prices["minprice"]) == 1
            ? $prices["minprice"]
            : $prices["minprice"] . "00";

        $prices["maxprice"] = isset($_POST["maxprice"]) ? GeneralCode::clean($_POST["maxprice"]) : null;
        $prices["maxprice"] = preg_match("#[.]{1}#", $prices["maxprice"]) == 1
            ? $prices["maxprice"]
            : $prices["maxprice"] . "00";
        $pricesObj = self::filterPrices($prices, $currency);
        $this->prices["minPrice"] = $pricesObj["minprice"];
        $this->prices["maxPrice"] = $pricesObj["maxprice"];
        $this->products = [];
        $this->searchMap = [];
    }

    /**
     * Fill the Products attrribut with all product matching the search. 
     * Products are ordered following the order asked in the search else in a 
     * marketing order.
     * @param string[] $dbSearchMap database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    public function setProducts($dbSearchMap)
    {
        $basketProdMap = $dbSearchMap["productMap"][BasketProduct::BASKET_TYPE];
        foreach ($basketProdMap as $prodID => $product) {
            $basketProduct = new BasketProduct($prodID, $dbSearchMap);
            // Helper::printLabelValue("basketProduct", $basketProduct);
            $this->products[$product["datas"]["queryPosition"]] = $basketProduct;
        }

        $boxProdMap = $dbSearchMap["productMap"][BoxProduct::BOX_TYPE];
        foreach ($boxProdMap as $prodID => $product) {
            $boxProduct = new BoxProduct($prodID, $dbSearchMap);
            $this->products[$product["datas"]["queryPosition"]] = $boxProduct;
        }
        ksort($this->products);
        self::setSearchMap($this->products);
    }

    /**
     * Builds the searchMap using each criterion as key and filling them of all
     *  product witch match this criterion
     * @param boxProduct[]&basketProduct[] $products a list of products witch match the search
     */
    private function setSearchMap($products)
    {
        foreach ($this->collections as $collection) {
            $this->searchMap["collections"][$collection] = [];
            $i = 0;
            foreach ($products as $product) {
                if ($product->collectionIsInside($collection)) {
                    array_push($this->searchMap["collections"][$collection], $products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->product_types as $product_type) {
            $this->searchMap["product_types"][$product_type] = [];
            $i = 0;
            foreach ($products as $product) {
                if ($product->getType() == $product_type) {
                    array_push($this->searchMap["product_types"][$product_type], $products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->functions as $function) {
            $this->searchMap["functions"][$function] = [];
            $i = 0;
            foreach ($products as $product) {
                if ($product->functionIsInside($function)) {
                    array_push($this->searchMap["functions"][$function], $products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->categories as $category) {
            $this->searchMap["categories"][$category] = [];
            $i = 0;
            foreach ($products as $product) {
                if ($product->categoryIsInside($category)) {
                    array_push($this->searchMap["categories"][$category], $products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->colors as $color) {
            $this->searchMap["colors"][$color] = [];
            $i = 0;
            foreach ($products as $product) {
                if ($product->getColorName() == $color) {
                    array_push($this->searchMap["colors"][$color], $products[$i]);
                }
                $i++;
            }
        }
        foreach ($this->sizes as $size) {
            $this->searchMap["sizes"][$size] = [];
            $i = 0;
            foreach ($products as $product) {
                if ($product->sizeIsInside($size)) {
                    array_push($this->searchMap["sizes"][$size], $products[$i]);
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
     * @return BoxProduct|BasketProduct a protected copy of products
     */
    public function getProducts()
    {
        return GeneralCode::cloneMap($this->products);
    }

    /**
     * Getter of the searchMap
     * @return string[string[BoxProduct|BasketProduct]] a protected copy of the searchMap
     */
    public function getSearchMap()
    {
        return GeneralCode::cloneMap($this->searchMap);
    }

    /**
     * Build a array with all criterion into string format.
     * @param Language $language the Visitor's current language
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string[] list of criterion needed to build search stickers
     */
    public function getStickers($language, $translator)
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
                // $minPrice = new Price($this->prices["minPrice"], $currency);
                // $formatedPrice = $minPrice->getFormated();
                // $minPriceDisplayable = "min: " . $formatedPrice;
                // $stickers[$minPriceDisplayable] = $minPrice->getPrice();

                $minPrice = $this->prices["minPrice"]->getPrice();
                $minPriceDisplayable = $this->prices["minPrice"]->getMinPrice($language, $translator);
                $stickers[$minPriceDisplayable] = $minPrice;
            }
            if (!empty($this->prices["maxPrice"])) {
                // $maxPrice = new Price($this->prices["maxPrice"], $currency);
                // $formatedPrice = $maxPrice->getFormated();
                // $maxPriceDisplayable = "max: " . $formatedPrice;
                // $stickers[$maxPriceDisplayable] = $maxPrice->getPrice();

                $maxPrice = $this->prices["maxPrice"]->getPrice();
                $maxPriceDisplayable = $this->prices["maxPrice"]->getMaxPrice($language, $translator);
                $stickers[$maxPriceDisplayable] = $maxPrice;
            }
        }

        $product_types = GeneralCode::fillValueWithValue($this->product_types);
        $stickers = GeneralCode::fillArrayWithArray($stickers, $product_types);

        $functions = GeneralCode::fillValueWithValue($this->functions);
        $stickers = GeneralCode::fillArrayWithArray($stickers, $functions);

        $categories = GeneralCode::fillValueWithValue($this->categories);
        $stickers = GeneralCode::fillArrayWithArray($stickers, $categories);

        $colors = GeneralCode::fillValueWithValue($this->colors);
        $stickers = GeneralCode::fillArrayWithArray($stickers, $colors);

        $sizes = GeneralCode::fillValueWithValue($this->sizes);
        $stickers = GeneralCode::fillArrayWithArray($stickers, $sizes);

        return $stickers;
    }

    /**
     * Check if all values exist in a database table
     * @param string $tableName a database table's name
     * @param string[] $values value to check if they exist in a database table
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @return string[] all values existing in a database table
     */
    private function filterValidValues($tableName, $values, $dbMap)
    {
        $validValues = [];
        foreach ($values as $value) {
            in_array($value, $dbMap[$tableName]) ? array_push($validValues, $value)
                : null;
        }
        return $validValues;
    }

    /**
     * Check if all max price and min price are float value and convert them to float
     * @param string[] list of price in string and int format (so there not decimal: 10.99 => 1099)
     * @param Currency the Visitor's current Currency
     * @return string[float[]] all valid price converted from string to float
     */
    private function filterPrices($prices, $currency)
    {
        $validPrices = [];
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

    /**
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current currency
     * @return string a [WHERE] and [ORDER BY] SQL clause builded with all criterion
     */
    public function getSQLQuery($country, $currency)
    {
        $query = "WHERE p.isAvailable = 1 AND ";
        $query .= '(pp.country_ = "' . $country->getCountryName() . '" AND pp.iso_currency = "' . $currency->getIsoCurrency() . '"  OR product_type = "' . BoxProduct::BOX_TYPE . '")';
        $query .= " AND ";
        $query = self::concatORGroup($query, "p.prodID", $this->prodIDList);
        $query .= " AND ";
        $query = self::concatORGroup($query, "pco.collection_name", $this->collections);
        $query .= " AND ";
        $query = self::concatORGroup($query, "p.product_type", $this->product_types);
        $query .= " AND ";
        $query = self::concatORGroup($query, "pf.function_name", $this->functions);
        $query .= " AND ";
        $query = self::concatORGroup($query, "pca.category_name", $this->categories);
        $query .= " AND ";
        $query = self::concatORGroup($query, "p.colorName", $this->colors);
        $query .= " AND ";
        $query = self::concatORGroup($query, "ps.size_name", $this->sizes);
        $query .= " AND ";
        $query .= !empty($this->prices["minPrice"]) ? "pp.price >= " . $this->prices["minPrice"]->getPrice() : "(true)";
        $query .= " AND ";
        $query .= !empty($this->prices["maxPrice"]) ? "pp.price <= " . $this->prices["maxPrice"]->getPrice() : "(true)";
        if (
            !empty($this->order["value"])
            && !empty($this->order["displayable"])
            && !empty($this->order["orderSQL"])
        ) {
            switch ($this->order["value"]) {
                case "newest":
                    $query .= " ORDER BY p.addedDate " . $this->order["orderSQL"];
                    break;
                case "older":
                    $query .= " ORDER BY p.addedDate " . $this->order["orderSQL"];
                    break;
                case "highttolow":
                    $query .= " ORDER BY pp.price " . $this->order["orderSQL"];
                    break;
                case "lowtohight":
                    $query .= " ORDER BY pp.price " . $this->order["orderSQL"];
                    break;
            }
        }
        return $query;
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
        if (count($criterions) > 0) {
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

    public function __toString()
    {
        Helper::printLabelValue("collections", $this->collections);
        Helper::printLabelValue("order", $this->order);
        Helper::printLabelValue("product_types", $this->product_types);
        Helper::printLabelValue("functions", $this->functions);
        Helper::printLabelValue("categories", $this->categories);
        Helper::printLabelValue("colors", $this->colors);
        Helper::printLabelValue("sizes", $this->sizes);
        Helper::printLabelValue("prices", $this->prices);
        Helper::printLabelValue("searchMap", $this->searchMap);

        foreach ($this->products as $index => $product) {
            echo "<hr> index " . $index . ":   ";
            $product->__toString();
            echo "<hr>";
        }
        foreach ($this->searchMap as $criterion => $productList) {
            echo "<hr> criterion: " . $criterion . "   <br>";
            Helper::printLabelValue("productList", $productList);
            echo "<hr>";
        }
    }
}
