<?php

require_once 'model/users-management/Visitor.php';
require_once 'model/users-management/Client.php';
require_once 'model/users-management/Administrator.php';
require_once 'model/special/Search.php';
require_once 'model/special/Response.php';
require_once 'model/special/MyError.php';
require_once 'model/special/Query.php';
require_once 'model/tools-management/Measure.php';
require_once 'model/special/Map.php';

/**
 * This class manage security and holds elements common to several controllers
 */
abstract class ControllerSecure extends Controller
{
    /**
     * Holds key to store response
     * @var string
     */
    public const AJX = "/qr/";

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
     * @var Visitor|Client|Administrator
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
    protected const BOOLEAN_TYPE = "boolean";
    protected const STRING_TYPE = "string";
    protected const NUMBER_FLOAT = "float";
    protected const NUMBER_INT = "int";
    protected const ALPHA_NUMERIC = "alpha_numeric";

    /**
     * Holds the REGEX
     */
    private const SIZE_REGEX = "#^[xX]*[sS]{1}$|^[ml]{1}$|^[xX]*[l]{1}$#";
    private const INT_REGEX = "#^[0-9]+$#";
    private const FLOAT_REGEX = "#(^0{1}$)|(^0{1}[.,]{1}[0-9]+$)|(^[1-9]+[0-9]*[.,]?[0-9]*$)#";
    private const STRING_REGEX = "#^[a-zA-Z]+$#";
    private const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_ ]*$#";
    private const PALPHA_NUMERIC_REGEX = "#^[a-zA-Z0-9]+$#";

    /*———————————————————————————— INPUT ATTRIBUTS UP ———————————————————————*/

    public function __construct()
    {
        date_default_timezone_set('Europe/Paris');
        $this->person = new Client(651853948);
    }

    // /**
    //  * Initialized the person attribut
    //  * + determines if the user is a Visitor, Client or Administrator
    //  */
    // protected function secureSession()
    // {
        // date_default_timezone_set('Europe/Paris');
        // $this->person = new Client(651853948);

    // }


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
    public function checkInput(Response $response, $input, $data, array $dataTypes, $length = null, $required = true)
    {
        if ($required && empty($data)) {
            $errorStation = ($dataTypes[0] == self::CHECKBOX) ? "ER5"
                : "ER2";
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

            case self::ALPHA_NUMERIC:
                if (preg_match(self::PALPHA_NUMERIC_REGEX, $data) != 1) {
                    $errStation = "ER1";
                    $response->addErrorStation($errStation, MyError::FATAL_ERROR);
                } else {
                    $value = $this->convertParam(self::ALPHA_NUMERIC, $data);
                }
                break;

            case self::CHECKBOX:
                $cbxType = $dataTypes[1];
                switch ($cbxType) {
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
                break;
            default:
                throw new Exception("This data type ('$dataTypes[0]') don't exist, file: " . __FILE__ . " line: " . __LINE__);
                break;
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
            case self::PSEUDO || self::ALPHA_NUMERIC || self::STRING_TYPE:
                $value = strtolower($data);
                break;
            default:
                throw new Exception("This data type ('$dataType') don't exist, file: " . __FILE__ . " line: " . __LINE__);
                break;
        }
        return $value;
    }
}
