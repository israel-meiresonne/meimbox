<?php

class CheckoutSession extends ModelFunctionality
{

    /**
     * Holds holds Stripe's checkout session
     * @var \Stripe\Checkout\Session
     */
    private $checkoutSession;

    private $setDate;

    /**
     * Constructor
     * @param \Stripe\Checkout\Session $checkoutSession
     * @param string $userID id of the Client Attempting to pay
     */
    public function __construct(\Stripe\Checkout\Session $checkoutSession, $userID)
    {
        $this->checkoutSession = $checkoutSession;
        $this->setDate = $this->getDateTime();
        $response = new Response();
        $this->insertCheckoutSession($response, $userID);
    }

    /**
     * To get CheckoutSession's id
     * @return string CheckoutSession's id
     */
    public  function getId()
    {
        return $this->checkoutSession->id;
    }

    /**
     * To get CheckoutSession's customer id
     * @return string CheckoutSession's id
     */
    public  function getCustomerID()
    {
        return $this->checkoutSession->customer;
    }

    /**
     * To get CheckoutSession's payement method
     * @return string CheckoutSession's payement method
     */
    public  function getPaymentMethod()
    {
        return $this->checkoutSession->payment_method_types[0];
    }

    /**
     * To get CheckoutSession's payement method
     * @return string CheckoutSession's payement method
     */
    public  function getPaymentStatus()
    {
        return $this->checkoutSession->payment_status;
    }

    /**
     * To get creation date of the CheckoutSession
     * @return string the creation date of the CheckoutSession
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

    /**
     * To insert in db a CheckoutSession
     * @param Response $response if its success Response.isSuccess = true else Response
     * @param string $userID id of the Client Attempting to pay
     * @param string $payMethod payement method like [card, bancontact, ideal, etc...]
     */
    private function insertCheckoutSession($response, $userID)
    {
        // $client = $this->getClient();
        $bracket = "(?,?,?,?,?,?)";
        $sql = "INSERT INTO `StripeCheckoutSessions`(`sessionID`, `payId`, `userId`, `custoID`, `payStatus`, `setDate`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push($values, $this->getId());
        array_push($values, $this->getPaymentMethod());     // with Stripe the payId = payMethod
        array_push($values, $userID);
        array_push($values, $this->getCustomerID());
        array_push($values, $this->getPaymentStatus());
        array_push($values, $this->getSetDate());
        $this->insert($response, $sql, $values);
    }
}
