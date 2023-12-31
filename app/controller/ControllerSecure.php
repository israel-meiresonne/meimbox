<?php

require_once 'controller/ControllerCheckout.php';
require_once 'controller/ControllerDashboard.php';
require_once 'controller/ControllerGrid.php';
require_once 'model/users-management/Visitor.php';
require_once 'model/users-management/Client.php';
require_once 'model/users-management/Administrator.php';
require_once 'model/special/Search.php';
require_once 'model/special/MyError.php';
require_once 'model/special/Query.php';
require_once 'model/tools-management/Measure.php';
require_once 'model/tools-management/Cookie.php';
require_once 'framework/Configuration.php';
require_once 'model/special/Map.php';

/**
 * This class manage security and holds elements common to several controllers
 */
abstract class ControllerSecure extends Controller
{
    /**
     * Holds input name that contain redirect link
     * @var string
     */
    public const INPUT_REDIRECT = "redirect";

    /**
     * Holds key to store response
     * @var string
     */
    public const TITLE_KEY = "title_key";

    /**
     * Holds key to store response
     * @var string
     */
    public const BUTTON_KEY = "button_key";

    /**
     * Can be a Visitor, a Client or a Administrator
     * @var Visitor|User|Client|Administrator
     */
    protected $person;

    /*———————————————————————————— INPUT ATTRIBUTS DOWN ———————————————————————*/
    /**
     * Holds the input type
     */
    protected const CHECKBOX = "checckbox";
    protected const PSEUDO = "pseudo";
    protected const NAME = "name";  // handle space and `-`
    protected const EMAIL = "email";
    protected const PHONE_NUMBER = "phone";
    protected const PASSWORD = "psw";
    protected const SIZE = "size";
    protected const TYPE_BOOLEAN = "boolean";
    protected const STRING_TYPE = "string";
    protected const NUMBER_FLOAT = "float";
    protected const NUMBER_INT = "int";
    protected const ALPHA_NUMERIC = "alpha_numeric";
    protected const TYPE_ALPHANUM_SPACE_HYPHEN_UNDER = "type_alphanum_space_hyphen_under";
    protected const TYPE_STRING_SPACE_HYPHEN_UNDER = "TYPE_STRING_SPACE_HYPHEN_UNDER";
    // protected const TYPE_LINK = "type_link";

    /**
     * Holds the REGEX
     */
    private const SIZE_REGEX = "#^[xX]*[sS]{1}$|^[ml]{1}$|^[xX]*[l]{1}$#";
    private const INT_REGEX = "#^[0-9]+$#";
    private const FLOAT_REGEX = "#(^0{1}$)|(^0{1}[.,]{1}[0-9]+$)|(^[1-9]+[0-9]*[.,]?[0-9]*$)#";
    private const STRING_REGEX = "#^[a-zA-Z]+$#";
    private const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_ ]*$#";
    private const PALPHA_NUMERIC_REGEX = "#^[a-zA-Z0-9]+$#";
    private const REGEX_EMAIL = "#^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$#";
    private const REGEX_NAME = "#[A-Za-zÀ-ÖØ-öø-ÿ\- ]+$#";
    private const REGEX_PASSWORD = "#^[\w\-]{8,}$#";
    private const REGEX_ALPHANUM_SPACE_HYPHEN_UNDER = "#^[\w\- ]+$#";
    private const REGEX_STRING_SPACE_HYPHEN_UNDER = "#^[A-z\- ]+$#";

    /*———————————————————————————— INPUT ATTRIBUTS UP ———————————————————————*/

    /**
     * Constuctor
     * @param string $action the controller's action to perform
     */
    public function __construct($action)
    {
        date_default_timezone_set('Europe/Paris');
        $this->setAction($action);
        $this->setPerson();
        $this->root();
        $this->person->unlockStock();
    }

    /**
     * To get Visitor's datas
     */
    private function setPerson()
    {
        $ctrClass = get_class($this);
        switch ($ctrClass) {
            case ControllerWebhook::class:
                $this->initController();
                break;
            default:
                $CLT_VAL = Cookie::getCookieValue(Cookie::COOKIE_CLT);
                if (!empty($CLT_VAL)) {
                    $this->person = new Client();
                } else {
                    $VIS_VAL = Cookie::getCookieValue(Cookie::COOKIE_VIS);
                    $this->person = new Visitor($VIS_VAL);
                }
                break;
        }
    }

    /**
     * To get the current Visitor
     * @return Visitor|User|Client|Administrator the current Visitor
     */
    protected function getPerson()
    {
        return $this->person;
    }

    /**
     * To root controllers
     */
    private function root()
    {
        $ctrClass = get_class($this);
        switch ($ctrClass) {
            case ControllerCheckout::class:
                $this->rootController();
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * To root Controller
     */
    protected function rootController()
    {
        $ctrClass = get_class($this);
        throw new Exception("This controller '$ctrClass' define the function 'rootController' but don't implement its codes");
    }

    /**
     * To init Controller
     */
    protected function initController()
    {
        $ctrClass = get_class($this);
        throw new Exception("This controller '$ctrClass' define the function 'initController' but don't implement its codes");
    }

    /**
     * To extract name of a controller from his class name
     * + i.e: ControllerMyAss => myass
     * @return string name of a controller get from his class name
     */
    public static function extractController($ctrClass)
    {
        return strtolower(str_replace("Controller", "", $ctrClass));
    }

    /**
     * To generate action path to use ass link
     * @return string action path to use ass link
     */
    public static function generateActionPath(string $ctrClass, $action)
    {
        if(!class_exists($ctrClass)){
            throw new Exception("There no controllerr with  this name '$ctrClass'");
        }
        if(!method_exists($ctrClass, $action)){
            throw new Exception("This action '$action' don't exist in the controller '$ctrClass'");
        }
        return $ctr = self::extractController($ctrClass)."/".$action;
    }


    /**
     * Check the input value passed in param and push error accured in Response
     * @param Response $response to push in error accured
     * @param string $input the name of the input used as key to push error accured
     * @param string $data the data to check
     * @param string[] $dataTypes the types of the filter to check input.
     * + NOTE: combinaison available => 
     *      [TYPE], 
     *      [CHECKBOX, TYPE]
     * @param boolean $required set true if value can be empty alse false
     * @return mixed|null cleaned value
     */
    // public function checkInput($input, $dataTypes, Response $response, $length = null, $required = true)
    public function checkInput(Response $response, $input, $data, array $dataTypes, int $length = null, bool $required = true)
    {
        // if ($required && (!isset($data))) {
        if ($required && (empty($data))) {
            $errorStation = (!empty($dataTypes) && $dataTypes[0] == self::CHECKBOX) ? "ER5" : "ER2";
            $response->addErrorStation($errorStation, $input);
            // return $response->isSuccess();
            return null;
        }
        if (empty($data)) {
            return $data;
        }

        // $data = Query::getParam($input);
        if (!empty($length) && (strlen($data) > $length)) {
            $errorStationTxt = "ER6";
            $errorStationTxt .= " " . $length; // translateError will split errorStation from the lenght
            $response->addErrorStation($errorStationTxt, $input);
            return null;
        }
        $value = null;
        if (count($dataTypes) > 0) {
            switch ($dataTypes[0]) {
                case self::NUMBER_FLOAT:
                    if (preg_match(self::FLOAT_REGEX, $data) != 1) {
                        $errStation = "ER3";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $this->convertParam(self::NUMBER_FLOAT, $data);
                    }
                    break;
                case self::NUMBER_INT:
                    if (preg_match(self::INT_REGEX, $data) != 1) {
                        $errStation = "ER7";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $this->convertParam(self::NUMBER_INT, $data);
                    }
                    break;
                case self::PSEUDO:
                    if (preg_match(self::PSEUDO_REGEX, $data) != 1) {
                        $errStation = "ER4";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $this->convertParam(self::PSEUDO, $data);
                    }
                    break;

                case self::NAME:
                    if (preg_match(self::REGEX_NAME, $data) != 1) {
                        $errStation = "ER20";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $this->convertParam(self::NAME, $data);
                    }
                    break;
                case self::EMAIL:
                    if (preg_match(self::REGEX_EMAIL, $data) != 1) {
                        $errStation = "ER19";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $data;
                    }
                    break;
                case self::PASSWORD:
                    if (preg_match(self::REGEX_PASSWORD, $data) != 1) {
                        $errStation = "ER21";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $data;
                    }
                    break;
                case self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER:
                    if (preg_match(self::REGEX_ALPHANUM_SPACE_HYPHEN_UNDER, $data) != 1) {
                        $errStation = "ER27";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $this->convertParam(self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER, $data);
                    }
                    break;
                case self::TYPE_STRING_SPACE_HYPHEN_UNDER:
                    if (preg_match(self::REGEX_STRING_SPACE_HYPHEN_UNDER, $data) != 1) {
                        $errStation = "ER28";
                        $response->addErrorStation($errStation, $input);
                    } else {
                        $value = $this->convertParam(self::TYPE_STRING_SPACE_HYPHEN_UNDER, $data);
                    }
                    break;
                case self::CHECKBOX:
                    if (!empty($dataTypes[1])) {
                        $cbxType = $dataTypes[1];
                        switch ($cbxType) {
                            case self::TYPE_BOOLEAN:
                                $value = $this->convertParam(self::TYPE_BOOLEAN, $data);
                                break;
                            case self::STRING_TYPE:
                                if (preg_match(self::STRING_REGEX, $data) != 1) {
                                    $errStation = "ER1";
                                    $response->addErrorStation($errStation, MyError::FATAL_ERROR);
                                } else {
                                    $value = $this->convertParam(self::STRING_TYPE, $data);
                                }
                                break;
                            case self::SIZE:
                                if ((preg_match(self::SIZE_REGEX, $data) != 1) || (preg_match(self::INT_REGEX, $data) != 1)) {
                                    $errStation = "ER1";
                                    $response->addErrorStation($errStation, MyError::FATAL_ERROR);
                                } else {
                                    $value = $this->convertParam(self::STRING_TYPE, $data);
                                }
                                break;
                            default:
                                throw new Exception("This data type ('$cbxType') don't exist, file: " . __FILE__ . " line: " . __LINE__);
                                break;
                        }
                    }
                    break;
                default:
                    throw new Exception("This data type ('$dataTypes[0]') don't exist, file: " . __FILE__ . " line: " . __LINE__);
                    break;
            }
        } else {
            $value = $data;
        }
        return $value;
    }

    /**
     * Convert data into the correct format
     * @param string $dataType the type to convert data to
     * @param string $input access key to get data from param list
     * @return mixed data converted into the correct format
     */
    private function convertParam($dataType, $data)
    {
        $value = null;
        switch ($dataType) {
            case self::NUMBER_FLOAT:
                $value = (float) str_replace(",", ".", $data);
                break;
            case self::NUMBER_INT:
                $value = (int) $data;
                break;
            case self::PSEUDO:
            case self::ALPHA_NUMERIC:
            case self::STRING_TYPE:
            case self::NAME:
            case self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER:
            case self::TYPE_STRING_SPACE_HYPHEN_UNDER:
                $value = strtolower($data);
                break;
            case self::TYPE_BOOLEAN:
                $value = (!empty($data));
                break;
            default:
                throw new Exception("This data type ('$dataType') don't exist, file: " . __FILE__ . " line: " . __LINE__);
                break;
        }
        return $value;
    }
}
