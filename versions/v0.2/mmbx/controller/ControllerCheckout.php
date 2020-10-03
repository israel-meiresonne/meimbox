<?php
require_once 'ControllerSecure.php';
class ControllerCheckout extends ControllerSecure
{

    /**
     * Holds actions function
     */
    public const CTR_NAME = "checkout";

    /**
     * Holds actions function
     */
    public const ACTION_INDEX = "index";
    public const ACTION_SIGN = "sign";
    public const ACTION_ADDRESS = "address";

    /**
     * The layout for the checkout page
     */
    public function index()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person);
    }

    /**
     * The layout for the checkout page
     */
    public function sign()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person);
    }

    /**
     * The layout for the checkout page
     */
    public function address()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person);
    }
}
