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
     * @var double
     */
    protected $weight;

    /**
     * List of prictures of the product.
     * + Use the pictureID as access key like $pictures = [pictureID => picture]
     * @var string[]
     */
    protected $pictures;

    /**
     * List of size available for the product and the quantity available for purchase the product
     * Use the size name as access key and return a bolean value witch indicate if the size is selected
     * like 
     * sizesStock = [
     *      size_name => stock
     *  ]
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
     * Holds the directory where product's picture are stored
     * @var string
     */
    private const PICTURE_DIR = "content/brain/prod/";

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
     * Constructor 
     * @param int $prodID product's id
     * @param Language $language Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current Currency
     */
    protected function __construct($prodID, Language $language, Country $country, Currency $currency)
    {
        $this->setConstants();
        $this->prodID = $prodID;
        $this->language = $language;
        $this->country = $country;
        $this->currency = $currency;
        if ($this->existProductInMap($prodID)) {
            $productLine = $this->getProductLine($prodID);
            $this->prodName = $productLine["prodName"];
            $this->isAvailable = $productLine["isAvailable"];
            $this->addedDate = $productLine["addedDate"];
            $this->colorName = $productLine["colorName"];
            $this->colorRGB = $productLine["colorRGB"];
            $this->weight = $productLine["weight"];
        } else {
            $sql = "SELECT * FROM `Products` WHERE `prodID` = '$this->prodID'";
            $tab = $this->select($sql);
            if (count($tab) != 1) {
                throw new Exception("No product has this id $prodID");
            }
            $productLine = $tab[0];
            $this->prodName = $productLine["prodName"];
            $this->isAvailable = $productLine["isAvailable"];
            $this->addedDate = $productLine["addedDate"];
            $this->colorName = $productLine["colorName"];
            $this->colorRGB = $productLine["colorRGB"];
            $this->weight = $productLine["weight"];
        }
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
     * Setter for product's size and stock
     */
    protected function setSizesStock()
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
            $this->sizesStock[$tabLine["size_name"]] = $tabLine["stock"];
        }
    }
    // /**
    //  * Setter for product's size and stock
    //  */
    // protected abstract function setSizesStock();

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
        // var_dump($tab);
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
     * @param Language $lang Visitor's language
     */
    protected function setDescriptions(Language $lang)
    {
        $isoLang = $lang->getIsoLang();
        $sql = "SELECT * 
        FROM `ProductsDescriptions`
        WHERE `prodId` = '$this->prodID' AND `lang_` = '$isoLang'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            $this->description = $tab[0]["description"];
        }
    }

    // /**
    //  * Setter for product's quantity
    //  * @param int $quantity product's quantity
    //  */
    // protected function setQuantity(int $quantity)
    // {
    //     $this->quantity = $quantity;
    // }

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
    public function selecteSize(Size $size)
    {
        $this->selectedSize = $size;
    }

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
                $picSrc[$key] = self::PICTURE_DIR . $picture;
            }
        }
        return $picSrc;
    }

    // /**
    //  * To get a url whitch refer to page given in param
    //  * @param $page page that url refer to
    //  * @return string 
    //  */
    // public abstract function getUrl(string $page);

    /**
     * To get a url that display product on the page given in param
     * @param $page page that url refer to
     * @return string 
     */
    public function getUrl(string $page)
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

    /**
     * Getter for product's stock for each size
     * @return int[] product's stock for each size
     */
    protected function getSizeStock()
    {
        (!isset($this->sizesStock)) ? $this->setSizesStock() : null;
        return $this->sizesStock;
    }

    /**
     * Getter for the product's sizes
     * @return string[] product's sizes [index => size]
     */
    private function getSizesStockKeys()
    {
        $sizesStock = $this->getSizeStock();
        return array_keys($this->sizesStock);
    }

    /**
     * Getter for the product's selected size
     * @return Size product's selected size
     */
    public function getSelectedSize()
    {
        return $this->selectedSize;
    }

    /**
     * Builds a map that use size name as key and value
     * + [size => size]
     * @return string[] map that use size name as key and value
     */
    public function getSizeValueToValue()
    {
        $sizes = $this->getSizesStockKeys();
        return $this->arrayToMap($sizes);
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
     */
    public function getDescription()
    {
        $language = $this->getLanguage();
        (!isset($this->description)) ? $this->setDescriptions($language) : null;
        return $this->description;
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
     * Getter for product's prrice
     * @return Price product's prrice
     * + for boxProduct will return Price with a zero as value
     */
    public abstract function getPrice();

    /**
     * To get cuts available
     * @return string[] cuts available
     */
    public function getCutsValueToValue()
    {
        $tab = $this->getTableValues("cuts");
        $cuts = array_keys($tab);
        return $this->arrayToMap($cuts);
    }

    /**
     * Build a HTML displayable price
     * @return string[] product's HTML displayable price
     */
    public abstract function getDisplayablePrice();

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
     * @param Size $sizeObj
     * @param string $size to check if stock is available
     * @param string $brand
     * @param Measure $measure user's measurement
     * @return boolean true if the stock is available
     */
    // public abstract function stillStock($size, $brand, Measure $measure);
    public abstract function stillStock(Size $sizeObj);

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
}
