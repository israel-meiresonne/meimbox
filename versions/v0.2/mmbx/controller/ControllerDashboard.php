<?php
require_once 'ControllerSecure.php';


class ControllerDashboard extends ControllerSecure
{
    private const PG_SHOPBAG = "shopbag";

    /**
     * The default layout: the dashboard
     */
    public function index()
    {
        var_dump("The layout for the dashboard page");
        var_dump($_GET);
    }

    /**
     * The layout for the shopping bag page
     */
    public function shopbag()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person->getLanguage(), self::PG_SHOPBAG);
    }

    /**
     * The layout for the orders page
     */
    public function orders()
    {
        var_dump("The layout for the orders page");
        var_dump($_GET);
    }
}