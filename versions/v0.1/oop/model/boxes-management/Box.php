<?php

class Box
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
     * Holds the buying price of the box
     * @var Price
     */
    private $buiyPrice;

    /**
     * Holds de number of box bought lastely to restock
     * @var int
     */
    private $quantity;

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
    private $boxPicture;

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
     * Shippings cost for each country and currency
     * $shippings = [
     *      iso_country => [
     *          iso_currency => Shipping
     *      ]
     * ]
     * @var Shipping[[]] In format $shippings[iso_country][iso_currency]
     */
    private $shippings;

    /** 
     * Sell prices for each country and currency
     * $prices = [
     *      iso_country => [
     *          iso_currency => Price
     *      ]
     * ]
     * @var Price[[]] In format $prices[iso_country][iso_currency]
     */
    private $prices;

    /** 
     * New price after an appliqued discount sell prices for each country and currency.
     * Fill only the country where the discount is available
     * $prices = [
     *      iso_country => [
     *          iso_currency => Price
     *      ]
     * ]
     * @var Price[[]] In format $newPrices[iso_country][iso_currency]
     */
    private $newPrices;

    /**
     * Discount values for each country
     * $discounts = [
     *      iso_country => Discount
     * ]
     * @var Discount[] In format $discounts[iso_country]
     */
    private $discounts;

    /**
     * Liste of BoxProduct inside the box
     * @var BoxProduct[] Use Unix time of the as key
     */
    private $boxProducts;


    /**
     * __construct2($db, $boxID, $color, $setDate, $sizeMax, $weight)
     * @param string $boxID Sequence of letter and number created with the date in forma DATETIME+ms
     * @param string $color Color of the box get from Database
     * @param string $setDate Date and hour of the creation of this box into format YYYY-MM-DD HH:MM:SS
     * @param int $sizeMax The maximum number of boxProduct that this box can contain 
     * @param double $weight
     * @param int $stock
     */
    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 3:
                self::__construct3($argv[0], $argv[1], $argv[2]);
                break;
        }
    }

    private function __construct0()
    {
    }

    private function __construct3($boxID, $boxProductMap, $dbMap)
    {
        $this->boxID = $boxID;
        $this->color = $dbMap["boxMap"]["boxes"][$boxID]["box_color"];
        $this->setDate = $dbMap["boxMap"]["boxes"][$boxID]["setDate"];
        $this->sizeMax = $dbMap["boxMap"]["boxesProperties"][$this->color]["boxDatas"]["sizeMax"];
        $this->weight = $dbMap["boxMap"]["boxesProperties"][$this->color]["boxDatas"]["weight"];
        $this->boxPicture = $dbMap["boxMap"]["boxesProperties"][$this->color]["boxDatas"]["boxPicture"];
        $this->stock = $dbMap["boxMap"]["boxesProperties"][$this->color]["boxDatas"]["stock"];
        $this->newPrices = [];
        $this->quantity = $dbMap["boxMap"]["boxesProperties"][$this->color]["boxDatas"]["buyPriceDatas"]["quantity"];

        $buyPriceDatas = $dbMap["boxMap"]["boxesProperties"][$this->color]["boxDatas"]["buyPriceDatas"];
        $shippingDatas = $dbMap["boxMap"]["boxesProperties"][$this->color]["shippings"];
        $priceDatas = $dbMap["boxMap"]["boxesProperties"][$this->color]["prices"];
        $discountDatas = $dbMap["boxMap"]["boxesProperties"][$this->color]["discounts"];

        $this->buiyPrice = GeneralCode::initBuiyPrice($buyPriceDatas, $dbMap);
        $this->shippings = GeneralCode::initShippings($shippingDatas, $dbMap);
        $this->prices = GeneralCode::initPrices($priceDatas, $dbMap);
        $this->discounts = GeneralCode::initDiscounts($discountDatas, $dbMap);
        Box::initBoxProducts($boxProductMap, $dbMap);
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
     * @param array $boxProductMap list of product with their datas
     * @param array $currencyMap database currencies
     * @param array $countryMap $countryMap database countries
     */
    private function initBoxProducts($boxProductMap, $dbMap)
    {
        foreach ($dbMap["boxMap"]["boxes"][$this->boxID]["boxProducts"] as $prodID => $true) {
            $product = $boxProductMap[$prodID];
            foreach ($product["datas"]["basket"] as $boxId => $sequenceIDs) {
                foreach ($sequenceIDs as $sequenceID => $datas) {
                    $boxProduct = new BoxProduct($prodID, $dbMap);
                    $size = $datas["size_name"];
                    $brand = $datas["brand_name"];
                    $cut = $datas["cut_name"];
                    $quantity = $datas["quantity"];
                    $setDate = $datas["setDate"];

                    $measureId = $datas["measureId"];
                    $measureDatas = $dbMap["usersMap"]["usersMeasures"][$measureId];
                    if (!empty($measureDatas)) {
                        $values["measureID"] = $measureDatas["measureID"];
                        $values["measure_name"] = $measureDatas["measure_name"];
                        $values["bust"] = $measureDatas["userBust"];
                        $values["arm"] = $measureDatas["userArm"];
                        $values["waist"] = $measureDatas["userWaist"];
                        $values["hip"] = $measureDatas["userHip"];
                        $values["inseam"] = $measureDatas["userInseam"];
                        $values["unit_name"] = $measureDatas["unit_name"];
                        $values["size"] = $measureDatas["size_name"];
                        $values["setDate"] = $datas["setDate"];
                        $measure = new Measure($values, $dbMap);
                    } else {
                        $measure = null;
                    }
                    $boxProduct->setSize($size, $brand, $cut, $quantity, $setDate, $measure);
                    $key = $boxProduct->getDateInSec();
                    $this->boxProducts[$key] = $boxProduct;
                }
            }
        }
        ksort($this->boxProducts);
    }

    /**
     * @return Shipping[[]] a protected copy of the Shippings attribute
     */
    public function getCopyShippings()
    {
        $copy = [];
        foreach ($this->shippings as $iso_country => $currencyList) {
            foreach ($currencyList as $iso_currency => $shipping) {
                $copy[$iso_country][$iso_currency] = $shipping->getCopy();
            }
        }
        return $copy;
    }

    /**
     * @return Price[[]] a protected copy of the Prices attribute
     */
    public function getCopyPrices()
    {
        $copy = [];
        foreach ($this->prices as $iso_country => $currencyList) {
            foreach ($currencyList as $iso_currency => $price) {
                $copy[$iso_country][$iso_currency] = $price->getCopy();
            }
        }
        return $copy;
    }

    /**
     * @return Price[[]] a protected copy of the NewPrices attribute
     */
    public function getCopyNewPrices()
    {
        $copy = [];
        foreach ($this->newPrices as $iso_country => $currencyList) {
            foreach ($currencyList as $iso_currency => $newPrice) {
                $copy[$iso_country][$iso_currency] = $newPrice->getCopy();
            }
        }
        return $copy;
    }

    /**
     * @return Discount[] a protected copy of the Discounts attribute
     */
    public function getCopyDiscounts()
    {
        $copy = [];
        foreach ($this->discounts as $setdateUnix => $discount) {
            $copy[$setdateUnix] = $discount->getCopy();
        }
        ksort($copy);
        return $copy;
    }

    /**
     * @return BoxProduct[] a protected copy of the BoxProduct attribute
     */
    public function getCopyBoxProducts()
    {
        $copy = [];
        foreach ($this->boxProducts as $setDateUnix => $boxProduct) {
            $copy[$setDateUnix] = $boxProduct->getCopy();
        }
        ksort($copy);
        return $copy;
    }

    /**
     * To get a protected copy of a Price instance
     * @return Box a protected copy of the Price instance
     */
    public function getCopy()
    {
        $copy = new Box();
        $copy->boxID = $this->boxID;
        $copy->color = $this->color;
        $copy->buiyPrice = (!empty($this->buiyPrice)) ? $this->buiyPrice->getCopy() : null;
        $copy->quantity = $this->quantity;
        $copy->sizeMax = $this->sizeMax;
        $copy->weight = $this->weight;
        $copy->stock = $this->stock;
        $copy->setDate = $this->setDate;
        $copy->shippings = $this->getCopyShippings();
        $copy->prices = $this->getCopyPrices();
        $copy->newPrices = $this->getCopyNewPrices();
        $copy->discounts = $this->getCopyDiscounts();
        $copy->boxProducts = $this->getCopyBoxProducts();
        return $copy;
    }


    public function __toString()
    {
        helper::printLabelValue("boxID", $this->boxID);
        helper::printLabelValue("color", $this->color);
        // $this->buiyPrice->__toString;
        helper::printLabelValue("quantity", $this->quantity);
        helper::printLabelValue("sizeMax", $this->sizeMax);
        helper::printLabelValue("weight", $this->weight);
        helper::printLabelValue("boxPicture", $this->boxPicture);
        helper::printLabelValue("stock", $this->stock);
        helper::printLabelValue("setDate", $this->setDate);

        // foreach ($this->shippings as $isoCountry => $currencyList) {
        //     echo $isoCountry . "<br>";
        //     foreach ($currencyList as $isoCurrency => $shipping) {
        //         echo "  " . $isoCurrency . "➡️  ";
        //         $shipping->__toString();
        //     }
        // }

        // foreach ($this->prices as $isoCountry => $currencyList) {
        //     echo $isoCountry . "<br>";
        //     foreach ($currencyList as $isoCurrency => $price) {
        //         echo "  " . $isoCurrency . "➡️  ";
        //         $price->__toString();
        //     }
        // }

    }
}
