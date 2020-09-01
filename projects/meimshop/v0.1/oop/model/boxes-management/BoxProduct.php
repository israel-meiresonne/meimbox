<?php

class BoxProduct extends Product
{
    /**
     * All color present in the array is the color available for the box 
     * product and the boolean value indicate if it the color of the box 
     * that content the product
     * $colors = [box_color => boolean]
     * @var boolean[] $colors Set true if the color is the same than the current box else false
     */
    private $colors;

    /**
     * List of physical size available for the boxproduct and its stock. 
     * NONTE: Use the size name as access key and array return the stock available
     * like $boxProdStock[size_name] => int
     * @var int[] $boxProdStock[size_name] 
     */
    protected $boxProdStock;

    /** 
     * Holds the sell prices of each box color for each country and currency
     * $boxesPrices = [                                        
     *     boxColor => [
     *          "boxDatas" => [
     *              "sizeMax" => int,
     *              "boxColorRGB" => string,
     *              "priceRGB" => string,
     *              "textualRGB" => string,
     *          ]
     *          "boxesPrices" => [
     *             iso_country => [
     *                 iso_currency => Price
     *              ]
     *          ]
     *      ]
     * ]
     * @var string[string[string[Price]]] In format $boxesPrices[boxColor][iso_country][iso_currency]
     */
    protected $boxesPrices;

    /**
     * Product type to know where to put it
     * @var string Product witch can be puted only into a box
     */
    const BOX_TYPE = "boxproduct";


    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 2:
                self::__construct3($argv[0], $argv[1]);
                break;
        }
    }

    protected function __construct0()
    {
    }

    protected function __construct3($prodID, $dbMap)
    {
        parent::__construct($prodID, self::BOX_TYPE, $dbMap);
        // self::$PRICE_MESSAGE = $dbMap["constantMap"][self::$PRICE_MESSAGE]["stringValue"];
        $product = $dbMap["productMap"][self::BOX_TYPE][$prodID];

        $this->colors = $product["datas"]["box_color"];
        $this->boxProdStock = $product["boxProdSizes"];
        // $this->setDate = $product["datas"]["size_name"][$prodSize];
        self::initBoxesPrices($dbMap);
    }

    /**
     * Set the boxes prices map
     * @param string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     * @return string[string[string[Price]]] In format $prices[boxColor][iso_country][iso_currency]
     */
    private function initBoxesPrices($dbMap){
        $boxMap = $dbMap["boxMap"];
        $boxesPrices = [];
        foreach($boxMap["boxesProperties"] as $boxColor => $datas){
            $boxesPrices[$boxColor]["boxDatas"]["sizeMax"] = $datas["boxDatas"]["sizeMax"];
            $boxesPrices[$boxColor]["boxDatas"]["boxColorRGB"] = $datas["boxDatas"]["boxColorRGB"];
            $boxesPrices[$boxColor]["boxDatas"]["priceRGB"] = $datas["boxDatas"]["priceRGB"];
            $boxesPrices[$boxColor]["boxDatas"]["textualRGB"] = $datas["boxDatas"]["textualRGB"];
            $boxesPrices[$boxColor]["boxesPrices"] = GeneralCode::initPrices($datas["prices"], $dbMap);
        }
        $this->boxesPrices = $boxesPrices;
    }

    /**
     * Getter of $BOX_TYPE
     * @return string the type of the product
     */
    public function getType()
    {
        return self::BOX_TYPE;
    }

    // /**
    //  * Getter of $BOX_TYPE
    //  * @return string the type of the product
    //  */
    // public static function __getType()
    // {
    //     return self::BOX_TYPE;
    // }

    /**
     * Getter message to display in product's price space
     * @param Country $country The current Country of the Visitor
     * @param Currency $currency The current Currency of the Visitor
     * @return string[...string[Price[]]]
     *  return  => [
     *      price*100 => [
     *          "boxColor" => string,
     *          "sizeMax" => int,
     *          "boxColorRGB" => string,
     *          "priceRGB" => string,
     *          "textualRGB" => string,
     *          "price" => Price([price÷sizeMax], Country);
     *     ]
     * NOTE: the access keys [price*100] are ordered from lower to higher
     */
    public function getBoxesPrices($country, $currency)
    {
        // return self::$PRICE_MESSAGE;
        $prices = [];
        foreach($this->boxesPrices as $boxColor => $datas){
            $iso_country = $country->getIsoCountry();
            $iso_currency = $currency->getIsoCurrency();
            $boxPriceObj = $datas["boxesPrices"][$iso_country][$iso_currency]->getCopy();
            $boxPriceVal = $boxPriceObj->getPrice();
            
            $priceKey = number_format($boxPriceVal*100, 2, "", "");
            $prodPrice = $boxPriceVal/$datas["boxDatas"]["sizeMax"];
            $prodPriceObj = new Price($prodPrice, $currency);
            
            $prices[$priceKey]["boxColor"] = $boxColor;
            $prices[$priceKey]["sizeMax"] = $datas["boxDatas"]["sizeMax"];
            $prices[$priceKey]["boxColorRGB"] = $datas["boxDatas"]["boxColorRGB"];
            $prices[$priceKey]["priceRGB"] = $datas["boxDatas"]["priceRGB"];
            $prices[$priceKey]["textualRGB"] = $datas["boxDatas"]["textualRGB"];
            $prices[$priceKey]["price"] = $prodPriceObj;
        }
        ksort($prices);
        return $prices;
    }

    /**
     * To get a protected copy of a BoxProduct instance
     * @return BoxProduct a protected copy of the BoxProduct instance
     */
    public function getCopy()
    {
        $copy = new BoxProduct();

        // Product attributs
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

        // BoxProduct attributs
        $copy->colors = $this->colors;
        $copy->boxProdStock = $this->boxProdStock;
        $copy->setDate = $this->setDate;
        $copy->boxesPrices = GeneralCode::cloneMap($this->boxesPrices);
        // $copy->BOX_TYPE = self::BOX_TYPE;
        // $copy->PRICE_MESSAGE = self::$PRICE_MESSAGE;

        return $copy;
    }

    /**
     * Check if the product is a basket product
     * @return boolean true if the product is a basket product else false
     */
    public function isBasketProduct()
    {
        return false;
    }

    public function __toString()
    {
        parent::__toString();
        Helper::printLabelValue("colors", $this->colors);
        Helper::printLabelValue("boxProdStock", $this->boxProdStock);
        // Helper::printLabelValue("setDate", $this->setDate);
    }
}
