<?php

require_once 'model/users-management/User.php';

class Client extends User
{
    /**
     * Holds the class's name
     */
    public const CLASS_NAME = "Client";

    /**
     * Show if the Client is subcribed to the newsletter
     * @var boolean true if user is subcribed to the newsletter else false
     */
    private $newsletter;

    // /**
    //  * List of orders passed by the Client.
    //  * Use the order's setDate in Unix time format (secondes) as access key 
    //  * like $orders[setDateUnix => Order]
    //  * @var Order[]
    //  */
    // private $orders;


    /**
     * Constructor
     * @param string $CLT_VAL value of the user's Client  cookie (Cookie::COOKIE_CLT)
     */
    function __construct($CLT_VAL = null)
    {
        $CLT_VAL = (empty($CLT_VAL)) ? Cookie::getCookieValue(Cookie::COOKIE_CLT) : $CLT_VAL;
        if (empty($CLT_VAL)) {
            throw new Exception("Client cookie don't exist");
        }
        parent::__construct($CLT_VAL);
        $this->newsletter = (bool) $this->userLine["newsletter"];
        $this->setMeasure();
        $this->manageCookie(Cookie::COOKIE_CLT, true);
    }

    // /**
    //  * Create an order once the Client has paid
    //  * @var array $dbMap of Database's tables
    //  * @var Basket $basket of the Client
    //  */
    // public function order($basket, $dbMap)
    // {
    //     $order = new Order($dbMap, $basket);
    //     $key =  $order->getDateInSec();
    //     $this->orders[$key] = $order;
    //     ksort($this->orders);
    // }
}
