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
     * Set of BoxProduct inside the box ordered from newest to oldest
     * @var BoxProduct[] Use Unix time of the as key
     */
    private $boxProducts;

    /** 
     * Sell price for a given country and currency
     * @var Price
     */
    private $price;

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

    /**
     * Holds Map of database's table of odered Boxes
     * + Map[boxID{string}][Map::box_color]         => {string}
     * + Map[boxID{string}][Map::sizeMax]           => {int}
     * + Map[boxID{string}][Map::weight]            => {float}
     * + Map[boxID{string}][Map::boxPicture]        => {string}
     * + Map[boxID{string}][Map::sellPrice]         => {float}
     * + Map[boxID{string}][Map::shipping]          => {float}
     * + Map[boxID{string}][Map::discount_value]    => {float}
     * + Map[boxID{string}][Map::setDate]           => {string}
     * @var Map
     */
    private static $orderedBoxesMap;

    private const PREFIX_ID = "box_";

    /**
     * Length of the box's id
     * @var string
     */
    private const ID_LENGTH = 25;

    /**
     * Length of the box's id
     * @var string
     */
    private static $PICTURE_DIR;

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
        $this->setConstant();
        $args = func_get_args();
        switch (func_num_args()) {
            case 0:
                $this->__construct0();
                break;
            case 4:
                $this->__construct4($args[0], $args[1], $args[2], $args[3]);
                break;

            case 5:
                $this->__construct5($args[0], $args[1], $args[2], $args[3], $args[4]);
                break;
        }
    }

    /**
     * Constructor
     */
    private function __construct0()
    {
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
        $boxMap = $this->getBoxMap($country, $currency);
        if (!key_exists($boxColor, $boxMap)) {
            throw new Exception("The box color '$boxColor' is not supported");
        }
        $this->language = $language;
        $this->country = $country;
        $this->currency = $currency;

        $this->boxID = self::PREFIX_ID.$this->generateDateCode(self::ID_LENGTH);
        $this->color = $boxColor;
        $this->setDate = $this->getDateTime();

        $this->sizeMax = $boxMap[$boxColor]["sizeMax"];
        $this->weight = $boxMap[$boxColor]["weight"];
        $this->picture = $boxMap[$boxColor]["boxPicture"];
        $this->stock = $boxMap[$boxColor]["stock"];
        $this->price = new Price($boxMap[$boxColor]["price"], $currency);
        $minTime = $boxMap[$boxColor]["shipping"]["minTime"];
        $maxTime = $boxMap[$boxColor]["shipping"]["maxTime"];
        $shipPrice = $boxMap[$boxColor]["shipping"]["shipPrice"];
        // $this->shipping = new Shipping($price, $currency->getCopy(), $time);
        $this->shipping = new Shipping($shipPrice, $currency, $minTime, $maxTime);
        // $this->shipping = new Shipping($boxMap[$boxColor]["shipping"]["shipPrice"], $currency, $boxMap[$boxColor]["shipping"]["time"]);
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
        // $time = (int) $tabLine["time"];

        $minTime = (int) $tabLine["minTime"];
        $maxTime = (int) $tabLine["maxTime"];
        // $this->shipping = new Shipping($price, $currency->getCopy(), $time);
        $this->shipping = new Shipping($shipPrice, $currency, $minTime, $maxTime);
        // $this->shipping = new Shipping($shipPrice, $currency, $time);



        if (!empty($tabLine["discount_value"])) {
            $value = $tabLine["discount_value"];
            $this->discount = new Discount($value, $tabLine["beginDate"], $tabLine["endDate"]);
        }
        // $this->setBoxProducts($this->boxID);
    }

    /**
     * To set Box's dynamic constants
     */
    private function setConstant()
    {
        self::$PICTURE_DIR = (!isset(self::$PICTURE_DIR)) ? Configuration::get(Configuration::DIR_STATIC_FILES) : self::$PICTURE_DIR;
    }

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
     * Getter for box's weight
     * @return float box's weight
     */
    private function getWeight()
    {
        return $this->weight;
    }

    /**
     * To get space available in the box
     * @return int space available in the box
     */
    public function getSpace()
    {
        $space = ($this->getSizeMax() - $this->getQuantity());
        if ($space < 0) {
            throw new Exception("Stilling place in box can't be negative");
        }
        return $space;
    }

    /**
     * Getter box's picture
     * @return string box's picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Getter picture plus folder where it's stored
     * + my/file/dir/ + $this->picture
     * @return string box's max amount of product he can contain
     */
    public function getPictureSource()
    {
        return self::$PICTURE_DIR . $this->picture;
    }

    /**
     * Getter for box's set date
     * @return string box's set date
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
     * Getter for box's products
     * @return BoxProduct[] box's products
     */
    public function getProducts()
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
        $products = $this->getProducts();
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

    /**
     * To extract Boxproduct from all boxes
     * @param Box[] $boxes boxes to extract BoxProduct from
     * @return Map of BoxProduct
     * + Map[prodID][index] => BoxProduct
     */
    public static function extractBoxProducts(array $boxes)
    {
        $boxProductsMap = new Map();
        // $boxes = $this->getBoxes();
        if (!empty($boxes)) {
            foreach ($boxes as $box) {
                $products = $box->getProducts();
                if (!empty($products)) {
                    foreach ($products as $product) {
                        $prodID = $product->getProdID();
                        $prodList = $boxProductsMap->get($prodID);
                        (empty($prodList))
                            ? $boxProductsMap->put([$product], $prodID)
                            : $boxProductsMap->put($product, $prodID, count($prodList));
                    }
                }
            }
        }
        return $boxProductsMap;
    }

    /**
     * To get a map that return the id of the box that holds the product
     * @return Map map that return the id of the box that holds the product
     * + Map[prodUnix] => boxID
     */
    public static function getProductToBox(Box ...$boxes)
    {
        if (empty($boxes)) {
            throw new Exception("Boxes can be empty");
        }
        $prodToBoxMap = new Map();
        foreach ($boxes as $box) {
            $boxID = $box->getBoxID();
            $products = $box->getProducts();
            foreach ($products as $product) {
                $prodUnix = $product->getDateInSec();
                $prodToBoxMap->put($boxID, $prodUnix);
            }
        }
        return $prodToBoxMap;
    }

    /**
     * To get the amount of product in the box
     * @return int amount of product in the box
     */
    public function getQuantity()
    {
        $products = $this->getProducts();
        $nb = 0;
        if (count($products) > 0) {
            foreach ($products as $product) {
                $nb += $product->getQuantity();
            }
        }
        return $nb;
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
     * Getter for box's shipping cost
     * @return Shipping box's shipping cost
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Getter for box's Discount
     * @return Discount box's Discount
     */
    public function getDiscount()
    {
        return $this->discount;
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
    public function addProduct($response, $prodID, Size $selectedSize) //, int $quantity = null)
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
        if (empty($product)) {
            throw new Exception("This product don't exist");
        }
        $boxID = $this->getBoxID();
        $product->deleteProduct($response, $boxID);
        if (!$response->containError()) {
            $key = $product->getDateInSec();
            $this->boxProducts[$key] = null;
            unset($this->boxProducts[$key]);
        }
    }

    /**
     * To get boxes ordered
     * @param string|null $orderID id of the order
     * @return Map boxes ordered
     * + Map[boxID{string}][Map::box_color]         => {string}
     * + Map[boxID{string}][Map::sizeMax]           => {int}
     * + Map[boxID{string}][Map::weight]            => {float}
     * + Map[boxID{string}][Map::boxPicture]        => {string}
     * + Map[boxID{string}][Map::sellPrice]         => {float}
     * + Map[boxID{string}][Map::shipping]          => {float}
     * + Map[boxID{string}][Map::discount_value]    => {float}
     * + Map[boxID{string}][Map::setDate]           => {string}
     */
    private static function getOrderedBoxesMap($orderID)
    {
        if(!isset(self::$orderedBoxesMap)){
            if(!isset($orderID)){
                throw new Exception("The order id must be setted");
            }
            self::$orderedBoxesMap = new Map();
            $sql = "SELECT * FROM `Orders-Boxes`WHERE`orderId`='$orderID'";
            $tab = parent::select($sql);
            if(!empty($tab)){
                foreach($tab as $tabLine){
                    $boxID = $tabLine["boxId"];
                    self::$orderedBoxesMap->put($tabLine["box_color"], $boxID, Map::box_color);
                    self::$orderedBoxesMap->put((int)$tabLine["sizeMax"], $boxID, Map::sizeMax);
                    self::$orderedBoxesMap->put(self::toFloat($tabLine["weight"]), $boxID, Map::weight);
                    self::$orderedBoxesMap->put($tabLine["boxPicture"], $boxID, Map::boxPicture);
                    self::$orderedBoxesMap->put(self::toFloat($tabLine["sellPrice"]), $boxID, Map::sellPrice);
                    self::$orderedBoxesMap->put(self::toFloat($tabLine["shipping"]), $boxID, Map::shipping);
                    self::$orderedBoxesMap->put(self::toFloat($tabLine["discount_value"]), $boxID, Map::discount_value);
                    self::$orderedBoxesMap->put($tabLine["setDate"], $boxID, Map::setDate);
                }
            }
        }
        return self::$orderedBoxesMap;
    }

    /**
     * To retrieve boxes ordered from database
     * @param string|null $orderID id of the order
     * @return Box[] boxes ordered
     * @param Currency $currency Visitor's current Currency
     */
    public static function getOrderedBoxes($orderID, Currency $currency)
    {
        $boxes = [];
        $orderedBoxesMap = self::getOrderedBoxesMap($orderID);
        $boxIDs = $orderedBoxesMap->getKeys();
        if(!empty($boxIDs)){
            foreach($boxIDs as $boxID){
                $box = new Box();
                $box->boxID = $boxID;
                $box->color = $orderedBoxesMap->get($boxID, Map::box_color);
                $box->sizeMax = $orderedBoxesMap->get($boxID, Map::sizeMax);
                $box->weight = $orderedBoxesMap->get($boxID, Map::weight);
                $box->picture = $orderedBoxesMap->get($boxID, Map::boxPicture);
                $sellPrice = $orderedBoxesMap->get($boxID, Map::sellPrice);
                $box->price = new Price($sellPrice, $currency);
                $shipping = $orderedBoxesMap->get($boxID, Map::shipping);
                $box->shipping = new Price($shipping, $currency);
                $box->setDate = $orderedBoxesMap->get($boxID, Map::setDate);
                $boxProductsMap = new Map(BoxProduct::getOrderedProducts($boxID));
                $boxProductsMap->sortKeyDesc();
                $box->boxProducts = $boxProductsMap->getMap();
                $unix = $box->getDateInSec();
                $boxes[$unix] = $box;
            }
        }
        return $boxes;
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/
    /**
     * Insert box in the db like a new box
     * @param Response $response to push in results or accured errors
     *  contain the error thrown
     * @param string $userID Visitor's id
     */
    public function insertBox(Response $response, $userID)
    {
        $bracket = "(?,?,?)";   // regex \[value-[0-9]*\]
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
     * @param Response $response to push in results or accured errors
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
     * @param Response $response to push in results or accured errors
     *  contain the error thrown
     */
    public function deleteBox(Response $response)
    {
        $boxID = $this->getBoxID();
        $sql = "DELETE FROM `Baskets-Box` WHERE `Baskets-Box`.`boxId` = '$boxID';
                DELETE FROM `Boxes` WHERE `Boxes`.`boxID`='$boxID';";
        $this->delete($response, $sql);
    }

    /**
     * To insert boxes ordred and their content
     * @param Response $response to push in results or accured errors
     * @param Box[] $boxes set of boxes ordered
     * @param string $orderID id of an order
     */
    public static function orderBoxes(Response $response, $boxes, $orderID) // regex \[value-[0-9]*\]
    {
        $nbBox = count($boxes);
        $bracket = "(?,?,?,?,?,?,?,?,?,?)";
        $sql = "INSERT INTO `Orders-Boxes`(`orderId`, `boxId`, `box_color`, `sizeMax`, `weight`, `boxPicture`, `sellPrice`, `shipping`, `discount_value`, `setDate`)
            VALUES " . self::buildBracketInsert($nbBox, $bracket);
        $values = [];
        foreach ($boxes as $box) {
            array_push(
                $values,
                $orderID,
                $box->getBoxID(),
                $box->getColor(),
                $box->getSizeMax(),
                $box->getWeight(),
                $box->getPicture(),
                $box->getPrice()->getPrice(),
                $box->getShipping()->getPrice(),
                null,
                $box->getSetDate()
            );
        }
        self::insert($response, $sql, $values);

        // if (!$response->containError()) {
        BoxProduct::orderProducts($response, $boxes, $orderID);
        // }
    }
}
