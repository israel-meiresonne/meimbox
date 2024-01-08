<?php

require_once 'Configuration.php';
require_once 'Request.php';
require_once 'View.php';
require_once 'model/tools-management/Language.php';
require_once 'model/special/Response.php';
require_once 'model/special/Map.php';
require_once 'model/view-management/ViewEmail.php';

/**
 * Abstract controller class.
 * Provides common services to derived controller classes.
 */
abstract class Controller
{

    /**
     * Action to perform 
     */
    private $action;

    /**
     * Incoming request
     */
    protected $request;

    public const KEY_CTR = "controller";
    public const KEY_ACTION = "action";

    /**
     * To set controller's action
     */
    protected function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Defines the incoming request
     * 
     * @param Request $request Incoming request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Executes the action to be performed.
     * Calls the method with the same name as the action on the current Controller object
     * 
     * @throws Exception If the action does not exist in the current Controller class
     */
    public function executeAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        } else {
            $classController = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classController");
        }
    }

    /**
     * Abstract method corresponding to the default action
     * Forces derived classes to implement this action by default
     */
    public abstract function index();

    /**
     * Generates the view associated with the current controller
     * 
     * @param array $datasView Data needed for view generation
     * @param Visitor|Client|Administrator $person the current user
     * @param string $action View-related action (allows a controller to generate a view for a specific action)
     */
    protected function generateView(array $datasView = array(), Visitor $person, $action = null)
    {
        $actionView = $action == null ? $this->action : $action;
        $classController = get_class($this);
        $controllerView = str_replace("Controller", "", $classController);
        $view = new View($actionView, $controllerView, $person);
        $view->generate($datasView);
    }

    /** 
     * Generate a json view with an object Response
     * 
     * @param array $datasView datas used to generate the view
     * @param Response $response contain results ready and/or prepared or errors
     * @param Visitor $person the current user
     */
    protected function generateJsonView($datasView = array(), Response $response, Visitor $person)
    {
        $classController = get_class($this);
        $controllerView = str_replace("Controller", "", $classController);
        $view = new View(null, $controllerView, $person);
        $view->generateJson($datasView, $response);
    }

    /**
     * To send an email
     * 
     * @param Response $response contain results ready and/or prepared or errors
     * @param Visitor $recipient the recipient of the email
     * @param string $mailerClass class of the mailer to use
     * @param string $mailerFunc function to execute on the mailer to send email
     * @param Map $datasViewMap datas used to generate the view
     */
    protected function sendEmail(Response $response, Visitor $recipient, string $mailerClass, string $mailerFunc, Map $datasViewMap = null)
    {
        $view = new ViewEmail($recipient->getLanguage());
        $datasViewMap = (empty($datasViewMap)) ? (new Map()) : $datasViewMap;
        $view->sendEmail($response, $mailerClass, $mailerFunc, $datasViewMap);
    }

    protected function previewEmail(Visitor $recipient, Map $datasViewMap = null)
    {
        $datasViewMap = (empty($datasViewMap)) ? (new Map()) : $datasViewMap;
        $view = new ViewEmail($recipient->getLanguage());
        $view->previewEmail($datasViewMap);
    }

    /**
     * Redirects to a specific controller and action
     * 
     * @param string $controller Contrôleur
     * @param string $action Action Action
     */
    public static function redirect($controller, $action = null)
    {
        $webRoot = Configuration::get("webRoot", "/");
        $link = $webRoot . $controller;
        $link .= (!empty($action)) ? "/" . $action : null;
        header("Location:" . $link);
    }

    /**
     * To get controller's action
     * 
     * @return string controller's action
     */
    protected function getAction()
    {
        return $this->action;
    }
}