<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Size.php';
require_once 'model/tools-management/Language.php';

abstract class Product extends ModelFunctionality
{

    /**
     * the Visitor's language
     * @var Language
     */
    protected $language;

    /**
     * the Visitor's country
     * @var Country
     */
    protected $country;

    /**
     * the Visitor's current Currency
     * @var Currency
     */
    protected $currency;

    /**
     * Holds the database id of the product.
     * This id is unique for each product
     * @var int
     */
    protected $prodID;

    /**
     * Holds the Name of the product
     * @var string
     */
    protected $prodName;

    /**
     * Show if a product is available for purchase
     * @var boolean Set true if it available else false
     */
    protected $isAvailable;

    /**
     * Holds id shared by same Product
     * @var boolean
     */
    protected $groupID;

    /**
     * Holds the date of creation of the product in database
     * @var string
     */
    protected $addedDate;

    /**
     * Holds the Color of a product
     * @var string
     */
    protected $colorName;

    /**
     * Holds the RGB Hexa value of the color [^#[0-9]{3,6}]
     * @var string
     */
    protected $colorRGB;

    /**
     * Holds the weight of the product
     * @var float
     */
    protected $weight;

    /**
     * Holds product's foreign System like Google's or Facebook's
     * @var Map
     * + $foreignCategory[SystemCategory{string}] => category{string}
     */
    protected $foreignCategory;

    /**
     * List of prictures of the product.
     * + Use the pictureID as access key like $pictures = [pictureID => picture]
     * @var string[]
     */
    protected $pictures;

    /**
     * List of size physically available for the product and return the quantity for each size
     * + use the name of the size as access key and return the quantity of strok  available
     * + sizesStock = [
     * + +     size_name{string} => stock{int}
     * + ]
     * + NOTE: size are ordred from low to high
     * @var int[]
     */
    protected $sizesStock;

    /**
     * List of product's collections
     * $collections = [
     *      collection_name => [
     *          "beginDate" => string,
     *          "endDate" => string
     *      ]
     * ]
     * @var string[]
     */
    protected $collections;

    /**
     * List of product's functions
     * @var string[]
     */
    protected $prodFunctions;

    /**
     *  List of product's categories
     * @var string[]
     */
    protected $categories;

    /**
     * Holds product's description in Visitor's language else default language.
     * @var string
     */
    protected $description;

    /**
     * Holds product's richDescription in Visitor's language else default language.
     * @var string
     */
    protected $richDescription;

    // /**
    //  * Holds the quantity of this product in a container like basket or box
    //  * + in container, a product is defined by its id, Size and color
    //  */
    // protected const $quantity = 0;

    /**
     * List of products sharing the same name than the current product. NOTE: There are
     * sorted in ascending order of their prodID and use it as access key.
     * @var Product[]
     */
    protected $sameProducts;

    /**
     * Holds the selected Size for this product.
     * @var Size
     */
    protected $selectedSize;

    /**
     * Holds the purchase price of the product
     * @var Price
     */
    protected $buyPrice;

    /**
     * Holds stock product availability
     * @var string
     */
    public const AVAILABILITY_DISCONTINUED = "discontinued";
    public const AVAILABILITY_OUT_STOCK = "out of stock";
    public const AVAILABILITY_IN_STOCK = "in stock";

    public const CATEGORY_GOOGLE = "google_category";

    /**
     * Holds the directory where product's picture are stored
     * @var string
     */
    private static $PATH_PRODUCT;

    /**
     * Holds page's name
     * @var string
     */
    public const PAGE_ITEM = "item/";

    /**
     * Holds glue used to stick strings
     * @var string
     */
    public const GLUE = "-";

    /**
     * Holds max number of cube displayable in artcicle product
     * @var string
     */
    private static $MAX_PRODUCT_CUBE_DISPLAYABLE;

    /**
     * Holds CSS text color
     */
    private static $COLOR_TEXT_08;
    private static $COLOR_TEXT_05;

    /**
     * White color's RGB code
     * @var string
     */
    public const WHITE_RGB = "#ffffff";

    /**
     * @var string db's Products table name
     */
    public const TABLE_PRODUCTS = "Products";

    /**
     * @var string attribut's name
     */
    public const INPUT_PROD_ID = "prodID";

    /**
     * Access key for prodduct's id in ajax
     * @var string attribut's name
     */
    public const KEY_PROD_ID = "prodid";

    /**
     * Access to get products
     * @var string
     */
    public const KEY_PROD_SOLD_OUT = "key_prod_sold_out";
    public const KEY_PROD_LOCKED = "key_prod_locked";

    /**
     * Constructor 
     * @param int $prodID product's id
     * @param Language $language Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current Currency
     */
    protected function __construct($prodID, Language $language, Country $country, Currency $currency)
    {
        $this->prodID = $prodID;
        if ($this->existProductInMap($this->prodID)) {
            $productLine = $this->getProductLine($this->prodID);
        } else {
            $sql = "SELECT * FROM `Products` WHERE `prodID` = '$this->prodID'";
            $tab = $this->select($sql);
            if (count($tab) != 1) {
                throw new Exception("No product has this id $this->prodID");
            }
            $productLine = $tab[0];
        }
        $this->setConstants();
        $this->language = $language;
        $this->country = $country;
        $this->currency = $currency;
        $this->prodName = $productLine["prodName"];
        $this->isAvailable = $productLine["isAvailable"];
        $this->groupID = $productLine["groupID"];
        $this->addedDate = $productLine["addedDate"];
        $this->colorName = $productLine["colorName"];
        $this->colorRGB = $productLine["colorRGB"];
        $this->weight = $productLine["weight"];
        $this->foreignCategory = new Map();
        $googleCat = $productLine["googleCat"];
        $this->foreignCategory->put($googleCat, self::CATEGORY_GOOGLE);
    }

    /**
     * Initialize Product's constants
     */
    private function setConstants()
    {
        if (!isset(self::$MAX_PRODUCT_CUBE_DISPLAYABLE)) {
            self::$MAX_PRODUCT_CUBE_DISPLAYABLE = "MAX_PRODUCT_CUBE_DISPLAYABLE";
            self::$MAX_PRODUCT_CUBE_DISPLAYABLE = (int) $this->getConstantLine(self::$MAX_PRODUCT_CUBE_DISPLAYABLE)["stringValue"];
        }
        if (!isset(self::$COLOR_TEXT_08)) {
            self::$COLOR_TEXT_08 = "COLOR_TEXT_08";
            self::$COLOR_TEXT_08 = $this->getConstantLine(self::$COLOR_TEXT_08)["stringValue"];
        }
        if (!isset(self::$COLOR_TEXT_05)) {
            self::$COLOR_TEXT_05 = "COLOR_TEXT_05";
            self::$COLOR_TEXT_05 = $this->getConstantLine(self::$COLOR_TEXT_05)["stringValue"];
        }
        self::$PATH_PRODUCT = (!isset(self::$PATH_PRODUCT))
            ? Configuration::get(Configuration::PATH_PRODUCT)
            : self::$PATH_PRODUCT;
    }

    /**
     * Setter for product's collections
     */
    protected function setCollections()
    {
        $this->collections  = [];
        $sql = "SELECT * 
        FROM `Products-Collections`
        WHERE `prodId` = '$this->prodID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $this->collections[$tabLine["collection_name"]]["beginDate"] = $tabLine["beginDate"];
                $this->collections[$tabLine["collection_name"]]["endDate"] = $tabLine["endDate"];
            }
        }
    }

    /**
     * Setter for product's functions
     */
    protected function setProdFunctions()
    {
        $this->prodFunctions  = [];
        $sql = "SELECT * 
        FROM `Products-ProductFunctions`
        WHERE `prodId` = '$this->prodID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                array_push($this->prodFunctions, $tabLine["function_name"]);
            }
        }
    }

    /**
     * Setter for product's categories
     */
    protected function setCategories()
    {
        $this->categories  = [];
        $sql = "SELECT * 
        FROM `Products-Categories`
        WHERE `prodId` = '$this->prodID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                array_push($this->categories, $tabLine["category_name"]);
            }
        }
    }

    /**
     * Setter for product's description
     */
    protected function setDescriptions()
    {
        $language = $this->getLanguage();
        $isoLang = $language->getIsoLang();
        $sql = "SELECT * 
        FROM `ProductsDescriptions`
        WHERE `prodId` = '$this->prodID' AND `lang_` = '$isoLang'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            $tabLine = $tab[0];
            $this->description = $tabLine["description"];
            $this->richDescription = $tabLine["richDescription"];
        }
    }

    /**
     * Fill the same product list with product sharing the same name that the 
     * current product.
     */
    protected function setSameProducts()
    {
        $this->sameProducts = [];
        $prodID = $this->getProdID();
        $groupID = $this->getGroupID();
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $sql = "SELECT `prodID` 
        FROM `Products` 
        WHERE isAvailable = 1 AND `prodID`!='$prodID' AND `groupID` = '$groupID'  
        ORDER BY `Products`.`prodID` ASC";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            $class = get_class($this);
            foreach ($tab as $tabLine) {
                $sameProdID = $tabLine["prodID"];
                $product = new $class($sameProdID, $language, $country, $currency);
                $this->sameProducts[$product->getProdID()] = $product;
            }
        }
    }

    // /**
    //  * To set all other properties that nat in Product table
    //  * @param Language $lang Visitor's language
    //  * @param Country $country the Visitor's country
    //  * @param Currency the Visitor's current Currency
    //  */
    // public abstract function CompleteProperties($lang, $country, $currency);

    /**
     * Getter of product's type
     * @return string the type of the product
     */
    public abstract function getType();

    /**
     * Getter for language
     * @return Language Visistor's language
     */
    protected function getLanguage()
    {
        return $this->language;
    }

    /**
     * Getter for country
     * @return Country Visistor's country
     */
    protected function getCountry()
    {
        return $this->country;
    }

    /**
     * Getter for currency
     * @return Currency Visistor's currency
     */
    protected function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Setter for product's pictures
     */
    protected function setPictures()
    {
        $this->pictures = [];
        $sql = "SELECT * 
        FROM `ProductsPictures` 
        WHERE `prodId` = '$this->prodID'
        ORDER BY `ProductsPictures`.`pictureID` ASC";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $this->pictures[$tabLine["pictureID"]] = $tabLine["picture"];
            }
        }
    }

    /**
     * Setter for sizesStock
     */
    protected function setSizeStock()
    {
        $this->sizesStock  = [];
        $sql = "SELECT * 
        FROM `Products-Sizes`
        WHERE `prodId` = '$this->prodID'";
        $tab = $this->select($sql); // add error if there is no size
        if (count($tab) < 1) {
            throw new Exception("There no size for this product");
        }
        foreach ($tab as $tabLine) {
            $size = $tabLine["size_name"];
            $this->sizesStock[$size] = (int) $tabLine["stock"];
        }
        $supported = $this->getSupportedSizes($size);
        $this->sizesStock = $this->orderSizes($supported, $this->sizesStock);
    }

    /**
     * To order size or an array following orderr of an other array of size
     * @param array $orderedSizes odered array of size
     * + [index{int} => size{string|int}] 
     * @param array $toOrderSizes sizes to order
     * + [size{string|int} => stock{int}]
     * @return array ordered array based on the array to order
     */
    protected function orderSizes($orderedSizes, $toOrderSizes)
    {
        $ordered =  [];
        foreach ($orderedSizes as $size) {
            if (key_exists($size, $toOrderSizes)) {
                $ordered[$size] = $toOrderSizes[$size];
            }
        }
        return $ordered;
    }

    /**
     * To get from db the supported sizes
     * + the type of size is automatically deducted with the type of size holds
     * in the sizeStock attribut
     * @param string|int|float $sizeSample size used to determinate the type of the size to return
     * @return array a list of supported sizes get from db
     */
    protected function getSupportedSizes($sizeSample)
    {
        return Size::getSupportedSizes($sizeSample);
    }

    /**
     * To increase or decrease the quantity of product holds by container
     * @param int $quantity product's quantity
     */
    public function addQuantity(int $quantity = 1)
    {
        $selectedSize = $this->getSelectedSize();
        if (!isset($selectedSize)) {
            throw new Exception("Can't get product's selected size cause it not initialized!");
        }
        return $selectedSize->addQuantity($quantity);
    }

    /**
     * Set product's selected size
     * @param Size $size 
     */
    public abstract function selecteSize(Size $size);

    /**
     * Getter for the product's id
     * @return int the id of the product
     */
    public function getProdID()
    {
        return $this->prodID;
    }

    /**
     * Getter for the product's name
     * @return string the product's name
     */
    public function getProdName()
    {
        return $this->prodName;
    }

    /**
     * To get if product is available to order
     * @return boolean true if product is available to order else false
     */
    public function isAvailable()
    {
        return $this->isAvailable;
    }

    /**
     * To get Product's group id
     * @return string Product's group id
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

    /**
     * Getter for the product's color
     * @return string the product's color
     */
    public function getColorName()
    {
        return $this->colorName;
    }
    #03030

    /**
     * Getter for the product's color RGB code [^#[0-9]{3,6}]
     * @return string the product's color
     */
    public function getColorRGB()
    {
        return $this->colorRGB;
    }

    /**
     * Getter for the product's color RGB code for text
     * + NOTE: if the colorr is white a other color is returned
     * @return string the product's color for text
     */
    public function getColorRGBText()
    {
        $colorRGB = $this->getColorRGB();
        return ($colorRGB != self::WHITE_RGB) ? $colorRGB : self::$COLOR_TEXT_05;
    }

    /**
     * Getter for box's weight
     * @return float box's weight
     */
    protected function getWeight()
    {
        return $this->weight;
    }

    /**
     * To get product's foreaign category
     * @param string $foreignSystKey to get category from this system
     * @return string product's foreaign category
     */
    public function getForeignCategory(string $foreignSystKey)
    {
        $category = $this->foreignCategory->get($foreignSystKey);
        if (empty($category)) {
            throw new Exception("Product's foreign category can't be empty");
        }
        return $category;
    }

    /**
     * Getter for the product's pictures list
     * @return string[] product's pictures list
     */
    public function getPictures()
    {
        (!isset($this->pictures)) ? $this->setPictures() : null;
        return $this->pictures;
    }

    /**
     * Getter for the product's pictures list
     * @return string[] product's pictures list
     */
    public function getPictureSources()
    {
        $picSrc = [];
        $pictures = $this->getPictures();
        if (count($pictures) > 0) {
            foreach ($pictures as $key => $picture) {
                $picSrc[$key] = self::$PATH_PRODUCT . $picture;
            }
        }
        return $picSrc;
    }

    /**
     * To get a url that display product on the page given in param
     * NOTE: format
     * @param $page page that url refer to
     * @return string 
     */
    public function getUrlPath(string $page)
    {
        $url = "";
        switch ($page) {
            case self::PAGE_ITEM:
                $prodID = $this->getProdID();
                $url .= self::PAGE_ITEM . $prodID;
                $prodName = $this->getProdName();
                $color = $this->getColorName();
                $datas = [];
                array_push($datas, $prodName, $color);
                $collections = $this->getCollections();
                $functions  = $this->getProdFunctions();
                $categories = $this->getCategories();
                $datas = array_merge($datas, $collections, $functions, $categories);
                $info = (count($datas) > 0) ? "/" . implode(self::GLUE, $datas) : "";
                $url .= str_replace(["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"], "", $info);
                break;
            default:
                throw new Exception("This url page don't exist, page:$page");
                break;
        }
        return $url;
    }

    // /**
    //  * Getter for product's stock for each size
    //  * @return int[] product's stock for each size
    //  */
    // protected abstract function getSizeStock();
    /**
     * Getter for product's stock for each size
     * @return int[] product's stock for each size
     */
    public function getSizeStock()
    // protected function getSizeStock()
    {
        (!isset($this->sizesStock)) ? $this->setSizeStock() : null;
        return $this->sizesStock;
    }

    /**
     * Getter for product's sizes
     * @return string[] product's sizes
     */
    public abstract function getSizes();

    /**
     * Getter for the product's selected size
     * @return Size product's selected size
     */
    public function getSelectedSize()
    {
        // if(empty($this->selectedSize)){
        //     throw new Exception("There's no selected size");
        // }
        return $this->selectedSize;
    }

    /**
     * To extract Size from a list of product
     * @param Product $products list of product
     * @return Map list of Size
     * + Map[sequence] => Size
     */
    public static function extractSizes(array $products)
    {
        $sizesMap = new Map();
        foreach ($products as $product) {
            $selectedSize = $product->getSelectedSize();
            $sequence = $selectedSize->getSequence();
            $sequences = $sizesMap->getKeys();
            (!in_array($sequence, $sequences)) ? $sizesMap->put($selectedSize, $sequence) : null;
        }
        return $sizesMap;
    }

    /**
     * To generate sequence with product's id and the selected size
     * @return string sequence using product's id and its selected size
     */
    public function generateSequence()
    {
        $prodID = $this->getProdID();
        $selectedSize = $this->getSelectedSize();
        return $prodID . Size::SEQUENCE_SEPARATOR  . $selectedSize->getSequence();
        // return $prodID
        //     . Size::SEQUENCE_SEPARATOR 
        //     . $selectedSize->getsize(true) 
        //     . Size::SEQUENCE_SEPARATOR 
        //     . $selectedSize->getmeasureID(true)
        //     . Size::SEQUENCE_SEPARATOR
        //     . $selectedSize->getCut(true);
    }


    /**
     * Getter of product's collection name
     * @return string[] product's collection name (without date data)
     */
    public function getCollections()
    {
        (!isset($this->collections)) ? $this->setCollections() : null;
        return array_keys($this->collections);
    }

    /**
     * Getter of product's function name
     * @return string[] product's function name
     */
    public function getProdFunctions()
    {
        (!isset($this->prodFunctions)) ? $this->setProdFunctions() : null;
        return $this->prodFunctions;
    }

    /**
     * Getter of product's categories name
     * @return string[] product's categories name
     */
    public function getCategories()
    {
        (!isset($this->categories)) ?  $this->setCategories() : null;
        return $this->categories;
    }

    /**
     * Getter for product's description
     * @return string product's description
     */
    public function getDescription()
    {
        (!isset($this->description)) ? $this->setDescriptions() : null;
        return $this->description;
    }

    /**
     * Getter for product's rich description
     * @return string product's rich description
     */
    public function getRichDescription()
    {
        (!isset($this->richDescription)) ? $this->setDescriptions() : null;
        return $this->richDescription;
    }

    /**
     * Getter for product's quantity holds by a container
     * @return int $quantity product's quantity holds by a container
     */
    public function getQuantity()
    {
        $selectedSize = $this->getSelectedSize();
        if (!isset($selectedSize)) {
            throw new Exception("Can't get product's selected size cause it not initialized!");
        }
        return $selectedSize->getQuantity();
    }

    /**
     * Getter for product's price
     * @return Price product's price
     * + for boxProduct will return Price with a zero as value
     */
    public abstract function getPrice();

    /**
     * Getter for product's formated price
     * @return string product's formated price
     */
    public abstract function getFormatedPrice();

    // /**
    //  * To get cuts available
    //  * @return string[] cuts available
    //  */
    // public function getCutsValueToValue()
    // {
    //     $tab = $this->getTableValues("cuts");
    //     $cuts = array_keys($tab);
    //     return $this->arrayToMap($cuts);
    // }

    // /**
    //  * Build a HTML displayable price
    //  * @return string[] product's HTML displayable price
    //  */
    // public abstract function getDisplayablePrice();

    /**
     * Getter for sameProducts
     * @return BasketProduct[]|BoxProduct[] a prodtected copy of sameProducts
     */
    public abstract function getSameProducts();

    /**
     * Getter for max color cube to display
     * @param int max color cube 
     */
    public static function getMAX_PRODUCT_CUBE_DISPLAYABLE()
    {
        return self::$MAX_PRODUCT_CUBE_DISPLAYABLE;
    }

    /**
     * Check if it's still stock for the product submited by Visitor
     * + it's still stock mean that there size that fit the Visitor's submited size
     * @param Size $sizeObjs selected sizes to check if still stock for it
     * @return boolean true if the stock is available
     */
    public abstract function stillStock(Size ...$sizeObjs);

    // /**
    //  * To check if still stock for product including product locked
    //  * + this function combine stock available and stock locked to deduct the 
    //  * stilling stock
    //  * @return boolean set true if still stock else false
    //  */
    // public abstract function stillUnlockedStock();

    /**
     * To evaluate if still at less one size in stock
     * + if $isAvailable = false => 'discontinued'
     * + if SUM($sizesStock) > 0 => 'in stock'
     * + if SUM($sizesStock) <= 0 => 'out of stock'
     * @return string discontinued | in stock | out of stock
     */
    public function getAvailability()
    {
        $availability = null;
        if (!$this->isAvailable()) {
            $availability = self::AVAILABILITY_DISCONTINUED;
        } else {
            $sizesStock = $this->getSizeStock();
            $availability = (array_sum($sizesStock) > 0)
                ? self::AVAILABILITY_IN_STOCK
                : self::AVAILABILITY_OUT_STOCK;
        }
        return $availability;
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        $selectedSize = $this->getSelectedSize();
        if (!isset($selectedSize)) {
            throw new Exception("Can't get product's selected size cause it not initialized!");
        }
        return strtotime($selectedSize->getSetDate());
    }

    /**
     * Check if a value given in param is inside the collection list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function collectionIsInside($value)
    {
        $collections = $this->getCollections();
        return array_key_exists($value, $collections);
    }

    /**
     * Check if a value given in param is inside the prodFunctions list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function functionIsInside($value)
    {
        $prodFunctions = $this->getProdFunctions();
        return in_array($value, $prodFunctions);
    }

    /**
     * Check if a value given in param is inside the categories list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function categoryIsInside($value)
    {
        $categories = $this->getCategories();
        return in_array($value, $categories);
    }

    /**
     * Check if a value given in param is inside the size list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function sizeIsInside($value)
    {
        $sizesStock = $this->getSizeStock();
        return array_key_exists($value, $sizesStock);
    }

    /**
     * To get A copy of the currrent instance
     * @return Product
     */
    public abstract function getCopy();

    /*———————————————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * To delete all existing locked stock for the User's with the give id
     * @param Response $response where to strore results
     * @param string $userID Client's id
     */
    public static function deleteLocks(Response $response, $userID)
    {
        $sql = "DELETE FROM `StockLocks` WHERE `StockLocks`.`userId` = '$userID'";
        parent::delete($response, $sql);
    }
}
