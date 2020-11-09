<?php

class Pixel
{
    /**
     * Holds configuartion for all pixel
     * @var Map
     * + $configMap[event][Map::type]       {string}        type of the event ('track' | 'trackCustom')
     * + $configMap[event][Map::func]       {string|null}   function to execute to generate pixel's datas in json
     */
    private static $pixelsMap;

    /**
     * Holds pixel type of event
     * @var string
     */
    public const TYPE_TRACK = "track";
    public const TYPE_CUSTOM = "trackCustom";

    /**
     * Holds standard pixel event
     * @var string
     */
    public const EVENT_ADD_TO_CART = "AddToCart";
    public const EVENT_INIT_CHECKOUT = "InitiateCheckout";
    public const EVENT_PURCHASE = "Purchase";
    public const EVENT_VIEW_CONTENT = "ViewContent";

    /**
     * Holds custom pixel event
     * @var string
     */
    public const EVENT_FRIPPERY_STORES = "frippery_stores";
    public const EVENT_USED_FRIPPERY = "used_frippery";
    public const EVENT_LP_TIME_UP = "lp_time_up";
    // public const EVENT_VIEW_PRODUCT_GRID = "view_product_grid";

    /**
     * To set pixelsMap
     */
    private static function setPixelsMap()
    {
        self::$pixelsMap = new Map();

        /** AddToCart */
        self::$pixelsMap->put(self::TYPE_TRACK, self::EVENT_ADD_TO_CART, Map::type);
        self::$pixelsMap->put(self::EVENT_ADD_TO_CART, self::EVENT_ADD_TO_CART, Map::func);

        /** InitiateCheckout */
        self::$pixelsMap->put(self::TYPE_TRACK, self::EVENT_INIT_CHECKOUT, Map::type);
        self::$pixelsMap->put(self::EVENT_INIT_CHECKOUT, self::EVENT_INIT_CHECKOUT, Map::func);

        /** Purchase */
        self::$pixelsMap->put(self::TYPE_TRACK, self::EVENT_PURCHASE, Map::type);
        self::$pixelsMap->put(self::EVENT_PURCHASE, self::EVENT_PURCHASE, Map::func);

        /** ViewContent */
        self::$pixelsMap->put(self::TYPE_TRACK, self::EVENT_VIEW_CONTENT, Map::type);
        self::$pixelsMap->put(self::EVENT_VIEW_CONTENT, self::EVENT_VIEW_CONTENT, Map::func);

        /*———————————————————————— CUSTOM DOWN ——————————————————————————————*/

        /** frippery_stores */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_FRIPPERY_STORES, Map::type);

        /** used_frippery */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_USED_FRIPPERY, Map::type);

        /** lp_time_up */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_LP_TIME_UP, Map::type);

        /** view_product_grid */
        // self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_LP_TIME_UP, Map::type);
    }

    /**
     * To generate the pixel code
     * @param   string    $type     the type of the event ('track' | 'trackCustom')
     * @param   string    $event    the pixel's event
     * @param   array     $params   the pixel's params
     * @return  string pixel code
     */
    private static function generatePixel(string $type, string $event, array $params = null)
    {
        $json = (!empty($params)) ? json_encode($params) : null;
        $pixel = (!empty($json)) ? "fbq('$type', '$event', $json);" : "fbq('$type', '$event');";
        return $pixel;
    }

    /**
     * To get pixel's base code
     * @return string pixel's base code
     */
    public static function getBaseCode()
    {
        ob_start();
        $pixelID = Configuration::get(Configuration::FB_PIXEL_ID);
        require 'model/marketing/facebook/files/pixelBaseCode.php';
        return ob_get_clean();
    }

    /**
     * To get the Facebook pixel for the event given
     * @param string    $type       type of the Pixel ['tracker' | 'trackerCustom']
     * @param string    $event      the event accured
     * @param string    $datasMap   pixel's datas
     * @return string the Facebook pixel for the event given
     */
    public static function getPixel(string $type, string $event, Map $datasMap = null)
    {
        $datasMap = (!empty($datasMap)) ? $datasMap : new Map();
        $pixelsMap = self::getPixelMap();
        $func = $pixelsMap->get($event, Map::func);
        /**
         * @var Map */
        $paramsMap = (!empty($func)) ? self::{$func}($datasMap) : $datasMap;
        $params = (!empty($paramsMap->getMap())) ? $paramsMap->getMap() : null;
        return self::generatePixel($type, $event, $params);
    }

    /**
     * To get pixelMap
     * @return Map pixelMap
     */
    private static function getPixelMap()
    {
        (!isset(self::$pixelsMap)) ? self::setPixelsMap() : null;
        return self::$pixelsMap;
    }

    /**
     * To generate Pixel's datas for product added in cart
     * + Note: required datas => content_type and contents, or content_ids
     * @param Map $datasMap holds the product added in basket
     * + $datasMap[Map::product]
     * @return Map Pixel's datas for product added in cart
     */
    private static function AddToCart(Map $datasMap)
    {
        /**
         * @var Product */
        $product = $datasMap->get(Map::product);
        if(empty($product))
        {
            throw new Exception("The product can't be empty");
        }
        $paramsMap = new Map();

        /*  id of similar products => ['ABC123', 'XYZ789'] */
        $paramsMap->put([$product->getProdID()], Map::content_ids);
        /*  product's name */
        $paramsMap->put($product->getProdName(), Map::content_name);
        /*  product or product_group */
        $paramsMap->put(Map::product, Map::content_type);
        $contents = [
            [Map::id => $product->getProdID(), Map::quantity => $product->getQuantity()]
        ];
        /*  [{'id': 'ABC123', 'quantity': 2}, {'id': 'XYZ789', 'quantity': 2}] */
        $paramsMap->put($contents, Map::contents);
        $price = $product->getPrice();
        /*  currency */
        $paramsMap->put($price->getCurrency()->getIsoCurrency(), Map::currency);
        /*  price {int|float} */
        $paramsMap->put($price->getPrice(), Map::value);

        return $paramsMap;
    }

    /**
     * To generate Pixel's datas for checkout initiated
     * @param Map $datasMap Basket's datas
     * + $datasMap[Map::basket] {Basket}    Visitor's Basket
     * @return Map Pixel's datas for checkout initiated
     */
    private static function InitiateCheckout(Map $datasMap)
    {
        /**
         * @var Basket */
        $basket = $datasMap->get(Map::basket);
        $boxes = $basket->getBoxes();
        if (empty($boxes)) {
            throw new Exception("Boxes can't be empty");
        }
        $paramsMap = new Map();

        /*  id of similar products => ['ABC123', 'XYZ789'] */
        $content_ids = new Map();
        /*  [{'id': 'ABC123', 'quantity': 2}, {'id': 'XYZ789', 'quantity': 2}] */
        $contents = new Map();
        $tr = 0;
        foreach ($boxes as $box) {
            $products = $box->getProducts();
            foreach ($products as $product) {
                $content_ids->put($product->getProdID(), $tr);
                $contents->put($product->getProdID(), $tr, Map::id);
                $contents->put($product->getQuantity(), $tr, Map::quantity);
                $tr++;
            }
        }

        $total = $basket->getTotal();
        $isoCurrency = $total->getCurrency()->getIsoCurrency();
        $value = $total->getPrice();

        $paramsMap->put($content_ids->getMap(), Map::content_ids);
        $paramsMap->put($contents->getMap(), Map::contents);
        $paramsMap->put($tr, Map::num_items);
        $paramsMap->put($isoCurrency, Map::currency);
        $paramsMap->put($value, Map::value);
        return $paramsMap;
    }

    /**
     * To generate Pixel's datas for purchase done
     * @param Map $datasMap Order's datas
     * + $datasMap[Map::order] {Order}  Visitor's Order purchased
     * @return Map Pixel's datas for purchase done
     */
    private static function Purchase(Map $datasMap)
    {
        /**
         * @var Order */
        $order = $datasMap->get(Map::order);
        
        $basketOrdered = $order->getBasketOrdered();
        $boxes = $basketOrdered->getBoxes();
        if (empty($boxes)) {
            throw new Exception("boxes can't be empty");
        }
        $paramsMap = new Map();
        
        $content_ids = new Map();
        $contents = new Map();

        $tr = 0;
        foreach ($boxes as $box) {
            $products = $box->getProducts();
            foreach ($products as $product) {
                $content_ids->put($product->getProdID(), $tr);
                $contents->put($product->getProdID(), $tr, Map::id);
                $contents->put($product->getQuantity(), $tr, Map::quantity);
                $tr++;
            }
        }

        $total = $basketOrdered->getTotal();
        $isoCurrency = $total->getCurrency()->getIsoCurrency();
        $value = $total->getPrice();

        /*  id of similar products => ['ABC123', 'XYZ789'] */
        $paramsMap->put($content_ids->getMap(), Map::content_ids);
        /*  product or product_group */
        $paramsMap->put(Map::product, Map::content_type);
        /*  [{'id': 'ABC123', 'quantity': 2}, {'id': 'XYZ789', 'quantity': 2}] */
        $paramsMap->put($contents->getMap(), Map::contents);
        /** number of product */
        $paramsMap->put($tr, Map::num_items);
        /*  iso currency */
        $paramsMap->put($isoCurrency, Map::currency);
        /*  price {int|float} */
        $paramsMap->put($value, Map::value);

        return $paramsMap;
    }

    /**
     * To generate Pixel's datas for product seen
     * @param Map $datasMap Product's datas
     * + $datasMap[Map::product]    {Product}   product seen
     * @return Map Pixel's datas product seen
     */
    private static function ViewContent(Map $datasMap)
    {
        /**
         * @var Product */
        $product = $datasMap->get(Map::product);
        if(empty($product))
        {
            throw new Exception("The product can't be empty");
        }

        $paramsMap = new Map();
        /*  id of similar products => ['ABC123', 'XYZ789'] */
        $paramsMap->put([$product->getProdID()], Map::content_ids);
        /** product's category */
        $paramsMap->put($product->getCategories()[0], Map::content_category);
        /*  product's name */
        $paramsMap->put($product->getProdName(), Map::content_name);
        /*  product or product_group */
        $paramsMap->put(Map::product, Map::content_type);
        $contents = [
            [Map::id => $product->getProdID(), Map::quantity => $product->getQuantity()]
        ];
        /*  [{'id': 'ABC123', 'quantity': 2}, {'id': 'XYZ789', 'quantity': 2}] */
        $paramsMap->put($contents, Map::contents);
        $price = $product->getPrice();
        /*  currency */
        $paramsMap->put($price->getCurrency()->getIsoCurrency(), Map::currency);
        /*  price {int|float} */
        $paramsMap->put($price->getPrice(), Map::value);
        return $paramsMap;
    }
}
