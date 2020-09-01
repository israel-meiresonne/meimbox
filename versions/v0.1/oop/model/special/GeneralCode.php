<?php

/**
 * This class group repetitives and identical codes shared by many other classes
 * to evoid to repete this everywhere.
 */
class GeneralCode
{
    const UNDERSCORE = "_";

    
    /**
     * "buyPriceDatas" => [
     *     "setdate" => string,
     *     "buy_country" => string,
     *     "iso_currency" => string,
     *     "buyPrice" => double,
     *     "quantity" => int
     *  ]
     * @param array $buyPriceDatas buy price datas
     * @param array $dbMap of Database's tables
     * @return Price the last price paid to restock the product
     */
    public static function initBuiyPrice($buyPriceDatas, $dbMap)
    {
        $price = $buyPriceDatas["buyPrice"];
        $countryName = $buyPriceDatas["buy_country"];
        $isoCurrency = $buyPriceDatas["iso_currency"];

        return new Price($price, $countryName, $isoCurrency, $dbMap);
    }

    /**
     * @param array $shippingDatas shipping cost datas
     * @param array $dbMap of Database's tables
     * @return Shipping[] a list of shipping by country and currency $shippings[iso_country][iso_currency] = $shipping
     */
    public static function initShippings($shippingDatas, $dbMap)
    {
        $shippings = [];
        foreach ($shippingDatas as $countryName => $currencyList) {
            foreach ($currencyList as $isoCurrency => $datas) {
                $price = $datas["price"];
                $time = $datas["time"];
                $shipping = new Shipping($price, $countryName, $isoCurrency, $time, $dbMap);
                // [iso_country][iso_currency]
                $isoCountry = $shipping->getIsoCountry();
                $shippings[$isoCountry][$isoCurrency] = $shipping;
            }
        }
        return $shippings;
    }

    /**
     * @param array $priceDatas price datas
     * @param array $dbMap of Database's tables
     * @return Price[] a list of prices by country and currency $prices[iso_country][iso_currency] = $prices
     */
    public static function initPrices($priceDatas, $dbMap)
    {
        $prices = [];
        foreach ($priceDatas as $countryName => $currencyList) {
            foreach ($currencyList as $isoCurrency => $price) {
                $priceObj = new Price($price, $countryName, $isoCurrency, $dbMap);
                // [iso_country][iso_currency]
                $isoCountry = $priceObj->getIsoCountry();
                $prices[$isoCountry][$isoCurrency] = $priceObj;
            }
        }

        return $prices;
    }

    /**
     * @param array $discountDatas discount datas
     * @param array $dbMap of Database's tables
     * @return Discount[] list of discount
     */
    public static function initDiscounts($discountDatas, $dbMap)
    {
        $discounts = [];
        foreach ($discountDatas as $countryName => $discount) {
            // for new Discount
            $value = $discount["discount_value"];
            $beginDate = $discount["beginDate"];
            $endDate = $discount["endDate"];

            $discountObj = new Discount($value, $beginDate, $endDate, $countryName, $dbMap);
            $isoCountry = $discountObj->getIsoCountry();
            $discounts[$isoCountry] = $discountObj;
        }
        return $discounts;
    }

    /**
     * Fill a array given in param with values of another array given too in param
     * @param string[] $array the array to fill with value of the other array
     * @param string[] $values the array of values to push in the other array
     * @return string[] the array to fill ($array) filled with the values in the passed param $values
     */
    public static function fillArrayWithArray($array, $values)
    {
        $valueKeys = array_keys($values);
        // $nbValue = count($values);
        // for ($i = 0; $i < $nbValue; $i++) {
        //     array_push($array, $values[$i]);
        // }
        foreach ($valueKeys as $key) {
            if (array_key_exists($key, $array)) {
                array_push($array, $values[$key]);
            } else {
                $array[$key] = $values[$key];
            }
        }
        return $array;
    }

    /**
     * Provide a protected copy of any map containing Object, array or primitives variables. 
     * NOTE: Objects inside the map must implement a method getCopy() that return the copy
     *  of the Object
     * @param array[array[...]] map to copy
     * @return array[array[...]] a protected copy of the map given in param
     */
    public static function cloneMap($Map)
    {
        // public static function cloneMap($Map){
        $copyMap = [];
        $copyMap = self::cloneMapRec($Map);
        return $copyMap;
    }

    /**
     * @param array[array[...]] map to copy
     * @return array[array[...]] a protected copy of the map given in param
     */
    private function cloneMapRec($Map)
    {
        $copyMapRéc = [];
        foreach ($Map as $key => $value) {
            switch (gettype($value)) {
                case "array":
                    $copyMapRéc[$key] = self::cloneMapRec($value, $copyMapRéc);
                    break;
                case "object":
                    $copyMapRéc[$key] = $value->getCopy();
                    break;
                default:
                    $copyMapRéc[$key] = $value;
                    break;
            }
        }
        return $copyMapRéc;
    }

    /** 
     * Clean inputs, GET inputs and POST inputs of all indesirable characteres
     * @param string $data the value to clean
     * @return string cleaned value of the value passed in param
     */
    public static function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * To get today's date into format ["YYYY-MM-DD HH-MM-SS"]. NOTE: the time 
     * zone is set in Controller's constructor.
     * @return string today's date into format ["YYYY-MM-DD HH-MM-SS"]
     */
    public function getDateTime()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Build a map that use its value as key and as value
     * @return string[string]
     */
    public function fillValueWithValue($values)
    {
        $map = [];
        foreach ($values as $value) {
            $map[$value] = $value;
        }
        return $map;
    }

    /**
     * Remplace blank space with an underscore "_"
     * @param string $value value to encode
     * @return string encoded value
     */
    public function encodeInputString($value)
    {
        return str_replace(" ", self::UNDERSCORE, $value);
    }

    /**
     * Remplace underscore "_"  with an blank space
     * @param string $value encoded value
     * @return string decoded value
     */
    public function decodeInputString($value)
    {
        return str_replace(self::UNDERSCORE, " ", $value);
    }

    /**
     * Generate a alpha numerique sequence in specified length
     * @param int $length
     * @return string alpha numerique sequence in specified length
     */
    // private function generateCode($length)
    public function generateCode($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $sequence = '';
        $nbChar = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, $nbChar);
            $sequence .= $characters[$index];
        }

        return $sequence;
    }

    /**
     * Genarate a sequence code of $length characteres in format 
     * CC...YYMMDDHHmmSSssCC... where C is a alpha numerique sequence. 
     * NOTE: length must be strictly over 14 characteres cause it's the size of the 
     * date time sequence
     * @param int $length the total length
     * @throws Exception if $length is under or equals 14
     * @return string a alpha numerique sequence with more than 14 
     * characteres 
     */
    public function generateDateCode($length)
    {
        $sequence = date("YmdHis");
        $nbChar = strlen($sequence);
        if ($length <= $nbChar) {
            throw new Exception('$length must be strictly over 14');
        }
        $nbCharToAdd = $length - $nbChar;
        switch ($nbCharToAdd % 2) {
            case 0:
                $nbCharLeft = $nbCharRight = ($nbCharToAdd / 2);
                break;
            case 1:
                $nbCharLeft = ($nbCharToAdd - 1) / 2;
                $nbCharRight = $nbCharLeft + 1;
                break;
        }
        $sequence = self::generateCode($nbCharLeft) . $sequence . self::generateCode($nbCharRight);
        $sequence = strtolower($sequence);
        return $sequence;
    }
}
