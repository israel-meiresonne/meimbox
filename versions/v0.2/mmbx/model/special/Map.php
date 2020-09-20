<?php

/**
 * This class is a map for holds datas
 */
class Map
{
    private $map;

    public const prodID = "prodID";
    public const sizeType = "sizeType";
    public const size = "size";
    public const brand = "brand";
    public const measureID = "measureID";
    public const cut = "cut";
    public const quantity = "quantity";

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
            $this->map[$key] = $this->putRec($data, $keys, 1);
        }
    }

    private function putRec($data, $keys, $i)
    {
        if ($i < count($keys)) {
            $key = $keys[$i];
            $recMap[$key] = $this->putRec($data, $keys, ++$i);
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
        if (count($keys) == 1) {
            $key = $keys[0];
            return $this->map[$key];
        } else {
            $key = $keys[0];
            return $this->getRec($this->map[$key], $keys, 1);
        }
    }

    private function getRec($recMap, $keys, $i)
    {
        if ($i == (count($keys) - 1)) {
            $key = $keys[$i];
            return $recMap[$key];
        } else {
            $key = $keys[$i];
            return $this->getRec($recMap[$key], $keys, ++$i);
        }
    }
}
