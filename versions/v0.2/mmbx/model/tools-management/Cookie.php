<?php
// require_once 'model/special/Map.php';

/**
 * Represent a cookie from $_COOKIE
 */
class Cookie
{

    /**
     * Holds cookie's id
     * @var string
     */
    private $cookieID;

    /**
     * Holds cookie's value
     * @var string
     */
    private $value;

    /**
     * Holds cookie's create date
     * @var string
     */
    private $setDate;

    /**
     * Holds availability period SETTED on the cookie
     * @var int
     */
    private $settedPeriod;

    /**
     * Holds availability period TO SET on the cookie
     * @var int
     */
    private $period;

    /**
     * Holds the domain where the cookie will be available
     * + ex: iadnmeim.com
     * @var string
     */
    private $domain;

    /**
     * Holds the directory where the cookie will be available
     * + ex: /my/directory
     * @var string
     */
    private $path;

    /**
     * Indicate if this cookie can be given only in a secured connection (https)
     * + Set true to indicate that this cookie can be given only in a secured 
     * connection else false
     * @var boolean
     */
    private $secure;

    /**
     * Set true to indicate that this cookie can get only through a http 
     * protocol. Its mean that the cookie con't be get with a script language 
     * like Javascript
     * @var boolean
     */
    private $httponly;

    // /**
    //  * Constructor
    //  */
    // public function __construct(Map $datas)
    // {
    //     $args = func_get_args();
    //     switch (func_num_args()) {
    //         case 4:
    //             $this->__construct4($args[0], $args[1], $args[2], $args[3]);
    //             break;

    //         default:
    //             # code...
    //             break;
    //     }
    // }

    /**
     * Constructor
     * @param string $cookieID cookie's id
     * @param string $value cookie's value
     * @param string $setDate cookie's create date
     * @param int $settedPeriod availability period SETTED on the cookie
     */
    private function __construct($cookieID, $value, $setDate, $settedPeriod)
    {
        $this->cookieID = $cookieID;
        $this->value = $value;
        $this->setDate = $setDate;
        $this->settedPeriod = $settedPeriod;
    }
}
