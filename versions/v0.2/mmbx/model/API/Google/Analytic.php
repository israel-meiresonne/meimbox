<?php
require_once 'model/ModelFunctionality.php';

/**
 * This class is used to manage features of Google Analytic's API
 */
class Analytic extends ModelFunctionality
{
    /**
     * Holds config for all events
     * @var Map
     * + eventsMap[event][Map::func]    {string|null}   function to execute to generate event's datas in json
     * + eventsMap[event][Map::event_category] {string|null}   event's category to group them
     * + eventsMap[event][Map::event_label]    {string|null}   event's label
     * + eventsMap[event][Map::value]          {int}           event's value that can be used as
     *                                                                      number of value of the event
     */
    private static $eventsMap;

    /**
     * Holds Analytic's default events
     * @var string
     */
    public const EVENT_VIEW_CONTENT = "view_item";
    public const EVENT_ADD_TO_CART = "add_to_cart";
    public const EVENT_ADD_SHIPPING = "add_shipping_info";
    public const EVENT_INIT_CHECKOUT = "begin_checkout";
    public const EVENT_PURCHASE = "purchase";
    public const EVENT_SUBSCRIBE = "generate_lead";
    public const EVENT_LOADING_TIME = "timing_complete";

    /**
     * Holds custom events
     * @var string
     */
    public const EVENT_SCROLL_OVER = "scroll_over";
    public const EVENT_NEW_BOX = "add_new_box";
    public const EVENT_GOOGLE_FRIPPERY_FOLLOWERS = "google_frippery_followers";

    /**
     * Holds access key
     */
    public const KEY_GG_EVT = "key_gg_evt";

    /**
     * To set eventsMap
     */
    private static function setEventsMap()
    {
        self::$eventsMap = new Map();

        /** view_item */
        self::$eventsMap->put(self::EVENT_VIEW_CONTENT,     self::EVENT_VIEW_CONTENT, Map::func);
        /** add_to_cart */
        self::$eventsMap->put(self::EVENT_ADD_TO_CART,      self::EVENT_ADD_TO_CART, Map::func);
        /** add_shipping_info */
        self::$eventsMap->put(self::EVENT_ADD_SHIPPING,     self::EVENT_ADD_SHIPPING, Map::func);
        /** begin_checkout */
        self::$eventsMap->put(self::EVENT_INIT_CHECKOUT,    self::EVENT_INIT_CHECKOUT, Map::func);
        /** purchase */
        self::$eventsMap->put(self::EVENT_PURCHASE,         self::EVENT_PURCHASE, Map::func);
        /** generate_lead */
        self::$eventsMap->put(self::EVENT_SUBSCRIBE,        self::EVENT_SUBSCRIBE, Map::func);
        /** timing_complete */
        self::$eventsMap->put(self::EVENT_LOADING_TIME,     self::EVENT_LOADING_TIME, Map::func);
        /*———————————————————————— CUSTOM DOWN ——————————————————————————————*/
        /** scroll_over */
        self::$eventsMap->put(self::EVENT_SCROLL_OVER,                  self::EVENT_SCROLL_OVER, Map::action);
        /** add_new_box */
        self::$eventsMap->put(self::EVENT_NEW_BOX,                      self::EVENT_NEW_BOX, Map::func);
        self::$eventsMap->put(self::EVENT_NEW_BOX,                      self::EVENT_NEW_BOX, Map::action);
        /** google_frippery_followers */
        self::$eventsMap->put(self::EVENT_GOOGLE_FRIPPERY_FOLLOWERS,    self::EVENT_GOOGLE_FRIPPERY_FOLLOWERS, Map::action);
    }

    /**
     * To generate event code
     * @param string    $event      an event's name
     * @param array     $params     event's datas
     * @return string event code of the given event
     */
    private static function generateEvent(string $event, array $params = null)
    {
        $json = (!empty($params)) ? json_encode($params) : null;
        $eventCode = (!empty($json)) ? "gtag('event','$event',$json);" : "gtag('event','$event');";
        return $eventCode;
    }

    /**
     * To get Google Analytic's base code
     * @return string Google Analytic's base code
     */
    public static function getBaseCode()
    {
        $tagID = Configuration::get(Configuration::GOOGLE_MEASURE_ID);
        $datas = [
            "tagID" => $tagID,
            "debug" => (Configuration::getEnvironement() == Configuration::ENV_DEV)
            // "debug" => (Configuration::ENV_PROD == Configuration::ENV_DEV)
        ];
        return self::generateFile('model/API/Google/files/analyticBaseCode.php', $datas);
    }

    /**
     * To get Analytic's event code corresponding to the given event
     * @param string    $event      an event's name
     * @param Map    $datasMap   event's datas
     * @return string event code of the given event
     */
    public static function getEvent(string $event, Map $datasMap = null)
    {
        $calling = self::getCallingClass();
        $correct = Google::class;
        if ($calling != $correct) {
            throw new Exception("method getEvent is called from '$calling' instead of '$correct'");
        }
        $datasMap = (!empty($datasMap)) ? $datasMap : new Map();
        $eventsMap = self::getEventsMap();
        if (!in_array($event, $eventsMap->getKeys())) {
            throw new Exception("This event '$event' is not supported");
        }
        $func = $eventsMap->get($event, Map::func);
        /**
         * @var Map */
        $paramsMap = (!empty($func)) ? self::{$func}($datasMap) : $datasMap;
        $params = (!empty($paramsMap->getMap())) ? $paramsMap->getMap() : null;
        return self::generateEvent($event, $params);
    }

    /**
     * To get config map of Analytic's events
     * @return Map config map of Analytic's events
     */
    private static function getEventsMap()
    {
        (!isset(self::$eventsMap)) ? self::setEventsMap() : null;
        return self::$eventsMap;
    }

    /**
     * To generate event's datas for product seen
     * @param Map $datasMap Product's datas
     *                      + $datasMap[Map::product] => {Product}   product seen
     * @return Map event's datas product seen
     */
    private static function view_item(Map $datasMap)
    {
        /**
         * @var Product */
        $product = $datasMap->get(Map::product);
        if (empty($product)) {
            throw new Exception("The product can't be empty");
        }
        $paramsMap = new Map();
        $currency = $product->getCurrency();
        $isoCurrency = $currency->getIsoCurrency();
        $paramsMap->put($isoCurrency,                           Map::currency);
        $paramsMap->put($product->getPrice()->getPriceRounded(),Map::value);

        $itemsMap = self::extractProduct($product);
        $paramsMap->put($itemsMap->getMap(), Map::items);
        return $paramsMap;
    }

    /**
     * To generate Event's datas for product added in basket
     * @param Map $datasMap holds the product added in basket
     *                      + $datasMap[Map::product] => {Product}
     * @return Map Pixel's datas for product added in basket
     */
    private static function add_to_cart(Map $datasMap)
    {
        /**
         * @var Product */
        $product = $datasMap->get(Map::product);
        if (empty($product)) {
            throw new Exception("The product can't be empty");
        }
        $paramsMap = new Map();
        $currency = $product->getCurrency();
        $isoCurrency = $currency->getIsoCurrency();
        $paramsMap->put($isoCurrency,                           Map::currency);
        $paramsMap->put($product->getPrice()->getPriceRounded(),Map::value);

        $itemsMap = self::extractProduct($product);
        $paramsMap->put($itemsMap->getMap(), Map::items);
        return $paramsMap;
    }

    /**
     * To convert Product into Google item
     * @param Product $product product to convert
     * @return Map Product converted into Google item
     */
    private static function extractProduct(Product $product)
    {
        $itemsMap = new Map();
        $nb = 0;
        $language = $product->getLanguage();
        $country = $product->getCountry();
        $currency = $product->getCurrency();
        $isoCurrency = $currency->getIsoCurrency();

        $price = Box::getAvgPricePerItem($language, $country, $currency);
        $itemsMap->put($product->getProdID(),               $nb, Map::item_id);
        $itemsMap->put($product->getProdName(),             $nb, Map::item_name);
        $itemsMap->put(1,                                   $nb, Map::quantity);
        $itemsMap->put($product->getCategories()[0],        $nb, Map::item_category);
        $itemsMap->put($product->getColorName(),            $nb, Map::item_variant);
        $itemsMap->put($price->getPriceRounded(),           $nb, Map::price);
        $itemsMap->put($isoCurrency,                        $nb, Map::currency);

        return $itemsMap;
    }

    /*———————————————————————————— CUSTOM DOWN ——————————————————————————————*/

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
        $paramsMap->put($box->getColor(), Map::event_label);
        $paramsMap->put($box->getPrice()->getPriceRounded(), Map::value);
        return $paramsMap;
    }
}
