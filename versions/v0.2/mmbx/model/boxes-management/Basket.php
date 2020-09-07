<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Box.php';
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
require_once 'model/boxes-management/DiscountCode.php';
require_once 'model/boxes-management/Size.php';

class Basket extends ModelFunctionality
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
     * Holds basket's boxes
     * + NOTE: Use set date in Unix format as access key like
     * + $boxes = [unixTime => boxe]
     * + ordered from newest to holder
     * @var Box[]
     */
    private $boxes;

    /**
     * Holds basketproduct
     * + NOTE: Use set date in format Unix as access key like
     * + $basketProducts = [setdateUnix => basketProduct]
     * + ordered from newest to holder
     * @var BasketProduct[]
     */
    private $basketProducts;

    /**
     * Liste of discount code of the basket.
     * Use the code as access key like $discountCodes[code => DiscountCode]
     * @var DiscountCode[] $discountCodes
     */
    private $discountCodes;

    /**
     * Constructor
     * @var int $userID identifiant of the user
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    function __construct($userID, Language $language, Country $country, Currency $currency)
    {
        if (empty($userID)) {
            throw new Exception("Param '\$userID' can't be empty");
        }
        if (empty($country) || empty($currency)) {
            throw new Exception("Param '\$country' and '\$currency' can't be empty");
        }
        $this->boxes = [];
        $this->basketProducts = [];
        $this->discountCodes = [];

        $this->language = $language;
        $this->country = $country;
        $this->currency = $currency;

        $sql = "SELECT * FROM `Users` WHERE `userID` = '$userID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            $this->setBoxes($userID, $language, $country, $currency);
            $this->setBasketProducts($userID, $language, $country, $currency);
        }
    }

    /**
     * Setter for boxes
     * @var int $userID identifiant of the user
     * @param Language $language Visitor's language
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function setBoxes($userID, Language $language, Country $country, Currency $currency)
    {
        $sql = "SELECT * FROM `Baskets-Box` WHERE  `userId` = '$userID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $boxID = $tabLine["boxId"];
                $box = new Box($boxID, $userID, $language, $country, $currency);
                $key = $box->getDateInSec();
                $this->boxes[$key] = $box;
            }
            krsort($this->boxes);
        }
    }

    /**
     * Setter for basketproducts
     * @var int $userID identifiant of the user
     * @param Language $language Visitor's language
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function setBasketProducts($userID, Language $language, Country $country, Currency $currency)
    {
        $sql = "SELECT * FROM `Baskets-Products` WHERE `userId` = '$userID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BasketProduct($tabLine["prodId"], $language, $country, $currency);
                $sequence = Size::buildSequence($tabLine["size_name"], null, null);
                $size = new Size($sequence, $tabLine["setDate"], null);
                $product->setSelectedSize($size);
                $quantity = (int) $tabLine["quantity"];
                $product->setQuantity($quantity);
                $key = $product->getDateInSec();
                $this->basketProducts[$key] = $product;
            }
            krsort($this->basketProducts);
        }
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
     * Getter for basket's boxes
     * @return Box[] basket's boxes
     */
    public function getBoxes()
    {
        return $this->boxes;
    }

    /**
     * Getter for basket's basketproduct
     * @return BasketProduct[] basket's basketproduct
     */
    public function getBasketProducts()
    {
        return $this->basketProducts;
    }

    /**
     * Getter for basket's content
     * + content is ordered from newest to older
     * @return Box[]|BasketProduct[] basket's content
     */
    public function getMerge()
    {
        $cart = array_merge($this->getBoxes(), $this->getBasketProducts());
        krsort($cart);
        return $cart;
    }

    /**
     * To add new box in basket
     * + 
     * @param Response $response where to strore results
     * @param string $userID Visitor's id
     * @param string $boxColor box's color
     */
    public function addBox(Response $response, $userID, $boxColor)
    {
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $box = new Box($boxColor, $language,  $country,  $currency);
        $box->insertBox($response, $userID);
        if(!$response->containError()){
            $key = $box->getDateInSec();
            $this->boxes[$key] = $box;
            krsort($this->boxes);
        }
    }
}
