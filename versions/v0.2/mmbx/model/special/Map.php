<?php

/**
 * This class is a map for holds datas
 */
class Map
{
    private $map;
    public const setDate = "setDate";
    public const value = "value";
    
    /**
     * key for Country
     * @var string
     */
    public const isoCountry = "isoCountry";
    public const isoCurrency = "iso_currency";
    public const isUE = "isUE";
    public const vat = "vat";
    
    /**
     * key for Size
     * @var string
     */
    public const prodID = "prodID";
    public const sizeType = "sizeType";
    public const size = "size";
    public const brand = "brand";
    // public const measureID = "measureID";
    public const cut = "cut";
    public const quantity = "quantity";
    
    /**
     * key for Measure
     * @var string
     */
    public const measureID = "measureID";
    public const measureName = "measureName";
    public const bust = "bust";
    public const arm = "arm";
    public const waist = "waist";
    public const hip = "hip";
    public const inseam = "inseam";

    /**
     * key for MeasureUnit
     * @var string
     */
    public const unitName = "unitName";

    /**
     * key for input datas
     * @var string
     */
    public const inputName = "inputName";
    public const inputValue = "inputValue";
    public const isChecked = "isChecked";
    public const inputFunc = "inputFunc";
  
    /**
     * key for Cookie
     * @var string
     */
    public const cookieID = "cookieID";
    public const settedPeriod = "settedPeriod";
    public const period = "period";
    public const domain = "domain";
    public const path = "path";
    public const secure = "secure";
    public const httponly = "httponly";

    /**
     * Key for sign forrm
     */
    public const sex = "sex";
    public const condition = "condition";
    public const newsletter = "newsletter";
    public const firstname = "firstname";
    public const lastname = "lastname";
    public const email = "email";
    public const password = "password";
    public const confirmPassword = "confirmPassword";
    public const remember = "remember";

    /**
     * Keys for input type
     */
    public const color = "color";
    public const date = "date";
    // public const email = "email";
    public const file = "file";
    public const image = "image";
    public const month = "month";
    public const number = "number";
    // public const password = "password";
    public const range = "range";
    public const reset = "reset";
    public const search = "search";
    public const submit = "submit";
    public const tel = "tel";
    public const text = "text";
    public const time = "time";
    public const url = "url";
    public const week = "week";

    public function __construct()
    {
        $this->map = [];
    }

    /**
     * to place data in map
     * @param mixed $data data to place
     * @param mixed $keys key where to place data
     * + ex: put(5, "toma", "age") => map["toma"]["age"] = 5
     */
    public function put($data, ...$keys)
    {
        if (empty($keys)) {
            throw new Exception("\$kyes can't be empty");
        }
        if (count($keys) == 1) {
            $key = $keys[0];
            $this->map[$key] = $data;
        } else {
            $key = $keys[0];
            if(key_exists($key, $this->map)){
                $this->map[$key] = $this->putRec($this->map[$key], $data, $keys, 1);
            } else {
                $this->map[$key] = $this->putRec([], $data, $keys, 1);
            }
        }
    }

    private function putRec($recMap, $data, $keys, $i)
    {
        if ($i < count($keys)) {
            $key = $keys[$i];
            if(key_exists($key, $recMap)){
                $recMap[$key] = $this->putRec($recMap[$key], $data, $keys, ++$i);
            } else {
                $recMap[$key] = $this->putRec([], $data, $keys, ++$i);
            }
            return $recMap;
        } else {
            return $data;
        }
    }

    /**
     * to get data placed in map
     * @param mixed $keys key where to get data
     * + ex: put("toma", "age") => map["toma"]["age"] => value
     * @return mixed data to get
     */
    public function get(...$keys)
    {
        if (empty($keys)) {
            throw new Exception("\$kyes can't be empty");
        }
        $data = null;
        if (count($keys) == 1) {
            $key = $keys[0];
            $data = ((gettype($this->map) == "array") && key_exists($key, $this->map)) ?  $this->map[$key] : null;
        } else {
            $key = $keys[0];
            $data = ((gettype($this->map) == "array") && key_exists($key, $this->map)) ? $this->getRec($this->map[$key], $keys, 1) : null;
        }
        return $data;
    }

    private function getRec($recMap, $keys, $i)
    {
        if ($i == (count($keys) - 1)) {
            $key = $keys[$i];
            return ((gettype($recMap) == "array") && key_exists($key, $recMap)) ? $recMap[$key] : null;
        } else {
            $key = $keys[$i];
            return ((gettype($recMap) == "array") && key_exists($key, $recMap)) ? $this->getRec($recMap[$key], $keys, ++$i) : null;
        }
    }

    /**
     * To get of the first array of the map
     * @return mixed[] the first array of the map
     */
    public function getKeys()
    {
        return array_keys($this->map);
    }
}
