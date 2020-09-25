<?php
require_once 'ControllerSecure.php';
class ControllerCheckout extends ControllerSecure
{
    /**
     * The layout for the checkout page
     */
    public function index()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person);
    }
}
