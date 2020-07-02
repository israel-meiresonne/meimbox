<?php

class Product
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
     * Holds the purchase price of the product
     * @var Price
     */
    protected $buyPrice;

    /**
     * Holds the weight of the product
     * @var double
     */
    protected $weight;

    /**
     * List of prictures of the product.
     * Use the pictureID as access key like 
     * @var string[] $pictures like $pictures = [pictureID => picture]
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
     * Holds the product's measures for each size and body part
     *  $prodMeasures => [
     *      size_name => [
     *          body_part => Measure()
     *      ]
     *  ]
     * @var string[string[Measure]]
     */
    protected $prodMeasures;

    /**
     * Holds the selected Size for this product.
     * @var Size
     */
    protected $size;

    /**
     * List of collections
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
     * List of Description in each web site supported language.
     * $descriptions = [isoLanguage => description]
     * @var string[]
     */
    protected $descriptions;

    /**
     * List of products sharing the same name than the current product. NOTE: There are
     * sorted in ascending order of their prodID and use it as access key.
     * @var Product[]
     */
    protected $sameNameProducts;

    /**
     * Holds the access key for content of the grid product
     */
    const GRID_CONTENT_KEY = "grid_content";
    
    /**
     * Holds the access key for stickers of the grid product
     */
    const GRID_STICKERS_KEY = "grid_stickers";


    protected function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 3:
                self::__construct4($argv[0], $argv[1], $argv[2]);
                break;
        }
    }

    protected function __construct0()
    {
    }

    /**
     * Constructor
     * @param int $prodID id of the product
     * @param string $prodSize size of the product if it holded by a Visitor 
     * else null
     * @param string $prodType type of the product
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    // protected function __construct4($prodID, $prodSize, $prodType, $dbMap) // remove prodSize from all reférence to this constructor
    protected function __construct4($prodID, $prodType, $dbMap) // remove prodSize from all reférence to this constructor
    {
        $product = $dbMap["productMap"][$prodType][$prodID];
        $this->prodID = $prodID;
        $this->prodName = $product["datas"]["prodName"];
        $this->isAvailable = $product["datas"]["isAvailable"];
        $this->addedDate = $product["datas"]["addedDate"];
        $this->colorName = $product["datas"]["colorName"];
        $this->colorRGB = $product["datas"]["colorRGB"];

        $price = $dbMap["productMap"][$prodType][$prodID]["datas"]["buyPriceDatas"]["buyPrice"];
        $countryName = $dbMap["productMap"][$prodType][$prodID]["datas"]["buyPriceDatas"]["buy_country"];
        $isoCurrency = $dbMap["productMap"][$prodType][$prodID]["datas"]["buyPriceDatas"]["iso_currency"];
        $this->buyPrice = new Price($price, $countryName, $isoCurrency, $dbMap);

        $this->weight = $product["datas"]["weight"];
        // $this->quantity = $product["datas"]["quantity"]; //

        $this->pictures = $product["pictures"];
        ksort($this->pictures);
        $this->sizesStock = $product["sizes"];
        // $this->sizesStock[$prodSize]["selected"] = true; //

        $this->collections = $product["collections"];
        $this->prodFunctions = $product["functions"];
        $this->categories = $product["categories"];
        $this->descriptions = $product["descriptions"];
        self::setSameNameProd($prodID, $prodType, $dbMap);
    }

    /**
     * Fill the same product list with product sharing the same name that the 
     * current product.
     * @param int $prodID id of the product
     * @param string $prodType type of the product
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    private function setSameNameProd($prodID, $prodType, $dbMap)
    {
        $this->sameNameProducts = [];
        foreach ($dbMap["productMap"][$prodType][$prodID]["datas"]["sameNameProd"] as $id => $datas) {
            $sameNameProduct = new Product();
            $sameNameProduct->prodID = $id;
            $sameNameProduct->prodName = $datas["prodName"];
            $sameNameProduct->colorName = $datas["colorName"];
            $sameNameProduct->colorRGB = $datas["colorRGB"];
            $this->buyPrice = new Price();
            $this->sameNameProducts[$id] = $sameNameProduct;
        }
        ksort($this->sameNameProducts);
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
    public function getCollections(){
        return array_keys($this->collections);
    }

    /**
     * Getter of product's function name
     * @return string[] product's function name
     */
    public function getFunctions(){
        return $this->prodFunctions;
    }
    
    /**
     * Getter of product's categories name
     * @return string[] product's categories name
     */
    public function getCategories(){
        return $this->categories;
    }

    /**
     * Getter for product's description into language asked
     * @param $isoLang
     */
    public function getDescription($isoLang){
        return (!empty($this->descriptions[$isoLang])) ? $this->descriptions[$isoLang] 
        : $this->descriptions[Language::__getDEFAULT_LANGUAGE()];
    }

    /**
     * Getter for sameNameProducts
     * @return string a prodtected copy of sameNameProducts
     */
    public function getSameNameProd()
    {
        return GeneralCode::cloneMap($this->sameNameProducts);
    }

    /**
     * To get a protected copy of a BasketProduct instance
     * @return Product a protected copy of the BasketProduct instance
     */
    public function getCopy()
    {
        $copy = new Product();
        $copy->prodID = $this->prodID;
        $copy->prodName = $this->prodName;
        $copy->isAvailable = $this->isAvailable;
        $copy->addedDate = $this->addedDate;
        $copy->colorName = $this->colorName;
        $copy->colorRGB = $this->colorRGB;
        $copy->buyPrice = (!empty($this->buyPrice)) ? $this->buyPrice->getCopy() : null;
        $copy->weight = $this->weight;
        $copy->pictures = $this->pictures;
        $copy->sizesStock = $this->sizesStock;
        $copy->prodMeasures = GeneralCode::cloneMap($this->prodMeasures);
        $copy->size = (!empty($this->size)) ? $this->size->getCopy() : null;
        $copy->collections = $this->collections;
        $copy->prodFunctions = $this->prodFunctions;
        $copy->categories = $this->categories;
        $copy->descriptions = $this->descriptions;
        $copy->sameNameProducts = GeneralCode::cloneMap($this->sameNameProducts);
        return $copy;
    }

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

    public function __toString()
    {
        Helper::printLabelValue('prodID', $this->prodID);
        Helper::printLabelValue('prodName', $this->prodName);
        Helper::printLabelValue('isAvailable', $this->isAvailable);
        Helper::printLabelValue('addedDate', $this->addedDate);
        Helper::printLabelValue('colorName', $this->colorName);
        Helper::printLabelValue('colorRGB', $this->colorRGB);
        Helper::printLabelValue('buyPrice', $this->buyPrice);
        Helper::printLabelValue('weight', $this->weight);
        Helper::printLabelValue('pictures', $this->pictures);
        Helper::printLabelValue('sizesStock', $this->sizesStock);
        Helper::printLabelValue('prodMeasures', $this->prodMeasures);
        Helper::printLabelValue('size', $this->size);
        Helper::printLabelValue('collections', $this->collections);
        Helper::printLabelValue('prodFunctions', $this->prodFunctions);
        Helper::printLabelValue('categories', $this->categories);
        Helper::printLabelValue('descriptions', $this->descriptions);
        Helper::printLabelValue('sameNameProducts', $this->sameNameProducts);
    }
}
