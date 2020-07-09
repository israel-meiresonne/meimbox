<?php

require_once 'model/users-management/Visitor.php';
require_once 'model/users-management/Client.php';
require_once 'model/users-management/Administrator.php';
require_once 'model/special/Search.php';
require_once 'model/special/Response.php';

/**
 * This class manage security and holds elements common to several controllers
 */
abstract class ControllerSecure extends Controller
{
    /**
     * Can be a Visitor, a Client or a Administrator
     * @var Visitor|Client|Administrator
     */
    protected $person;

    /**
     * Initialized the person attribut
     * + determines if the user is a Visitor, Client or Administrator
     */
    protected function secureSession()
    {
        date_default_timezone_set('Europe/Paris');
        $this->person = new Client(651853948);
    }
}
