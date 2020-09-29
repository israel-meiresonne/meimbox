<?php
require_once 'ControllerSecure.php';
class ControllerCheckout extends ControllerSecure
{

    /**
     * Holds index action
     */
    public const ACTION_INDEX = "checkout";

    /**
     * Holds name of a action file
     */
    private const ACTION_FILE_SIGN = "sign";

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
}
