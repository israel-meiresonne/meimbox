<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/BoxProduct.php';
require_once 'model/boxes-management/Price.php';
require_once 'model/boxes-management/Shipping.php';
require_once 'model/boxes-management/Discount.php';

class Box extends ModelFunctionality
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
     * Holds box's advantageous sell argument
     * @var string[]
     */
    private $advantages;

    /**
     * Holds box's disadvantageous sell argument
     * @var string[]
     */
    private $drawbacks;

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
     * Access key for attribut boxID in ajax
     * @var string
     */
    public const KEY_BOX_ID = "boxid";

    /**
     * Second access key for attribut boxID in ajax
     * + whend 2 boxid is given
     * @var string
     */
    public const KEY_NEW_BOX_ID = "newboxid";

    /**
     * Access key for attribut boxColor in ajax
     * @var string
     */
    public const KEY_BOX_COLOR = "boxcolor";

    /**
     * To get box manager configured to add new product in box
     * + change instruction and sumbit button
     * @var string
     */
    public const CONF_ADD_BXPROD = "addBoxProduct";

    /**
     * To get box manager configured to move product to a other box
     * + change instruction and sumbit button
     * @var string
     */
    public const CONF_MV_BXPROD = "moveBoxProduct";


    /**
     * Constructor
     * + __construct3($boxColor, Country $country, Currency $currency)
     * + __construct5($boxID, $userID, Country $country, Currency $currency)
     */
    public function __construct()
    {
        // $this->boxProducts;
        $args = func_get_args();
        switch (func_num_args()) {
            case 4:
                $this->__construct4($args[0], $args[1], $args[2], $args[3]);
                break;

            case 5:
                $this->__construct5($args[0], $args[1], $args[2], $args[3], $args[4]);
                break;
        }
    }

    /**
     * Construct a brand new box with the box color given
     * @param string $boxColor box's color
     * @param Language $language Visitor's language
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function __construct4($boxColor, Language $language, Country $country, Currency $currency)
    {
        if (empty($boxColor)) {
            throw new Exception("Box's color can't be empty");
        }
        // switch ($boxColor) {
        //     case self::GOLD:
        //         $this->color = self::GOLD;
        //         break;
        //     case self::SILVER:
        //         $this->color = self::SILVER;
        //         break;
        //     case self::REGULAR:
        //         $this->color = self::REGULAR;
        //         break;

        //     default:
        //         throw new Exception("This box color ('$boxColor') is not supported");
        //         break;
        // }
        $boxMap = $this->getBoxMap($country, $currency);
        if (!key_exists($boxColor, $boxMap)) {
            throw new Exception("The box color '$boxColor' is not supported");
        }
        $this->language = $language;
        $this->country = $country;
        $this->currency = $currency;

        $this->boxID = $this->generateDateCode(self::ID_LENGTH);
        $this->color = $boxColor;
        $this->setDate = $this->getDateTime();

        $this->sizeMax = $boxMap[$boxColor]["sizeMax"];
        $this->weight = $boxMap[$boxColor]["weight"];
        $this->picture = $boxMap[$boxColor]["boxPicture"];
        $this->stock = $boxMap[$boxColor]["stock"];
        $this->price = new Price($boxMap[$boxColor]["price"], $currency);
        $this->shipping = new Shipping($boxMap[$boxColor]["shipping"]["shipPrice"], $currency, $boxMap[$boxColor]["shipping"]["time"]);
        if (!empty($boxMap[$boxColor]["discount"]["value"])) {
            $this->discount = new Discount($boxMap[$boxColor]["discount"]["value"], $boxMap[$boxColor]["discount"]["beginDate"], $boxMap[$boxColor]["discount"]["endDate"]);
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
        $this->language = $language;
        $this->country = $country;
        $this->currency = $currency;
        $countryName = $this->country->getCountryName();
        $isocurrency = $this->currency->getIsoCurrency();
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
        // $this->setBoxProducts($this->boxID);
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
     */
    private function setBoxProducts()
    {
        $this->boxProducts = [];
        $boxID = $this->getBoxID();
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $sql = "SELECT * FROM `Box-Products` WHERE boxID = '$boxID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BoxProduct($tabLine["prodId"], $language, $country, $currency);
                $size = new Size($tabLine["sequenceID"], $tabLine["setDate"]);
                $quantity = (int) $tabLine["quantity"];
                $size->setQuantity($quantity);
                $product->selecteSize($size);
                $key = $product->getDateInSec();
                $this->boxProducts[$key] = $product;
            }
            krsort($this->boxProducts);
        }
    }

    /**
     * Initialize box's sell arguments ($advantages & $drawbacks)
     */
    private function setArguments()
    {
        $boxColor = $this->getColor();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $arguments = $this->getBoxArguments($boxColor, $country, $currency);
        $this->advantages = $arguments["advantage"];
        $this->drawbacks = $arguments["drawback"];
    }


    /**
     * Getter for box's Language 
     * + the same instance that Visitor
     * @return Language box's Language
     */
    private function getLanguage()
    {
        return $this->language;
    }

    /**
     * Getter for box's Country 
     * + the same instance that Visitor
     * @return Country box's Country
     */
    private function getCountry()
    {
        return $this->country;
    }

    /**
     * Getter for box's Currency 
     * + the same instance that Visitor
     * @return Currency box's Currency
     */
    private function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Getter for box's id
     * @return string box's id
     */
    public function getBoxID()
    {
        return $this->boxID;
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
     * To encript box's color
     * @return int box's encripted color value
     */
    public function getColorCode()
    {
        return $this->encryptString($this->getColor());
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
     * To get space available in the box
     * @return int space available in the box
     */
    public function getSpace()
    {
        $space = ($this->getSizeMax() - $this->getNbProduct());
        if ($space < 0) {
            throw new Exception("Stilling place in box can't be negative");
        }
        return $space;
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
     * Getter for box's set date
     * @return int box's set date
     */
    public function getSetDate()
    {
        return $this->setDate;
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
     * To get box's advantageous sell arguments
     * @return string[] box's advantageous sell arguments
     */
    public function getAdvantages()
    {
        (!isset($this->advantages)) ? $this->setArguments() : null;
        return $this->advantages;
    }

    /**
     * To get box's disadvantageous sell arguments
     * @return string[] box's disadvantageous sell arguments
     */
    public function getDrawbacks()
    {
        (!isset($this->drawbacks)) ? $this->setArguments() : null;
        return $this->drawbacks;
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
    public function getPriceFormated()
    {
        return $this->price->getFormated();
    }

    /**
     * To calculate the price per ittem
     * @return string the price per ittem
     */
    public function getPricePerItem()
    {
        $price = $this->getPrice();
        $perItemVal = ($price->getPrice() / $this->getSizeMax());
        $perItem = new Price($perItemVal, $price->getCurrency());
        return $perItem->getFormated();
    }

    /**
     * Getter for box's products
     * @return BoxProduct[] box's products
     */
    public function getBoxProducts()
    {
        (!isset($this->boxProducts)) ? $this->setBoxProducts() : null;
        return $this->boxProducts;
    }

    /**
     * To get a box's product following it's size
     * @return BoxProduct box's product
     */
    public function getProduct($prodID, Size $selectedSize)
    {
        $products = $this->getBoxProducts();
        foreach ($products as $key => $product) {
            $selectedSize2 = $product->getSelectedSize();
            $exist = (($product->getProdID() == $prodID)
                && (Size::equals($selectedSize, $selectedSize2)));
            if ($exist) {
                return $products[$key];
            }
        }
        return null;
    }

    // /**
    //  * To check if exist a product in the box with the id and size given in param
    //  * @param string $prodID id of the product to add in box
    //  * @param Size $sizeObj1 submited size for product
    //  * @return boolean true if the product exist in the box else false
    //  */
    // private function existProduct($prodID, Size $selectedSize1)
    // {
    //     $exist = false;
    //     $products = $this->getBoxProducts();
    //     foreach ($products as $product) {
    //         $selectedSize2 = $product->getSelectedSize();
    //         $exist = (($product->getProdID() == $prodID)
    //             && (Size::equals($selectedSize1, $selectedSize2)));
    //         if ($exist) {
    //             break;
    //         }
    //     }
    //     return $exist;
    // }

    /**
     * To get the amount of product in the box
     * @return int amount of product in the box
     */
    public function getNbProduct()
    {
        $products = $this->getBoxProducts();
        $nb = 0;
        if (count($products) > 0) {
            foreach ($products as $product) {
                $nb += $product->getQuantity();
            }
        }
        return $nb;
    }

    /**
     * To get one box in each color supported ordered by price 
     * from lower to highest
     * @param Language $language Visitor's language
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     * @return Boxe[] boxes supported ordered by price from lower to bigger
     */
    public static function getSamples(Language $language, Country $country, Currency $currency)
    {
        $boxMap = parent::getBoxMap($country, $currency);
        $boxes = [];
        foreach ($boxMap as $boxColor => $datas) {
            $box = new Box($boxColor, $language, $country, $currency);
            $key = $box->getPrice()->getPriceKey();
            $boxes[$key] = $box;
        }
        ksort($boxes);
        return $boxes;
    }

    /**
     * To add new product in box
     * + also add product in db
     * @param Response $response where to strore results
     * @param string $prodID id of the product to add in box
     * @param Size $selectedSize submited size for product
     * @param int $quantity quantity of product to add
     */
    public function addProduct($response, $prodID, Size $selectedSize)//, int $quantity = null)
    {
        $boxID = $this->getBoxID();
        $product = $this->getProduct($prodID, $selectedSize);
        if (!empty($product)) {
            // (!empty($quantity)) ? $product->addQuantity($quantity) : $product->addQuantity();;
            $quantity = $selectedSize->getQuantity();
            $product->addQuantity($quantity);
            $product->updateProduct($response, $boxID);
        } else {
            $language = $this->getLanguage();
            $country = $this->getCountry();
            $currency = $this->getCurrency();
            $product = new BoxProduct($prodID, $language, $country, $currency);
            $product->selecteSize($selectedSize);
            $product->insertProduct($response, $boxID);
        }
        if (!$response->containError()) {
            $key = $product->getDateInSec();
            $this->boxProducts[$key] = $product;
            krsort($this->boxProducts);
        }
    }

    /**
     * To update a box product
     * @param Response $response where to strore results
     * @param string $prodID id of the product to add in box
     * @param Size $holdsSize product's holds Size
     * @param Size $newSize product's new Size
     */
    public function updateProduct(Response $response, $prodID, Size $holdsSize, Size $newSize)
    {
        $boxID = $this->getBoxID();
        $product = $this->getProduct($prodID, $holdsSize);
        $product->selecteSize($newSize);
        $product->updateProduct($response, $boxID, $holdsSize);
    }

    /**
     * To delete a product from a box
     * @param Response $response where to strore results
     * @param string $prodID id of the product to delete from box
     * @param Size $selectedSize size of the product to delete
     */
    public function deleteBoxProduct(Response $response, $prodID, Size $selectedSize)
    {
        $product = $this->getProduct($prodID, $selectedSize);
        if(empty($product)){
            throw new Exception("This product don't exist");
        }
        $boxID = $this->getBoxID();
        $product->deleteProduct($response, $boxID);
        if(!$response->containError()){
            $key = $product->getDateInSec();
            $this->boxProducts[$key] = null;
            unset($this->boxProducts[$key]);
        }
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/
    /**
     * Insert box in the db like a new box
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     * @param string $userID Visitor's id
     */
    public function insertBox(Response $response, $userID)
    {
        $bracket = "(?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Boxes`(`boxID`, `box_color`, `setDate`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push($values, $this->getBoxID());
        array_push($values, $this->getColor());
        array_push($values, $this->getSetDate());
        $this->insert($response, $sql, $values);
        if (!$response->containError()) {
            $bracket = "(?,?)"; // regex \[value-[0-9]*\]
            $sql = "INSERT INTO `Baskets-Box`(`userId`, `boxId`)
                VALUES " . $this->buildBracketInsert(1, $bracket);
            $values = [];
            array_push($values, $userID);
            array_push($values, $this->getBoxID());
            $this->insert($response, $sql, $values);
        }
    }

    /**
     * To delete all product inside the box
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     */
    public function emptyBox(Response $response)
    {
        $boxID = $this->getBoxID();
        $sql = "DELETE FROM `Box-Products` WHERE `Box-Products`.`boxId` = '$boxID'";
        $this->delete($response, $sql);
        if (!$response->containError()) {
            $this->setBoxProducts();
        }
    }

    /**
     * To delete box from db
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     */
    public function deleteBox(Response $response)
    {
        $boxID = $this->getBoxID();
        $sql = "DELETE FROM `Baskets-Box` WHERE `Baskets-Box`.`boxId` = '$boxID';";
        $this->delete($response, $sql);
    }
}
