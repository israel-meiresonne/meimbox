<?php

class Client extends User {
    /**
     * Show if the Client is subcribed to the newsletter
     * @var boolean true if user is subcribed to the newsletter else false
     */
    private $newsletter;

    /**
     * List of orders passed by the Client.
     * Use the order's setDate in Unix time format (secondes) as access key 
     * like $orders[setDateUnix => Order]
     * @var Order[]
     */
    private $orders;
    

    /**
     * Constructor
     * @param int $userID
     */
    function __construct($dbMap)
    {
        parent::__construct($dbMap);
        // $this->orders = self::getOrders();
        $this->newsletter = (boolean) $dbMap["usersMap"]["userDatas"]["newsletter"];
    }

    /**
     * Create an order once the Client has paid
     * @var array $dbMap of Database's tables
     * @var Basket $basket of the Client
     */
    public function order($basket, $dbMap){
        $order = new Order($dbMap, $basket);
        $key =  $order->getDateInSec();
        $this->orders[$key] = $order;
        ksort($this->orders);
    }

    public function __toString()
    {
        parent::__toString();
        Helper::printLabelValue("newsletter", $this->newsletter);
    }

}