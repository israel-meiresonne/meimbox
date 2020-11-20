<?php

/**
 * Provide a access to cleaned value of superglobal $_GET and $_POST
 */
class Query
{
    /**
     * Holds the super global $_GET
     * @var string
     */
    private static $GET;

    /**
     * Holds the super global $_POST
     * @var string
     */
    private static $POST;

    /**
     * Holds the method of the query
     * @var string
     */
    const GET_MOTHOD = "GET";

    /**
     * Holds the method of the query
     * @var string
     */
    const POST_MOTHOD = "POST";

    /**
     * Holds the input type
     */
    /*const CHECKBOX = "checckbox";
    const PSEUDO = "pseudo";
    const NAME = "name";  // handle space and `-`
    const EMAIL = "email";
    const PHONE_NUMBER = "phone";
    const PASSWORD = "psw";
    const BOOLEAN_TYPE = "boolean";
    const STRING_TYPE = "string";
    const NUMBER_FLOAT = "float";
    const NUMBER_INT = "int";
    const ALPHA_NUMERIC = "alpha_numeric";

    const FLOAT_REGEX = "#(^0{1}$)|(^0{1}[.,]{1}[0-9]+$)|(^[1-9]+[0-9]*[.,]?[0-9]*$)#";
    const STRING_REGEX = "#^[a-zA-Z]+$#";
    const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_ ]*$#";
    const PALPHA_NUMERIC_REGEX = "#^[a-zA-Z0-9]+$#";*/

    /**
     * Constructor
     */
    function __construct()
    {
        (!isset(self::$GET)) ? self::$GET = $_GET : null;
        (!isset(self::$POST)) ? self::$POST = $_POST : null;
    }

    /**
     * To get cleanned value from $_GET at specified key
     * @param string $key key value from $_GET
     * @return string cleanned value from $_GET
     */
    public function GET($key)
    {
        return GeneralCode::clean(self::$GET[$key]);
    }

    /**
     * To get cleanned value from $_POST at specified key
     * @param string $key key value from $_POST
     * @return string cleanned value from $_POST
     */
    public function POST($key)
    {
        return GeneralCode::clean(self::$POST[$key]);
    }

    /**
     * Check if the key value exist in $_GET and contain a value different 
     * than ""
     * @param string $key key value from $_GET
     * @return boolean true if key contain a value different than "" else false
     */
    public function paramExistGET($key)
    {
        return (isset(self::$GET[$key])) && (!empty(self::$GET[$key]));
    }

    /**
     * Check if the key value exist in $_POST and contain a value different 
     * than ""
     * @param string $key key value from $_POST
     * @return boolean true if key contain a value different than "" else false
     */
    public function paramExistPOST($key)
    {
        return (isset(self::$POST[$key])) && (!empty(self::$POST[$key]));
    }

    /**
     * Check the input value passed in param and push error accured in Response
     * @param string $key the name input to check in $_POST
     * @param string[] $inputTypes the types of the filter to check input.
     * NOTE: combinaison available=> 
     *      [{all type}], 
     *      [CHECKBOX, {all type}]
     * @param boolean $isNullable set true if value can be empty alse false
     * @param Response $response to push in error accured
     * @return Response 
     */
    public function checkInput($key, $inputTypes, $response, $length = null, $isNullable = false)
    {
        $keyExist = $this->paramExistPOST($key);
        if (!$isNullable && !$keyExist) {
            $errorMsg = ($inputTypes[0] == self::CHECKBOX) ? View::translateStation(MyError::ERROR_FILE, 5)
                : View::translateStation(MyError::ERROR_FILE, 2);
            $response->addError($errorMsg, $key);
            return $response;
        }
        if (!$keyExist) {
            return $response;
        }

        $value = $this->POST($key);
        if (!empty($length) && (strlen($value) > $length)) {
            $errorMsg = View::translateStation(MyError::ERROR_FILE, 6);
            $errorMsg .= " " . $length;
            $response->addError($errorMsg, $key);
            return $response;
        }

        switch ($inputTypes[0]) {
            case self::NUMBER_FLOAT:
                if (preg_match(self::FLOAT_REGEX, $value) != 1) {
                    $errorMsg = View::translateStation(MyError::ERROR_FILE, 3);
                    $response->addError($errorMsg, $key);
                } else {
                    self::$POST[$key] = (float) str_replace(",", ".", $this->POST($key));
                }
                break;

            case self::PSEUDO:
                if (preg_match(self::PSEUDO_REGEX, $value) != 1) {
                    $errorMsg = View::translateStation(MyError::ERROR_FILE, 4);
                    $response->addError($errorMsg, $key);
                } else {
                    self::$POST[$key] = strtolower($this->POST($key));
                }
                break;

            case self::ALPHA_NUMERIC:
                if (preg_match(self::PALPHA_NUMERIC_REGEX, $value) != 1) {
                    $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
                    $response->addError($errorMsg, MyError::FATAL_ERROR);
                } else {
                    self::$POST[$key] = strtolower($this->POST($key));
                }
                break;

            case self::CHECKBOX:
                $cbxType = $inputTypes[1];

                switch ($cbxType) {
                    case self::STRING_TYPE:
                        if (preg_match(self::STRING_REGEX, $value) != 1) {
                            $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
                            $response->addError($errorMsg, MyError::FATAL_ERROR);
                        }
                        break;
                }

                break;
        }
        return $response;
    }

    // /**
    //  * Check the checkbox value passed in param and push error accured in Response
    //  * @param string $key the name input to check in $_POST
    //  * @param string $checkboxType the type of the filter to check input
    //  * @param boolean $isNullable set true if value can be empty alse false
    //  * @param Response $response to push in error accured
    //  * @return Response 
    //  */
    // public function checkCheckbox($key, $checkboxType, $response, $isNullable = false)
    // {
    //     $keyExist = $this->paramExistPOST($key);
    //     if (!$isNullable && !$keyExist) {
    //         $errorMsg = View::translateStation(MyError::ERROR_FILE, 5);
    //         $response->addError($errorMsg, $key);
    //         return $response;
    //     }
    //     if (!$keyExist) {
    //         return $response;
    //     }
    //     $value = $this->POST($key);
    //     switch ($checkboxType) {
    //         case self::STRING_TYPE:
    //             if (preg_match("##^[a-zA-Z]+$#", $value) != 1) {
    //                 $errorMsg = View::translateStation(MyError::ERROR_FILE, 3);
    //                 $response->addError($errorMsg, $key);
    //             }
    //             break;
    //     }
    //     return $response;
    // }
}
