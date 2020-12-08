<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/special/Response.php';

/**
 * This class represent a status of an order
 */
class Status extends ModelFunctionality

{

    /**
     * Holds the id of the Administrator who has created the status
     * @var string 
     */
    private $adminID;

    /**
     * Holds the status
     * @var string 
     */
    private $status;

    /**
     * Holds tracking code of an order
     * @var string 
     */
    private $tracking;

    /**
     * Holds the min time of delivery
     * @var string 
     */
    private $deliveryMin;

    /**
     * Holds the max time of delivery
     * @var string 
     */
    private $deliveryMax;

    /**
     * Holds the creation date of the status
     * @var string 
     */
    private $setDate;

    /**
     * The default value give to a new order's status
     * @var string
     */
    private static $ORDER_DEFAULT_STATUS;

    /**
     * Holds the id of the Aministrator System
     * @var string
     */
    private static $ORDER_STATUS_STOCK_ERROR;

    /**
     * Holds the id of the Aministrator System
     * @var string
     */
    private static $SYSTEM_ID;

    /**
     * Constructor
     * @param string $adminID id of the Administrator that created this status
     * + if this param is null the Administrator is the System through a CRON task
     */
    function __construct($adminID = null)
    {
        $this->setConstants();
    }

    /**
     * To create a new status
     * + this status is the default and first status of all Order
     * @param Response $response to push in result or accured error
     * @param string $orderID the id of the order for with the Status is for
     */
    public function create(Response $response, $orderID, $status = null)
    {
        $this->adminID = self::$SYSTEM_ID;
        switch ($status) {
            case MyError::ERROR_STILL_STOCK:
                $this->status = self::$ORDER_STATUS_STOCK_ERROR;
                break;
            default:
                $this->status = self::$ORDER_DEFAULT_STATUS;
                break;
        }
        $this->setDate = $this->getDateTime();
        $this->insertStatus($response, $orderID);
    }

    /**
     * Initialize Language's constants
     */
    private function setConstants()
    {
        if (!isset(self::$ORDER_DEFAULT_STATUS)) {
            self::$ORDER_DEFAULT_STATUS = "ORDER_DEFAULT_STATUS";
            self::$ORDER_DEFAULT_STATUS = $this->getConstantLine(self::$ORDER_DEFAULT_STATUS)["stringValue"];
        }
        if (!isset(self::$SYSTEM_ID)) {
            self::$SYSTEM_ID = "SYSTEM_ID";
            self::$SYSTEM_ID = $this->getConstantLine(self::$SYSTEM_ID)["stringValue"];
        }
        if (!isset(self::$ORDER_STATUS_STOCK_ERROR)) {
            self::$ORDER_STATUS_STOCK_ERROR = "ORDER_STATUS_STOCK_ERROR";
            self::$ORDER_STATUS_STOCK_ERROR = $this->getConstantLine(self::$ORDER_STATUS_STOCK_ERROR)["stringValue"];
        }
    }

    /**
     * To get status's adminID
     * @return string status's adminID
     */
    private function getAdminID()
    {
        return $this->adminID;
    }

    /**
     * To get the status
     * @return string the status
     */
    private function getStatus()
    {
        return $this->status;
    }

    /**
     * To get status's tracking code
     * @return string status's tracking code
     */
    private function getTracking()
    {
        return $this->tracking;
    }

    /**
     * To get status's min delivery date
     * @return string status's min delivery date
     */
    private function getDeliveryMin()
    {
        return $this->deliveryMin;
    }

    /**
     * To get status's max delivery date
     * @return string status's max delivery date
     */
    private function getDeliveryMax()
    {
        return $this->deliveryMax;
    }

    /**
     * To get status's setDate
     * @return string status's setDate
     */
    private function getSetDate()
    {
        return $this->setDate;
    }


    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

    /**
     * To insert a new Status for an order
     * @param Response $response to push in results or accured errors
     * @param string $orderID the id of the order for with the Status is for
     */
    private function insertStatus($response, $orderID)
    {
        $bracket = "(?,?,?,?,?,?,?)"; // \[value-[0-9]*\]
        $sql = "INSERT INTO `OrdersStatus`(`orderId`, `status`, `trackingNumber`, `adminId`, `deliveryMin`, `deliveryMax`, `setDate`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [
            $orderID,
            $this->getStatus(),
            $this->getTracking(),
            $this->getAdminID(),
            $this->getDeliveryMin(),
            $this->getDeliveryMax(),
            $this->getSetDate()
        ];
        $this->insert($response, $sql, $values);
    }
}
