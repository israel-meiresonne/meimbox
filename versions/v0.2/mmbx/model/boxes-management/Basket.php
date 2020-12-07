<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Box.php';
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
require_once 'model/boxes-management/DiscountCode.php';
require_once 'model/boxes-management/Size.php';
require_once 'model/special/Response.php';
require_once 'model/special/Map.php';

class Basket extends ModelFunctionality
{
    /**
     * Holds Visitor's id
     * @var string
     */
    private $userID;

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
    protected $boxes;

    /**
     * Holds basketproduct
     * + NOTE: Use set date in format Unix as access key like
     * + $basketProducts = [setdateUnix => basketProduct]
     * + ordered from newest to holder
     * @var BasketProduct[]
     */
    protected $basketProducts;

    /**
     * Liste of discount code of the basket.
     * Use the code as access key like $discountCodes[code => DiscountCode]
     * @var DiscountCode $discountCodes
     */
    protected $discountCodes;

    public const KEY_TOTAL = "basket_total";
    public const KEY_SUBTOTAL = "basket_subtotal";
    public const KEY_SUBTOTAL_DISC = "basket_subtotal_disc";
    public const KEY_VAT = "basket_vat";
    public const KEY_SHIPPING = "basket_shipping";
    public const KEY_SHIPPING_DISC = "basket_shipping_disc";
    public const KEY_BSKT_QUANTITY = "basket_quantity";
    public const KEY_CART_FILE = "cart_file";

    /**
     * Constructor
     * @var string $userID Visitor's id
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    function __construct($userID, Language $language, Country $country, Currency $currency)
    {
        if (empty($userID) || empty($language) || empty($country) || empty($currency)) {
            throw new Exception("The user's id, the language, the 'country' and the 'currency' can't be empty");
        }
        $this->userID = $userID;
        $this->language = $language;
        $this->country = $country;
        $this->currency = $currency;
    }

    /**
     * Setter for boxes
     * @var string $userID Visitor's id
     * @param Language $language Visitor's language
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function setBoxes()
    {
        $this->boxes = [];
        $userID = $this->getUserID();
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
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
     * @var string $userID Visitor's id
     * @param Language $language Visitor's language
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function setBasketProducts()
    {
        $this->basketProducts = [];
        $userID = $this->getUserID();
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $sql = "SELECT * FROM `Baskets-Products` WHERE `userId` = '$userID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BasketProduct($tabLine["prodId"], $language, $country, $currency);
                $sequence = Size::buildSequence($tabLine["size_name"], null, null, null);
                $size = new Size($sequence, $tabLine["setDate"]);
                $quantity = (int) $tabLine["quantity"];
                $size->setQuantity($quantity);
                $product->selecteSize($size);
                $key = $product->getDateInSec();
                $this->basketProducts[$key] = $product;
            }
            krsort($this->basketProducts);
        }
    }

    /**
     * To set basket's discount codes
     */
    private function setDiscountCodes()
    {
        $this->discountCodes = [];
        $userID = $this->getUserID();
        $sql = "SELECT * FROM `Basket-DiscountCodes` WHERE `userId`='$userID';";
        $tab = parent::select($sql);
        if (!empty($tab)) {
            foreach ($tab as $tabLine) {
                $code = $tabLine["discount_code"];
                $country = $this->getCountry();
                $setDate = $tabLine["setDate"];
                $discCode = new DiscountCode($code, $country, $setDate);
                // $this->discountCodes->put($discountCode, $code);
                $this->discountCodes[$code] = $discCode;
            }
        }
    }

    /**
     * Getter for Visitor's id
     * @return string Visitor's id
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Getter for box's Language 
     * + the same instance that Visitor
     * @return Language box's Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Getter for box's Country 
     * + the same instance that Visitor
     * @return Country box's Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Getter for box's Currency 
     * + the same instance that Visitor
     * @return Currency box's Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Getter for basket's boxes
     * @return Box[] basket's boxes
     */
    public function getBoxes()
    {
        (!isset($this->boxes)) ? $this->setBoxes() : null;
        return $this->boxes;
    }

    /**
     * To get the box with the id given in param
     * @param string $boxID id of the box to get
     * @return Box|null the box with the id given in param else return null
     */
    public function getBox($boxID)
    {
        $found = false;
        $boxes = $this->getBoxes();
        foreach ($boxes as $key => $boxe) {
            $found = $boxes[$key]->getBoxID() == $boxID;
            if ($found) {
                return $boxes[$key];
            }
        }
        return null;
    }

    /**
     * Getter for basket's basketProducts
     * @return BasketProduct[] basket's basketProducts
     */
    public function getBasketProducts()
    {
        (!isset($this->basketProducts)) ? $this->setBasketProducts() : null;
        return $this->basketProducts;
    }

    /**
     * To get basket product with the given size
     * @param string $prodID id of the product tto look for
     * @param Size $sizeObj size of the product tto look for
     * @return BasketProduct|null basket product with the given size
     */
    public function getBasketProduct($prodID, Size $sizeObj)
    {
        $products = $this->getBasketProducts();
        if (count($products) > 0) {
            foreach ($products as $key => $product) {
                $selectedSize = $product->getSelectedSize();
                if (($prodID == $product->getProdID())
                    && ($sizeObj->getSequence() == $selectedSize->getSequence())
                ) {
                    return $products[$key];
                }
            }
        }
        return null;
    }

    /**
     * Getter for basket's content
     * + merge list of basket product and boxes
     * + content is ordered from newest to older
     * @return Box[]|BasketProduct[] basket's content
     */
    public function getMerge()
    {
        $cart = array_merge($this->getBoxes(), $this->getBasketProducts());
        return $cart;
    }

    /**
     * To get the quantity of boxproduct and basketproduct inside the basket
     * @return int
     */
    public function getQuantity()
    {
        $basketProducts = $this->getBasketProducts();
        $boxes = $this->getBoxes();
        $quantity = 0;
        if (!empty($basketProducts)) {
            foreach ($basketProducts as $basketProduct) {
                $quantity += $basketProduct->getQuantity();
            }
        }
        if (!empty($boxes)) {
            foreach ($boxes as $box) {
                $quantity += $box->getQuantity();
            }
        }
        return $quantity;
    }

    /**
     * To get discount codes  applied on basket
     * @return DiscountCode[] discount codes  applied on basket
     */
    public function getDiscountCodes()
    {
        (!isset($this->discountCodes)) ? $this->setDiscountCodes() : null;
        return $this->discountCodes;
    }

    // public function getSortedDiscountCodes()
    // {
    //     $discCodes = $this->getDiscountCodes()->getMap();
    //     if(!empty())

    // }

    /**
     * To get the sum of of BasketProducts and Boxes in Basket
     * @return Price sum of of prices of BasketProducts and Boxes in Basket
     */
    // public function getSumProducts()
    public function getSumProducts()
    {
        $basketProducts = $this->getBasketProducts();
        $boxes = $this->getBoxes();
        $sum = 0;
        if (!empty($basketProducts)) {
            foreach ($basketProducts as $basketProduct) {
                $price = $basketProduct->getPrice()->getPrice();
                $quantity = $basketProduct->getQuantity();
                $sum += ($price * $quantity);
            }
        }
        if (!empty($boxes)) {
            foreach ($boxes as $box) {
                $sum += $box->getPrice()->getPrice();
            }
        }
        return new Price($sum, $this->getCurrency());
    }

    /**
     * To get price of item in Basket excluding vat tax
     * @return Price price of item in Basket excluding vat tax
     */
    // public function getHvat()
    private function getHvat()
    {
        $vat = $this->getCountry()->getVat();
        $hvat = $this->getSumProducts()->getPrice() / (1 + $vat);
        return new Price($hvat, $this->getCurrency());
    }

    /**
     * To get basket's total price
     * @return Price basket's total price
     */
    public function getTotal()
    {
        $sum = 0;
        $sumProducts = $this->getSumProducts()->getPrice();
        $reductSumProd = $this->getDiscountSumProducts()->getPrice();
        $shipping = $this->getShipping()->getPrice();
        $reductShip = $this->getDiscountShipping()->getPrice();
        $sum += ($sumProducts - $reductSumProd);
        $sum += ($shipping - $reductShip);
        $currency = $this->getCurrency();
        return (new Price($sum, $currency));
    }

    /**
     * To get basket's subtotal amount following the given config
     * @param $conf to config the subtotal returned
     * @return Price basket's subtotal amount
     */
    public function getSubTotal()
    {
        $country = $this->getCountry();
        $total = $this->getTotal()->getPrice() - $this->getShipping()->getPrice();
        $vat = $country->getVat();
        $subtotal = ($total / (1 + $vat));
        $currency = $this->getCurrency();
        return (new Price($subtotal, $currency));
    }

    /**
     * To get basket's subtotal amount
     * @return Price basket's subtotal amount
     */
    public function getVatAmount()
    {
        $hvat = $this->getHvat()->getPrice();
        $sumProducts = $this->getSumProducts()->getPrice();
        $vatAmount = $sumProducts - $hvat;
        return (new Price($vatAmount, $this->getCurrency()));
    }

    /**
     * To get Basket's shipping cost
     * @return Price Basket's shipping cost
     */
    public function getShipping()
    {
        $boxes = $this->getBoxes();
        $shipping = 0;
        if (!empty($boxes)) {
            foreach ($boxes as $box) {
                $shipping += $box->getShipping()->getPrice();
            }
        }
        /** INSERT CODE: function to get shipping from BasketProduct */
        return new Price($shipping, $this->getCurrency());
    }

    /**
     * To get the amount of the discount for the sum of products in Bakste
     * @return Price the amount of the discount
     */
    public function getDiscountSumProducts()
    {
        $discountCodes = $this->getDiscountCodes();
        $prodReduct = 0;
        $nb = count($discountCodes);
        if ($nb > 0) {
            $sumProducts = $this->getSumProducts()->getPrice();
            foreach ($discountCodes as $discCode) {
                $hasDiscount = $this->hasDiscount();
                $isCumulable = $discCode->isCumulable();
                $hasMutipleDiscCode = ($nb > 0);
                if ($discCode->isActive()) {
                    if ($isCumulable || (!($hasDiscount || $hasMutipleDiscCode))) {
                        $newSumProd = $sumProducts - $prodReduct;
                        switch ($discCode->getType()) {
                            case DiscountCode::TYPE_SUM_PRODS:
                                $prodReduct += $this->getReduction($discCode, $newSumProd, $newSumProd);
                                $prodReduct = ($prodReduct > $sumProducts) ? $sumProducts : $prodReduct;
                                break;
                        }
                    }
                }
            }
        }
        return new Price($prodReduct, $this->getCurrency());
    }

    /**
     * To get the amount of the discount for the shipping
     * @return Price the amount of the discount for the shipping
     */
    public function getDiscountShipping()
    {
        $discCodes = $this->getDiscountCodes();
        $shipReduct = 0;
        $nb = count($discCodes);
        if ($nb > 0) {
            $sumProducts = $this->getSumProducts()->getPrice();
            $prodReduct = $this->getDiscountSumProducts()->getPrice();
            $finalSumProducts = $sumProducts - $prodReduct;
            $shipping = $this->getShipping()->getPrice();
            foreach ($discCodes as $discCode) {
                $hasDiscount = $this->hasDiscount();
                $isCumulable = $discCode->isCumulable();
                $hasMutipleDiscCode = ($nb > 0);
                if ($discCode->isActive()) {
                    if ($isCumulable || (!($hasDiscount || $hasMutipleDiscCode))) {
                        switch ($discCode->getType()) {
                            case DiscountCode::TYPE_SHIPPING:
                                $newShipping = $shipping - $shipReduct;
                                $shipReduct += $this->getReduction($discCode, $finalSumProducts, $newShipping);
                                $shipReduct = ($shipReduct > $shipping) ? $shipping : $shipReduct;
                                break;
                        }
                    }
                }
            }
        }
        return new Price($shipReduct, $this->getCurrency());
    }

    /**
     * To increase the sum of discount
     * @param DiscountCode  $discCode   the discount to use
     * @param float         $activator  the amount used to activate the reduction
     * @param float         $support    value to get reduct from
     * @return float sum increased of rate of the given total
     */
    private function getReduction(DiscountCode $discCode, float $activator, float $support): float
    {
        $reduction = 0;
        $minAmount = $discCode->getMinAmount();
        $maxAmount = $discCode->getMaxAmount();
        $reduction = (empty($minAmount) || ($activator >= $minAmount))
        ? ($support * $discCode->getRate())
        : 0;
        $reduction = (isset($maxAmount) && ($reduction > $maxAmount)) ? $maxAmount : $reduction;
        return $reduction;
    }

    /**
     * To check if Basket holds at less one Product or Box with a active discount
     * @return bool true if there's at less one else false
     */
    private function hasDiscount()
    {
        $hasDiscount = false;
        $boxes = $this->getBoxes();
        foreach ($boxes as $box) {
            if ($box->getDiscount()->isActive()) {
                $hasDiscount = true;
                break;
            }
        }
        /** check also all BasketProducts */
        return $hasDiscount;
    }

    /**
     * Check if still enough place in box to add one product
     * @param string $boxID id of the box to look for
     * @return boolean true if still space in the box else false
     */
    public function stillSpace($boxID, int $quantity = 1)
    {
        $box = $this->getBox($boxID);
        if ($box == null) {
            throw new Exception("This box don't exist boxID:'$boxID'");
        }
        return ($box->getSpace() >= $quantity);
    }

    /**
     * To check if stock still available for products in the basket without 
     * Including locked products
     * + check all type of product
     * + don't check if product has locked stock
     * @return Map map of product out of stock
     */
    public function stillStock()
    {
        $soldOutProducts = new Map();
        $boxes = $this->getBoxes();
        $boxProductsMap = Box::extractBoxProducts($boxes);
        $prodIDs = $boxProductsMap->getKeys();
        if (!empty($prodIDs)) {
            foreach ($prodIDs as $prodID) {
                /**
                 * @var BoxProduct[] */
                $boxProducts = $boxProductsMap->get($prodID);
                $sizesMap = Product::extractSizes($boxProducts);
                $selectedSizes = $this->keysToAscInt($sizesMap->getMap());
                if (!$boxProducts[0]->stillStock(...$selectedSizes)) {
                    foreach ($boxProducts as $boxProduct) {
                        $soldOutProducts->put($boxProduct, count($soldOutProducts->getKeys()));
                    }
                }
            }
        }

        /** check unlock stock for basketproduct */

        $soldOutProducts->sortKeyDesc();
        return $soldOutProducts;
    }

    /**
     * To check if still stock for product in the basket including locked stock
     * + this function combine stock available and stock locked to deduct the 
     * stilling stock
     * @return Map map of product out of stock
     */
    public function stillUnlockedStock()
    {
        $lockedProd = new Map();
        $boxes = $this->getBoxes();
        $boxProductsMap = Box::extractBoxProducts($boxes);
        $prodIDs = $boxProductsMap->getKeys();
        if (!empty($prodIDs)) {
            foreach ($prodIDs as $prodID) {
                /**
                 * @var BoxProduct[] */
                $boxProducts = $boxProductsMap->get($prodID);
                if (!BoxProduct::stillUnlockedStock($boxProducts)) {
                    foreach ($boxProducts as $boxProduct) {
                        $lockedProd->put($boxProduct, count($lockedProd->getKeys()));
                    }
                }
            }
        }

        /** check unlock stock for basketproduct */

        $lockedProd->sortKeyDesc();
        return $lockedProd;
    }

    /**
     * To check if there is a BoxProduct using the Measure with the given id
     * @param string $measureID id of the measure to look for
     * @return bool true if there is a BoxProduct using the Measure with the 
     * given id else false
     */
    public function existMeasure($measureID)
    {
        $exist = false;
        $boxes = $this->getBoxes();
        if (!empty($boxes)) {
            $productsMap = Box::extractBoxProducts($boxes);
            $prodIDs = $productsMap->getKeys();
            foreach ($prodIDs as $prodID) {
                $products = $productsMap->get($prodID);
                $sizesMap = Product::extractSizes($products);
                $sequences = $sizesMap->getKeys();
                foreach ($sequences as $sequence) {
                    /**
                     * @var Size */
                    $size = $sizesMap->get($sequence);
                    if ($size->getmeasureID() == $measureID) {
                        $exist = true;
                        break;
                    }
                }
                if ($exist) {
                    break;
                }
            }
        }
        return $exist;
    }

    /**
     * To add new box in basket
     * + also add box in db
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
        if (!$response->containError()) {
            $key = $box->getDateInSec();
            $this->boxes[$key] = $box;
            krsort($this->boxes);
        }
    }

    /**
     * To delete box from Visitor's basket
     * + also delete from db
     * @param Response $response where to strore results
     * @param string $boxID id of box in Visitor's basket
     */
    public function deleteBox(Response $response, $boxID)
    {
        $this->emptyBox($response, $boxID);
        if (!$response->containError()) {
            $box = $this->getBox($boxID);
            $box->deleteBox($response);
            if (!$response->containError()) {
                // $key = $box->getDateInSec();
                // $this->boxes[$key] = null;
                // unset($this->boxes[$key]);
                $this->unsetBox($boxID);
            }
        }
    }

    /**
     * To deleted empty boxes
     * @return boolean true if at less one box have been deleted else false
     */
    public function deleteEmptyBoxes(Response $response)
    {
        $haveDelete = false;
        $boxes = $this->getBoxes();
        if (!empty($boxes)) {
            foreach ($boxes as $box) {
                if ($box->getQuantity() <= 0) {
                    $box->deleteBox($response);
                    $haveDelete = (!$haveDelete) ? true : $haveDelete;
                }
            }
        }
        return $haveDelete;
    }

    /**
     * To unset a box from basket
     * @param string $boxID id of box in Visitor's basket
     */
    public function unsetBox($boxID)
    {
        $box = $this->getBox($boxID);
        if (!empty($box)) {
            $key = $box->getDateInSec();
            $this->boxes[$key] = null;
            unset($this->boxes[$key]);
        }
    }

    /**
     * To delete all product inside a box
     * @param Response $response where to strore results
     * @param string $boxID id of box in Visitor's basket
     */
    private function emptyBox(Response $response, $boxID)
    {
        $box = $this->getBox($boxID);
        if (empty($box)) {
            throw new Exception("This box don't exist, boxId: $boxID");
        }
        ($box->getSizeMax() != $box->getSpace()) ? $box->emptyBox($response) : null;
    }

    /**
     * To add new product in box of Visitor's basket
     * @param Response $response where to strore results
     * @param string $boxID id of a box in Visitor's basket
     * @param string $prodID id of the product to add in box
     * @param Size $sizeObj submited size for product
     */
    public function addBoxProduct(Response $response, $boxID, $prodID, Size $sizeObj)
    {
        $box = $this->getBox($boxID);
        if ($box == null) {
            throw new Exception("This box don't exist boxID:'$boxID'");
        }
        $box->addProduct($response, $prodID, $sizeObj);
    }

    /**
     * To update a box product
     * @param Response $response where to strore results
     * @param string $boxID id of the box that holds the product
     * @param string $prodID id of the product to add in box
     * @param Size $holdsSize product's holds Size
     * @param Size $newSize product's new Size
     */
    public function updateBoxProduct(Response $response, $boxID, $prodID, Size $holdSize, Size $newSize)
    {
        $box = $this->getBox($boxID);
        if ($box == null) {
            throw new Exception("This box don't exist boxID:'$boxID'");
        }
        // $product->selecteSize($newSize);
        $box->updateProduct($response, $prodID, $holdSize, $newSize);
    }

    /**
     * To update a box product
     * @param Response $response where to strore results
     * @param string $prodID id of the product to add in box
     * @param Size $holdsSize product's holds Size
     * @param Size $newSize product's new Size
     */
    public function updateBasketProduct(Response $response, $prodID, Size $holdSize, Size $newSize)
    {
        $product = $this->getBasketProduct($prodID, $holdSize);
        if (empty($product)) {
            throw new Exception("This basketProduct don't exist in basket, prodID:'$prodID'");
        }
        // $product->selecteSize($newSize);
        $product->updateProduct($response, $prodID, $holdSize, $newSize);
    }

    /**
     * To move a boxproduct to a other box
     * @param Response $response where to strore results
     * @param string $boxID id of a box in Visitor's basket
     * @param string $prodID id of the product to add in box
     * @param Size $sizeObj size of the product to move
     */
    public function moveBoxProduct(Response $response, $boxID, $newBoxID, $prodID, Size $sizeObj)
    {
        $box = $this->getBox($boxID);
        $newBox = $this->getBox($newBoxID);
        if (empty($box)) {
            throw new Exception("This box don't exist boxID:'$boxID'");
        }
        if (empty($newBox)) {
            throw new Exception("This box don't exist newBox:'$newBox'");
        }
        $product = $box->getProduct($prodID, $sizeObj);
        if (empty($product)) {
            $sequence = $sizeObj->getSequence();
            throw new Exception("This product don't exist in box, boxID: '$boxID', prodID: '$prodID', sequence:'$sequence'");
        }
        $selectedSize = $product->getSelectedSize();
        $quantity = $selectedSize->getQuantity();
        if (!$this->stillSpace($newBoxID, $quantity)) {
            throw new Exception("This box don't have enought space stilling");
        } else {
            $this->addBoxProduct($response, $newBoxID, $prodID, $selectedSize);
            if (!$response->containError()) {
                $this->deleteBoxProduct($response, $boxID, $prodID, $selectedSize);
            }
        }
    }

    /**
     * To delete a product from a box
     * @param Response $response where to strore results
     * @param string $boxID id of a box in Visitor's basket
     * @param string $prodID id of the product to delete from box
     * @param Size $size size of the product to delete
     */
    public function deleteBoxProduct(Response $response, $boxID, $prodID, Size $size)
    {
        $box = $this->getBox($boxID);
        if ($box == null) {
            throw new Exception("This box don't exist boxID:'$boxID'");
        }
        $box->deleteBoxProduct($response, $prodID, $size);
    }

    /**
     * To reserve ,for a duration, the stock of all products in the basket and in boxes
     * Note: this function can be used only if you already checking that it 
     * still stock for all product with Basket::stillStock()
     * @param Response $response where to strore results
     * @param string $userID Client's id
     */
    public function lock(Response $response, $userID)
    {
        $boxes = $this->getBoxes();
        $boxProductsMap = Box::extractBoxProducts($boxes);
        $prodIDs = $boxProductsMap->getKeys();
        if (!empty($prodIDs)) {
            foreach ($prodIDs as $prodID) {
                /**
                 * @var BoxProduct[] */
                $boxProducts = $boxProductsMap->get($prodID);
                BoxProduct::lock($response, $userID, $boxProducts);
            }
        }
        /** lock stock of basketproduct */
    }

    /**
     * To unlock locked stock of products
     * @param Response $response where to strore results
     * @param string $userID Client's id
     */
    public function unlock(Response $response, $userID)
    {
        Product::deleteLocks($response, $userID);
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/
}
