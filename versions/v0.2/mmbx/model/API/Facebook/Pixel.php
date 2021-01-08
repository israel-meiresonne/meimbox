<?php
require_once 'model/API/Facebook/Facebook.php';

class Pixel extends Facebook
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
    public const TYPE_STANDARD = "track";
    public const TYPE_CUSTOM = "trackCustom";

    /**
     * Holds standard pixel event
     * @var string
     */
    public const EVENT_VIEW_CONTENT = "ViewContent";
    public const EVENT_ADD_TO_CART = "AddToCart";
    public const EVENT_INIT_CHECKOUT = "InitiateCheckout";
    public const EVENT_PURCHASE = "Purchase";

    /**
     * Holds custom pixel event
     * @var string
     */
    public const EVENT_FRIPPERY_STORES = "frippery_stores";
    public const EVENT_USED_FRIPPERY = "used_frippery";
    public const EVENT_SCROLL_OVER = "scroll_over";
    public const EVENT_NEW_BOX = "add_new_box";
    public const EVENT_YOUTUBE_FRIPPERY_FOLLOWERS = "youtube_frippery_followers";

    /**
     * Holds acces key to get Pixel
     */
    public const KEY_FB_PXL = "key_fb_pxl";
    public const KEY_FB_PXL_DT = "key_fb_pxl_dt";
    // public const KEY_PAGE = "page";

    /**
     * To set pixelsMap
     */
    private static function setPixelsMap()
    {
        self::$pixelsMap = new Map();

        /** AddToCart */
        self::$pixelsMap->put(self::TYPE_STANDARD,      self::EVENT_ADD_TO_CART, Map::type);
        self::$pixelsMap->put(self::EVENT_ADD_TO_CART,  self::EVENT_ADD_TO_CART, Map::func);

        /** InitiateCheckout */
        self::$pixelsMap->put(self::TYPE_STANDARD,          self::EVENT_INIT_CHECKOUT, Map::type);
        self::$pixelsMap->put(self::EVENT_INIT_CHECKOUT,    self::EVENT_INIT_CHECKOUT, Map::func);

        /** Purchase */
        self::$pixelsMap->put(self::TYPE_STANDARD,  self::EVENT_PURCHASE, Map::type);
        self::$pixelsMap->put(self::EVENT_PURCHASE, self::EVENT_PURCHASE, Map::func);

        /** ViewContent */
        self::$pixelsMap->put(self::TYPE_STANDARD,      self::EVENT_VIEW_CONTENT, Map::type);
        self::$pixelsMap->put(self::EVENT_VIEW_CONTENT, self::EVENT_VIEW_CONTENT, Map::func);

        /*———————————————————————— CUSTOM DOWN ——————————————————————————————*/

        /** frippery_stores */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_FRIPPERY_STORES, Map::type);

        /** used_frippery */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_USED_FRIPPERY, Map::type);

        /** scroll_over */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_SCROLL_OVER, Map::type);

        /** add_new_box */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_NEW_BOX, Map::type);
        self::$pixelsMap->put(self::EVENT_NEW_BOX, self::EVENT_NEW_BOX, Map::func);

        /** youtube_frippery_followers */
        self::$pixelsMap->put(self::TYPE_CUSTOM, self::EVENT_YOUTUBE_FRIPPERY_FOLLOWERS, Map::type);
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
        $calling = self::getCallingClass();
        $correct = Facebook::class;
        if ($calling != $correct) {
            $f = __FUNCTION__;
            throw new Exception("function '$f' is called from '$calling' instead of '$correct'");
        }
        $pixelID = Configuration::get(Configuration::FB_PIXEL_ID);
        $datas = [
            "pixelID" => $pixelID
        ];
        return parent::generateFile('model/API/Facebook/files/content/pixelBaseCode.php', $datas);
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
        $calling = self::getCallingClass();
        $correct = Facebook::class;
        if ($calling != $correct) {
            $f = __FUNCTION__;
            throw new Exception("function '$f' is called from '$calling' instead of '$correct'");
        }
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
     * To generate Pixel's datas for product seen
     * @param Map $datasMap Product's datas
     *                      + $datasMap[Map::product] => {Product}   product seen
     * @return Map Pixel's datas product seen
     */
    private static function ViewContent(Map $datasMap)
    {
        /**
         * @var Product */
        $product = $datasMap->get(Map::product);
        if (empty($product)) {
            throw new Exception("The product can't be empty");
        }
        $paramsMap = new Map();
        /*  id of similar products => ['ABC123', 'XYZ789'] */
        $paramsMap->put([$product->getProdID()], Map::content_ids);
        /** product's category */
        $paramsMap->put($product->getForeignCategory(Product::CATEGORY_GOOGLE), Map::content_category);
        /*  product's name */
        $paramsMap->put($product->getProdName(), Map::content_name);
        /*  product or product_group */
        $paramsMap->put(Map::product, Map::content_type);
        /*  [{'id': 'ABC123', 'quantity': 2}, {'id': 'XYZ789', 'quantity': 2}] */
        $stock = $product->getSizeStock();
        $quantity = array_sum($stock);
        $contents = [
            // [Map::id => $product->getProdID(), Map::quantity => $product->getQuantity()]
            [Map::id => $product->getProdID(), Map::quantity => $quantity]
        ];
        $paramsMap->put($contents, Map::contents);
        /*  currency */
        $price = $product->getPrice();
        $paramsMap->put($price->getCurrency()->getIsoCurrency(), Map::currency);
        /*  price {int|float} */
        $paramsMap->put($price->getPrice(), Map::value);
        return $paramsMap;
    }

    /**
     * To generate Pixel's datas for product added in cart
     * + Note: required datas => content_type and contents, or content_ids
     * @param Map $datasMap holds the product added in basket
     *                      + $datasMap[Map::product] => {Product}
     * @return Map Pixel's datas for product added in cart
     */
    private static function AddToCart(Map $datasMap)
    {
        /**
         * @var Product */
        $product = $datasMap->get(Map::product);
        if (empty($product)) {
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
     *                      + $datasMap[Map::basket] => {Basket}   Visitor's Basket
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

        $paramsMap->put(Map::product, Map::content_type);
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
     *                      + $datasMap[Map::order] {Order}  Visitor's Order purchased
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

    /*———————————————————————— CUSTOM DOWN ——————————————————————————————*/

    /**
     * To genrate event's datas for new box added in basket
     * @param Map $datasMap holds the box added in basket
     *                      + $datasMap[Map::box] => {Box}
     */
    private static function add_new_box(Map $datasMap)
    {
        /**
         * @var Box */
        $box = $datasMap->get(Map::box);
        if (empty($box)) {
            throw new Exception("The box can't be empty");
        }
        $paramsMap = new Map();
        $price = $box->getPrice();
        $paramsMap->put($box->getColor(), Box::KEY_BOX_COLOR);
        $paramsMap->put($price->getCurrency()->getIsoCurrency(), Map::currency);
        $paramsMap->put($price->getPrice(), Map::value);
        return $paramsMap;
    }
}
