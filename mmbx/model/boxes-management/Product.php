<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Size.php';
require_once 'model/tools-management/Language.php';

abstract class Product extends ModelFunctionality
{
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
    protected $size;

    /**
     * Holds the purchase price of the product
     * @var Price
     */
    protected $buyPrice;

    /**
     * Holds the access key for content of the grid product
     */
    public const GRID_CONTENT_KEY = "grid_content";

    /**
     * Holds the access key for stickers of the grid product
     */
    public const GRID_STICKERS_KEY = "grid_stickers";

    /**
     * Constructor 
     * @param int $prodID product's id
     */
    protected function __construct(int $prodID)
    {
        $this->prodID = $prodID;
        if ($this->existProduct($prodID)) {
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
                throw new Exception("No product has this identifier $prodID");
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
     * To set all other properties that nat in Product table
     * @param Language $lang Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currency
     */
    public abstract function CompleteProperties($lang, $country, $currency);

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
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $this->sizesStock[$tabLine["size_name"]] = $tabLine["stock"];
            }
        }
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
     * @param Language $lang Visitor's language
     */
    protected function setDescriptions($lang)
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

    /**
     * Set product's selected size by creating a Size object and set its 
     * quantity.
     * @param string $size the size value
     * @param string $brand the brand name
     * @param string $cut the cut value
     * @param int $brand total number of product
     * @param string $setDate date of add of this product to basket or box
     * @param Measure $measure Visitor's measure
     */
    public function setSize($size, $brand, $cut, $quantity, $setDate, $measure)
    {
        $this->size = new Size($size, $brand, $cut, $quantity, $setDate, $measure);
    }

    /**
     * Getter for the product's id
     * @return string the id of the product
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
     * Getter for the product's pictures list
     * @return string[] product's pictures list
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Getter for the product's sizes
     * @return string[] product's size [index => size]
     */
    public function getSizes()
    {
        return array_keys($this->sizesStock);
    }

    /**
     * Getter of product's collection name
     * @return string[] product's collection name (without date data)
     */
    public function getCollections()
    {
        return array_keys($this->collections);
    }

    /**
     * Getter of product's function name
     * @return string[] product's function name
     */
    public function getFunctions()
    {
        return $this->prodFunctions;
    }

    /**
     * Getter of product's categories name
     * @return string[] product's categories name
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Getter for product's description into language asked
     * @param $isoLang
     */
    public function getDescription($isoLang)
    {
        return (!empty($this->descriptions[$isoLang])) ? $this->descriptions[$isoLang]
            : $this->descriptions[Language::__getDEFAULT_LANGUAGE()];
    }

    /**
     * Getter for sameProducts
     * @return string a prodtected copy of sameProducts
     */
    public function getSameNameProd()
    {
        return GeneralCode::cloneMap($this->sameProducts);
    }

    // /**
    //  * To get a protected copy of a BasketProduct instance
    //  * @return Product a protected copy of the BasketProduct instance
    //  */
    // public function getCopy()
    // {
    //     $copy = new Product();
    //     $copy->prodID = $this->prodID;
    //     $copy->prodName = $this->prodName;
    //     $copy->isAvailable = $this->isAvailable;
    //     $copy->addedDate = $this->addedDate;
    //     $copy->colorName = $this->colorName;
    //     $copy->colorRGB = $this->colorRGB;
    //     $copy->buyPrice = (!empty($this->buyPrice)) ? $this->buyPrice->getCopy() : null;
    //     $copy->weight = $this->weight;
    //     $copy->pictures = $this->pictures;
    //     $copy->sizesStock = $this->sizesStock;
    //     $copy->prodMeasures = GeneralCode::cloneMap($this->prodMeasures);
    //     $copy->size = (!empty($this->size)) ? $this->size->getCopy() : null;
    //     $copy->collections = $this->collections;
    //     $copy->prodFunctions = $this->prodFunctions;
    //     $copy->categories = $this->categories;
    //     $copy->descriptions = $this->descriptions;
    //     $copy->sameProducts = GeneralCode::cloneMap($this->sameProducts);
    //     return $copy;
    // }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->size->getSetDate());
    }

    /**
     * Check if a value given in param is inside the collection list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function collectionIsInside($value)
    {
        return array_key_exists($value, $this->collections);
    }
    /**
     * Check if a value given in param is inside the prodFunctions list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function functionIsInside($value)
    {
        return in_array($value, $this->prodFunctions);
    }
    /**
     * Check if a value given in param is inside the categories list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function categoryIsInside($value)
    {
        return in_array($value, $this->categories);
    }
    /**
     * Check if a value given in param is inside the size list
     * @param string $value the value to chcek if it inside the list
     * @return true if the value is inside the list else false
     */
    public function sizeIsInside($value)
    {
        return array_key_exists($value, $this->sizesStock);
    }

    // public function __toString()
    // {
    //     Helper::printLabelValue('prodID', $this->prodID);
    //     Helper::printLabelValue('prodName', $this->prodName);
    //     Helper::printLabelValue('isAvailable', $this->isAvailable);
    //     Helper::printLabelValue('addedDate', $this->addedDate);
    //     Helper::printLabelValue('colorName', $this->colorName);
    //     Helper::printLabelValue('colorRGB', $this->colorRGB);
    //     Helper::printLabelValue('buyPrice', $this->buyPrice);
    //     Helper::printLabelValue('weight', $this->weight);
    //     Helper::printLabelValue('pictures', $this->pictures);
    //     Helper::printLabelValue('sizesStock', $this->sizesStock);
    //     Helper::printLabelValue('prodMeasures', $this->prodMeasures);
    //     Helper::printLabelValue('size', $this->size);
    //     Helper::printLabelValue('collections', $this->collections);
    //     Helper::printLabelValue('prodFunctions', $this->prodFunctions);
    //     Helper::printLabelValue('categories', $this->categories);
    //     Helper::printLabelValue('descriptions', $this->descriptions);
    //     Helper::printLabelValue('sameProducts', $this->sameProducts);
    // }
}
