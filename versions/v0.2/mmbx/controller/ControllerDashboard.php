<?php
require_once 'ControllerSecure.php';


class ControllerDashboard extends ControllerSecure
{
    /**
     * Holds name of a action file
     */
    private const ACTION_FILE_SHOPBAG = "shopbag";
    
    /**
     * Holds page link (href)
     */
    public const HREF_SHOPBAG = "dashboard/shopbag";

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
        $this->generateView($datasView, $this->person, self::ACTION_FILE_SHOPBAG);
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