<?php

use Stripe\ThreeDSecure;

require_once 'Controller.php';
require_once 'Request.php';
require_once 'View.php';

require_once 'Configuration.php';
require_once 'controller/ControllerSecure.php';

/**
 * Routing class for incoming requests.
 * Inspired by Nathan Davison's PHP framework
 *(https://github.com/ndavison/Nathan-MVC)
 * 
 */
class Router
{
    /**
     * Main method called by front controller
     * Reviews the request and takes appropriate action
     * 
     */
    public static function routerRequest()
    {
        try {
            $request = new Request(array_merge($_GET, $_POST));
            $verboseRequest = Configuration::get("verboseRequest");
            if ($verboseRequest) {
                echo '$_GET : ';
                var_dump($_GET);
                echo '<br/>';

                echo '$_POST : ';
                var_dump($_POST);
                echo '<br/>';

                echo '$_SESSION : ';
                var_dump($_SESSION);
                echo '<br/>';

                echo '$request : ';
                var_dump($request);
                echo '<br/>';
            }
            $action = self::createAction($request);
            $controller = self::createController($request, $action);
            $controller->executeAction($action);
        } catch (Throwable $e) {
            self::handleError($e);
        }
    }

    /**
     * Instantiates the appropriate controller based on the request received
     * 
     * @param Request $request Request received
     * @param string $action The controller's action to perform
     * @return Controller A Controller's instance
     * @throws Exception If controller creation fails
     */
    private static function createController(Request $request, $action)
    {
        $controller = "Home";
        if ($request->existingParameter('controller')) {
            $controller = ucfirst(strtolower($request->getParameter('controller')));
        }
        $classController = "Controller" . $controller;
        $fileController = "controller/" . $classController . ".php";
        if (file_exists($fileController)) {
            require_once $fileController;
            $controller = new $classController($action);
            $controller->setRequest($request);
            return $controller;
        } else {
            throw new Exception("Fichier '$fileController' introuvable");
        }
    }

    /**
     * Determines the action to be performed based on the request received
     * 
     * @param Request $request Request received
     * @return string Action to perform
     */
    private static function createAction(Request $request)
    {
        $action = "index";
        if ($request->existingParameter('action')) {
            $action = $request->getParameter('action');
        }
        return $action;
    }

    /**
     * Handles a runtime error (exception)
     * 
     * @param Exception $exception Exception that occurred
     */
    private static function handleError(Throwable $exception)
    {
        $env = Configuration::getEnvironement();
        $view = new View('Template/files/message');
        $translator = $view->getTranslator();
        $btnLink = ControllerSecure::extractController(ControllerGrid::class);
        switch ($env) {
            case Configuration::ENV_DEV:
                $hiddenMsg = "<span style=\"display:none;\">" . $exception->__toString() . "</span>";
                $datas = [
                    "title" => "dev error occured",
                    "content" => $exception->getMessage() . $hiddenMsg,
                    "btnText" => "reload",
                    "btnLink" => $btnLink,
                ];
                $view->generate($datas, View::TEMPLATE_ERROR);
                break;

            case Configuration::ENV_PROD:
            default:
                $url = Page::extractUrl();
                $hiddenMsg = "<span style=\"display:none;\">" . $exception->getMessage() . "</span>";
                $brand = (new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY)))->get(Map::brand);
                $btnLink = $btnLink . "?" . Page::KEY_FROM_ERROR_PAGE . "=" . $url;
                $datas = [
                    "title" => $translator->translateStation("US106"),
                    "content" => $translator->translateStation("US107", new Map([Map::brand => strtoupper($brand)])) . $hiddenMsg,
                    "btnText" => $translator->translateStation("US105"),
                    "btnLink" => $btnLink,
                ];
                $view->generate($datas, View::TEMPLATE_ERROR);
                $rsp = new Response();
                $rsp->addError($exception->__toString(), MyError::ADMIN_ERROR);
                break;
        }
    }
}