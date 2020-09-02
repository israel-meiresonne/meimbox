<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/BoxProduct.php';
require_once 'model/boxes-management/Price.php';
require_once 'model/boxes-management/Shipping.php';
require_once 'model/boxes-management/Discount.php';

class Box extends ModelFunctionality
{
    /**
     * Sequence of letter and number created with the date in forma DATETIME+ms
     * @var string
     */
    private $boxID;

    /**
     * Box Color get from Database
     * @var string
     */
    private $color;

    /**
     * The maximum number of boxProduct that this box can contain 
     * @var int
     */
    private $sizeMax;

    /**
     * @var double
     */
    private $weight;

    /**
     * Holds the picture of the box
     * @var string
     */
    private $picture;

    /**
     * Holds the number of this box stilling in stock
     * @var int
     */
    private $stock;

    /**
     * Date and hour of the creation of this box into format YYYY-MM-DD HH:MM:SS
     * @var string
     */
    private $setDate;

    /** 
     * Sell price for a given country and currency
     * @var Price
     */
    private $price;

    /**
     * Liste of BoxProduct inside the box ordered from newest to oldest
     * @var BoxProduct[] Use Unix time of the as key
     */
    private $boxProducts;

    /**
     * Shipping cost for a given country and currency
     * @var Shipping
     */
    private $shipping;

    /**
     * Discount values for a given country
     * @var Discount
     */
    private $discount;

    // /**
    //  * Holds the buying price of the box
    //  * @var Price
    //  */
    // private $buiyPrice;

    // /**
    //  * Holds de number of box bought lastely to restock
    //  * @var int
    //  */
    // private $quantity;

    /**
     * Length of the box's id
     * @var string
     */
    private const ID_LENGTH = 25;

    /**
     * Length of the box's id
     * @var string
     */
    private const PICTURE_DIR = "content/brain/permanent/";

    /**
     * Holds box's colors
     * @var int
     */
    public const GOLD = "gold";
    public const SILVER = "silver";
    public const REGULAR = "regular";


    /**
     * Constructor
     * + __construct3($boxColor, Country $country, Currency $currency)
     * + __construct5($boxID, $userID, Country $country, Currency $currency)
     */
    public function __construct()
    {
        $this->boxProducts = [];
        $args = func_get_args();
        switch (func_num_args()) {
            case 3:
                $this->__construct3($args[0], $args[1], $args[2]);
                break;

            case 5:
                $this->__construct5($args[0], $args[1], $args[2], $args[3], $args[4]);
                break;
        }
    }

    /**
     * Construct a brand new box with the box color given
     * @param string $boxColor box's color (GOLD, SILVER & REGULAR)
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function __construct3($boxColor, Country $country, Currency $currency)
    {
        if (empty($boxColor)) {
            throw new Exception("Box's color can't be empty");
        }
        switch ($boxColor) {
            case self::GOLD:
                $this->color = self::GOLD;
                break;
            case self::SILVER:
                $this->color = self::SILVER;
                break;
            case self::REGULAR:
                $this->color = self::REGULAR;
                break;

            default:
                throw new Exception("This box color ('$boxColor') is not supported");
                break;
        }
        $this->boxID = $this->generateDateCode(self::ID_LENGTH);
        $this->setDate = $this->getDateTime();
        $map = $this->getBoxMap($country, $currency);
        if (!key_exists($this->color, $map)) {
            throw new Exception("The box color '$boxColor' is not supported");
        }

        $this->sizeMax = $map["sizeMax"];
        $this->weight = $map["weight"];
        $this->picture = $map["boxPicture"];
        $this->stock = $map["stock"];
        $this->price = new Price($map["price"], $currency);
        $this->shipping = new Shipping($map["shipping"]["shipPrice"], $currency, $map["shipping"]["time"]);
        if (!empty($map["discount"]["value"])) {
            $this->discount = new Discount($map["discount"]["value"], $map["discount"]["beginDate"], $map["discount"]["endDate"]);
        }
    }

    /**
     * Construct box using db's datas
     * @param string $boxID box's id
     * @param string $userID user's id
     * @param Language $language Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current Currency
     */
    private function __construct5($boxID, $userID, Language $language, Country $country, Currency $currency)
    {
        if (empty($boxID)) {
            throw new Exception("Param '\$boxID' can't be empty");
        }
        if (empty($userID)) {
            throw new Exception("Param '\$userID' can't be empty");
        }
        $countryName = $country->getCountryName();
        $isocurrency = $currency->getIsoCurrency();
        $sql = "SELECT * 
            FROM `Boxes` b
            JOIN `Baskets-Box` bb ON b.boxID = bb.boxId
            JOIN `BoxColors` bc ON b.box_color = bc.boxColor
            JOIN `BoxPrices` bp ON bc.boxColor  = bp.box_color
            JOIN `BoxShipping` bs ON bc.boxColor  = bs.box_color
            JOIN `BoxDiscounts` bd ON bc.boxColor  = bd.box_color
            WHERE (b.boxID = '$boxID' AND bb.userId = '$userID') 
            AND (bp.country_ = '$countryName' AND bp.iso_currency = '$isocurrency' 
            AND bs.country_ = '$countryName' AND bs.iso_currency = '$isocurrency'
            AND bd.country_ = '$countryName')";
        $tab = $this->select($sql);
        if (count($tab)  != 1) {
            throw new Exception("Impossible to get box's data from db");
        }
        $tabLine = $tab[0];
        $this->boxID = $tabLine["boxID"];
        $this->color = $tabLine["box_color"];
        $this->setDate = $tabLine["setDate"];
        $this->sizeMax = (int) $tabLine["sizeMax"];
        $this->weight = (float) $tabLine["weight"];
        $this->picture = $tabLine["boxPicture"];
        $this->stock = (int) $tabLine["stock"];
        $price = (float) $tabLine["price"];
        $this->price = new Price($price, $currency);

        $shipPrice = (float) $tabLine["shipPrice"];
        $time = (int) $tabLine["time"];
        $this->shipping = new Shipping($shipPrice, $currency, $time);

        if (!empty($tabLine["discount_value"])) {
            $value = $tabLine["discount_value"];
            $this->discount = new Discount($value, $tabLine["beginDate"], $tabLine["endDate"]);
        }
        $this->setBoxProducts($this->boxID, $language, $country, $currency);
    }
    /*
    SELECT * 
        FROM `Boxes` b
        JOIN `Baskets-Box` bb ON b.boxID = bb.boxId
        JOIN `BoxColors` bc ON b.box_color = bc.boxColor
        JOIN `BoxPrices` bp ON bc.boxColor  = bp.box_color
        JOIN `BoxShipping` bs ON bc.boxColor  = bs.box_color
        JOIN `BoxDiscounts` bd ON bc.boxColor  = bd.box_color
        WHERE (b.boxID = 'bx0987654321' AND bb.userId = '651853948') 
        AND (bp.country_ = 'belgium' AND bp.iso_currency = 'eur' 
        AND bs.country_ = 'belgium' AND bs.iso_currency = 'eur'
        AND bd.country_ = 'belgium')
    */

    /**
     * Set box's boxproduct
     * + get products from db
     * @param string $boxID box's id
     * @param Language $language Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current Currency
     */
    private function setBoxProducts($boxID, Language $language, Country $country, Currency $currency)
    {
        $sql = "SELECT * FROM `Box-Products` WHERE boxID = '$boxID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BoxProduct($tabLine["prodId"], $language, $country, $currency);
                $size = new Size($tabLine["sequenceID"], $tabLine["setDate"], $tabLine["cut_name"]);
                $product->setSelectedSize($size);
                $quantity = (int) $tabLine["quantity"];
                $product->setQuantity($quantity);
                $key = $product->getDateInSec();
                $this->boxProducts[$key] = $product;
            }
            krsort($this->boxProducts);
        }
    }

    /**
     * Getter for box's color
     * @return string box's color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Getter for box's max amount of product he can contain
     * @return int box's max amount of product he can contain
     */
    public function getSizeMax()
    {
        return $this->sizeMax;
    }

    /**
     * Getter for box's max amount of product he can contain
     * @return int box's max amount of product he can contain
     */
    public function getPictureSource()
    {
        return self::PICTURE_DIR . $this->picture;
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->setDate);
    }

    /**
     * Getter for box's price
     * @return Price box's price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Getter for box's price in displayable format
     * @return string box's price in displayable format
     */
    public function getFormatedPrice()
    {
        return $this->price->getFormated();
    }

    /**
     * Getter for box's products
     * @return BoxProduct[] box's products
     */
    public function getBoxProducts()
    {
        return $this->boxProducts;
    }

    /**
     * To get the amount of product in the box
     * @return int amount of product in the box
     */
    public function getNbProduct()
    {
        return count($this->boxProducts);
    }

    // /**
    //  * @param array $boxProductMap list of product with their datas
    //  * @param array $currencyMap database currencies
    //  * @param array $countryMap $countryMap database countries
    //  */
    // private function initBoxProducts($boxProductMap, $dbMap)
    // {
    //     foreach ($dbMap["boxMap"]["boxes"][$this->boxID]["boxProducts"] as $prodID => $true) {
    //         $product = $boxProductMap[$prodID];
    //         foreach ($product["datas"]["basket"] as $boxId => $sequenceIDs) {
    //             foreach ($sequenceIDs as $sequenceID => $datas) {
    //                 $boxProduct = new BoxProduct($prodID, $dbMap);
    //                 $size = $datas["size_name"];
    //                 $brand = $datas["brand_name"];
    //                 $cut = $datas["cut_name"];
    //                 $quantity = $datas["quantity"];
    //                 $setDate = $datas["setDate"];

    //                 $measureId = $datas["measureId"];
    //                 $measureDatas = $dbMap["usersMap"]["usersMeasures"][$measureId];
    //                 if (!empty($measureDatas)) {
    //                     $values["measureID"] = $measureDatas["measureID"];
    //                     $values["measure_name"] = $measureDatas["measure_name"];
    //                     $values["bust"] = $measureDatas["userBust"];
    //                     $values["arm"] = $measureDatas["userArm"];
    //                     $values["waist"] = $measureDatas["userWaist"];
    //                     $values["hip"] = $measureDatas["userHip"];
    //                     $values["inseam"] = $measureDatas["userInseam"];
    //                     $values["unit_name"] = $measureDatas["unit_name"];
    //                     $values["size"] = $measureDatas["size_name"];
    //                     $values["setDate"] = $datas["setDate"];
    //                     $measure = new Measure($values, $dbMap);
    //                 } else {
    //                     $measure = null;
    //                 }
    //                 $boxProduct->setSize($size, $brand, $cut, $quantity, $setDate, $measure);
    //                 $key = $boxProduct->getDateInSec();
    //                 $this->boxProducts[$key] = $boxProduct;
    //             }
    //         }
    //     }
    //     ksort($this->boxProducts);
    // }

    // /**
    //  * @return Shipping[[]] a protected copy of the Shippings attribute
    //  */
    // public function getCopyShippings()
    // {
    //     $copy = [];
    //     foreach ($this->shippings as $iso_country => $currencyList) {
    //         foreach ($currencyList as $iso_currency => $shipping) {
    //             $copy[$iso_country][$iso_currency] = $shipping->getCopy();
    //         }
    //     }
    //     return $copy;
    // }

    // /**
    //  * @return Price[[]] a protected copy of the Prices attribute
    //  */
    // public function getCopyPrices()
    // {
    //     $copy = [];
    //     foreach ($this->prices as $iso_country => $currencyList) {
    //         foreach ($currencyList as $iso_currency => $price) {
    //             $copy[$iso_country][$iso_currency] = $price->getCopy();
    //         }
    //     }
    //     return $copy;
    // }

    // /**
    //  * @return Price[[]] a protected copy of the NewPrices attribute
    //  */
    // public function getCopyNewPrices()
    // {
    //     $copy = [];
    //     foreach ($this->newPrices as $iso_country => $currencyList) {
    //         foreach ($currencyList as $iso_currency => $newPrice) {
    //             $copy[$iso_country][$iso_currency] = $newPrice->getCopy();
    //         }
    //     }
    //     return $copy;
    // }

    // /**
    //  * @return Discount[] a protected copy of the Discounts attribute
    //  */
    // public function getCopyDiscounts()
    // {
    //     $copy = [];
    //     foreach ($this->discounts as $setdateUnix => $discount) {
    //         $copy[$setdateUnix] = $discount->getCopy();
    //     }
    //     ksort($copy);
    //     return $copy;
    // }

    // /**
    //  * @return BoxProduct[] a protected copy of the BoxProduct attribute
    //  */
    // public function getCopyBoxProducts()
    // {
    //     $copy = [];
    //     foreach ($this->boxProducts as $setDateUnix => $boxProduct) {
    //         $copy[$setDateUnix] = $boxProduct->getCopy();
    //     }
    //     ksort($copy);
    //     return $copy;
    // }

    /**
     * To get a protected copy of a Price instance
     * @return Box a protected copy of the Price instance
     */
    // public function getCopy()
    // {
    //     $copy = new Box();
    //     $copy->boxID = $this->boxID;
    //     $copy->color = $this->color;
    //     $copy->buiyPrice = (!empty($this->buiyPrice)) ? $this->buiyPrice->getCopy() : null;
    //     $copy->quantity = $this->quantity;
    //     $copy->sizeMax = $this->sizeMax;
    //     $copy->weight = $this->weight;
    //     $copy->stock = $this->stock;
    //     $copy->setDate = $this->setDate;
    //     $copy->shippings = $this->getCopyShippings();
    //     $copy->prices = $this->getCopyPrices();
    //     $copy->newPrices = $this->getCopyNewPrices();
    //     $copy->discounts = $this->getCopyDiscounts();
    //     $copy->boxProducts = $this->getCopyBoxProducts();
    //     return $copy;
    // }


    // public function __toString()
    // {
    //     helper::printLabelValue("boxID", $this->boxID);
    //     helper::printLabelValue("color", $this->color);
    //     // $this->buiyPrice->__toString;
    //     helper::printLabelValue("quantity", $this->quantity);
    //     helper::printLabelValue("sizeMax", $this->sizeMax);
    //     helper::printLabelValue("weight", $this->weight);
    //     helper::printLabelValue("boxPicture", $this->picture);
    //     helper::printLabelValue("stock", $this->stock);
    //     helper::printLabelValue("setDate", $this->setDate);

    //     // foreach ($this->shippings as $isoCountry => $currencyList) {
    //     //     echo $isoCountry . "<br>";
    //     //     foreach ($currencyList as $isoCurrency => $shipping) {
    //     //         echo "  " . $isoCurrency . "➡️  ";
    //     //         $shipping->__toString();
    //     //     }
    //     // }

    //     // foreach ($this->prices as $isoCountry => $currencyList) {
    //     //     echo $isoCountry . "<br>";
    //     //     foreach ($currencyList as $isoCurrency => $price) {
    //     //         echo "  " . $isoCurrency . "➡️  ";
    //     //         $price->__toString();
    //     //     }
    //     // }

    // }
}
