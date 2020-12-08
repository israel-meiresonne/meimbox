<?php

use function PHPSTORM_META\type;

/**
 * This class is a map for holds datas
 */
class Map
{
    private $map;
    public const setDate = "setDate";
    public const value = "value";
    public const properties = "properties";
    public const price = "price";
    public const picture = "picture";
    public const link = "link";
    public const sql = "sql";
    public const side = "side";
    public const vertical = "vertical";
    public const error = "error";
    public const attribut = "attribut";
    public const open = "open";
    public const close = "close";

    /**
     * Keys for Mosaic
     */
    public const width = "width";
    public const height = "height";
    public const isTreated = "isTreated";
    public const col = "col";
    public const row = "row";
    public const rowStart = "rowStart";
    public const colStart = "colStart";
    public const rowEnd = "rowEnd";
    public const colEnd = "colEnd";
    public const containerClass = "containerClass";
    public const sizerClass = "sizerClass";
    public const stoneClass = "stoneClass";
    public const css = "css";

    /**
     * key for User
     * @var string
     */
    public const userID = "userID";
    public const max = "max";
    public const nbItem = "nbItem";

    /**
     * key for Country
     * @var string
     */
    public const isoCountry = "isoCountry";
    public const isoCurrency = "iso_currency";
    public const isUE = "isUE";
    public const vat = "vat";
    public const country = "country";

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
    public const cookieValue = "cookieValue";
    public const settedPeriod = "settedPeriod";
    public const period = "period";
    public const domain = "domain";
    public const path = "path";
    public const secure = "secure";
    public const httponly = "httponly";
    public const cookies = "cookies";

    /**
     * Key for sign forrm
     * @var string
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
     * @var string
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

    /**
     * Keys for Address
     * @var string
     */
    public const address = "address";
    public const appartement = "appartement";
    public const province = "province";
    public const city = "city";
    public const zipcode = "zipcode";
    public const countryName = "countryName";
    public const phone = "phone";
    public const state = "state";

    /**
     * Keys for Order
     * @var string
     */
    public const order = "order";

    /**
     * Keys for Payements
     * @var string
     */
    public const payMethod = "payMethod";
    public const company = "company";
    public const cancelPath = "cancelPath";
    public const successPath = "successPath";

    /**
     * Keys for StripeProduct
     * @var string
     */
    public  const name = "name";
    public  const currency = "currency";
    public  const unit_amount = "unit_amount";
    public  const description = "description";
    public  const images = "images";

    /**
     * Keys for ViewEmail
     * @var string
     */
    public const template = "template";
    public const templateFile = "templateFile";
    public const https_webroot = "https_webroot";
    public const dir_email_files = "dir_email_files";
    public const dir_prod_files = "dir_prod_files";

    /**
     * Keys for SendinBlue's mail sender
     * @var string
     */
    public const sender = "sender";
    public const to = "to";
    public const bcc = "bcc";
    public const cc = "cc";
    public const htmlContent = "htmlContent";
    public const textContent = "textContent";
    public const subject = "subject";
    public const replyTo = "replyTo";
    public const attachment = "attachment";
    public const headers = "headers";
    public const templateId = "templateId";
    public const params = "params";
    public const tags = "tags";
    public const messageId = "messageId";
    public const code = "code";
    public const message = "message";

    /**
     * Keys for company datas
     * @var string
     */
    public const media = "media";
    public const logo = "logo";

    /**
     * Keys for mailing from datas.json
     * @var string
     */
    public const order_confirmation = "order_confirmation";

    /**
     * Keys for Sendinblue event
     * @var string
     */
    public const message_id = "message-id";
    public const event = "event";
    public const reason = "reason";
    // public const link = "link";
    public const sending_ip = "sending_ip";
    public const ts_sent = "ts_sent";       // timestamp in seconds of when message was sent
    public const ts_event = "ts_event";     // timestamp in seconds of when event occurred

    /**
     * Keys for Facebook's Pixel
     * @var string
     */
    public const json = "json";
    public const func = "func";
    public const content_ids = "content_ids";
    public const content_name = "content_name";
    public const content_type = "content_type";
    public const contents = "contents";
    // public const currency = "currency";
    // public const value = "value";
    public const product = "product";
    public const product_group = "product_group";
    public const id = "id";
    public const type = "type";
    public const basket = "basket";
    public const num_items = "num_items";
    public const content_category = "content_category";
    public const datasMap = "datasMap";

    /**
     * Keys for Device
     * @var string
     */
    public const os = "os";
    public const clientInfo = "clientInfo";
    public const device = "device";
    // public const brand = "brand";
    public const model = "model";

    /**
     * Keys for Page
     * @var string
     */
    public const query = "query";

    /**
     * Keys for DiscountCode
     * @var string
     */
    public const discountCodes = "discountCodes";



    /**
     * Constructor
     * @param array $map if set this array will be used as initial map
     */
    public function __construct(array $map = null)
    {
        $this->map = (!empty($map)) ? $map : [];
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
            if (key_exists($key, $this->map)) {
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
            if (key_exists($key, $recMap)) {
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
     * To get the content of the map
     * @return mixed[] the content of the map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * To get of the first array of the map
     * @return mixed[] the first array of the map
     */
    public function getKeys()
    {
        return array_keys($this->map);
    }

    /**
     * To merge this Map with the Map|array given
     * @param array|Map $map 
     */
    public function merge($map)
    {
        $type = gettype($map);
        switch ($type) {
            case 'array':
                $this->map = array_merge($this->map, $map);
                break;
            case 'object':
                if (get_class($map) != Map::class) {
                    throw new Exception("Can merge Map only with an array or a Map");
                }
                $this->map = array_merge($this->map, $map->map);
                break;

            default:
                throw new Exception("Try to merge a unsupported type, type:'$type'");
                break;
        }
    }

    /**
     * to sort key from the hight value to the lower
     */
    public function sortKeyDesc()
    {
        krsort($this->map);
    }
    /**
     * to sort key from the lower value to the highest
     */
    public function sortKeyAsc()
    {
        ksort($this->map);
    }
}
