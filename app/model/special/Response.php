<?php

require_once 'model/special/MyError.php';
require_once 'model/view-management/Translator.php';

class Response
{
    /**
     * Holds the response's status
     * @var boolean $isSuccess set true if it's success else false
     */
    private $isSuccess;

    /**
     * Holds keys results and file where to get  this result 
     * (ex: "view/Grid/gridFiles/gridSticker.php")
     * + files = [
     *      resultKey{string} => file{string }
     * ]
     * @var string[]
     */
    private $files;

    /**
     * Holds a list of result
     * @var mixed[]
     */
    private $results;

    /**
     * Holds list translator's station to translate the result
     * + $resultStations = [key => station]
     * @var string[]
     */
    private $resultStations;

    /**
     * Holds list of error
     * @var MyError
     */
    private $errors;

    /**
     * Holds list translator's station to translate the error
     * + $errorStations = [key => station]
     * @var string[]
     */
    private $errorStations;

    public const RSP_NOTIFICATION = "rsp_notif";

    /**
     * Constuctor
     */
    function __construct()
    {
        $this->isSuccess = false;
        $this->files = [];
        $this->results = [];
        $this->resultStations = [];
        $this->errors = [];
        $this->errorStations = [];
    }

    /**
     * To push keys result => file
     * + files = [
     *      resultKey{string} => file{string }
     * ]
     * @param string[] $map of keys pointing to file
     */
    public function addFiles($key, $file)
    {
        $this->files[$key] = $file;
    }

    /**
     * Add a result in in the key given
     * @param string $key
     * @param string $result
     */
    public function addResult($key, $result)
    {
        if ((count($this->errors) > 0) || (count($this->errorStations) > 0)) {
            throw new Exception('Cannot add result when errors or errorStations is not empty');
        } else {
            $this->isSuccess = true;
        }
        $this->results[$key] = $result;
    }

    /**
     * To add error station that will be translated by "translateError()"
     * @param string $station a Translator's station
     * @param string $key access key that will be used to store the translation in errors list
     * @param string $multiLang a additional message understandable in all language like number, brand name etc...
     */
    public function addResultStation($key, $station)
    {
        if ((count($this->errors) > 0) && (count($this->errorStations) > 0)) {
            throw new Exception('Cannot add result station when $errors and $errorStations is not empty');
        } else {
            $this->isSuccess = true;
        }
        $this->resultStations[$key] = $station;
    }

    /**
     * To tranlsate error stored in resultStations
     * @param Translator $translator The translator used to translate every string
     * + NOTE: it's the only instance of this class in the whole system.
     */
    public function translateResult(Translator $translator)
    {
        if (count($this->resultStations) > 0) {
            foreach ($this->resultStations as $key => $stationTxt) {
                preg_match("#([A-z]{2}[0-9]+)#", $stationTxt, $matches);
                $station = $matches[1]; // to get the text that matched the first parenthesis
                $multiLangMsg = str_replace($station, "", $stationTxt); // a additional message understandable in all language like number, brand name etc...
                $resultMsg = $translator->translateStation($station) . $multiLangMsg;
                $this->addResult($key, $resultMsg);
                // if ((preg_match("#[0-9]+#", $key) == 1) && array_key_exists($key, $this->resultStations)) {
                //     $this->addError($resultMsg);
                // } else {
                //     $this->addError($resultMsg, $key);
                // }
            }
        }
    }

    /**
     * Add a result in in the key given
     * @param MyError $errorMsg
     */
    public function addError($errorMsg, $key = null)
    {
        if (count($this->results) > 0) {
            throw new Exception('Cannot add error when $result is not empty');
        } else {
            $this->isSuccess = false;
        }
        $error = new MyError($errorMsg);
        if($key == MyError::ADMIN_ERROR){
            (!key_exists($key, $this->errors)) ? $this->errors[MyError::ADMIN_ERROR] = [] : null;
            array_push($this->errors[MyError::ADMIN_ERROR], $error);
        } else if (!empty($key)) {
            $this->errors[$key] = $error;
        } else {
            array_push($this->errors, $error);
        }
    }

    /**
     * To add error station that will be translated by "translateError()"
     * @param string $station a Translator's station
     * @param string $key access key that will be used to store the translation in errors list
     * @param string $multiLang a additional message understandable in all language like number, brand name etc...
     */
    public function addErrorStation($station, $key = null)
    {
        if (count($this->results) > 0) {
            throw new Exception('Cannot add error station when $result is not empty');
        } else {
            $this->isSuccess = false;
        }
        if (!empty($key)) {
            $this->errorStations[$key] = $station;
        } else {
            array_push($this->errorStations, $station);
        }
    }

    /**
     * To tranlsate error stored in errorStations
     * @param Translator $translator The translator used to translate every string
     * + NOTE: it's the only instance of this class in the whole system.
     */
    public function translateError(Translator $translator)
    {
        if (count($this->errorStations) > 0) {
            foreach ($this->errorStations as $key => $stationTxt) {
                preg_match("#([A-z]{2}[0-9]+)#", $stationTxt, $matches);
                $station = $matches[1]; // to get the text that matched the first parenthesis
                $multiLangMsg = str_replace($station, "", $stationTxt); // a additional message understandable in all language like number, brand name etc...
                $errorMsg = $translator->translateStation($station) . $multiLangMsg;
                if ((preg_match("#[0-9]+#", $key) == 1) && array_key_exists($key, $this->errorStations)) {
                    $this->addError($errorMsg);
                } else {
                    $this->addError($errorMsg, $key);
                }
            }
        }
    }

    /**
     * Check if the Response is successful
     * @return boolean true if Response is successful else false
     */
    public function isSuccess()
    {
        return ((count($this->results) > 0) && $this->isSuccess);
    }

    /**
     * Check if there if an error in Response
     * @return boolean true if there is a error else false
     */
    public function containError()
    {
        return (count($this->errors) > 0 || count($this->errorStations) > 0);
    }

    /**
     * Getter for the files map
     * + files = [
     *      resultKey{string} => file{string }
     * ]
     * @return string[] the files map
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * To get a result stored at the key given in param
     * @return string result stored at the key given in param
     */
    public function getResult($key)
    {
        return $this->results[$key];
    }

    /**
     * To get a error stored at the key given in param
     * @param string $key access key to error stored
     * @return MyError error stored at the key given in param
     */
    public function getError($key)
    {
        return $this->errors[$key];
    }

    /**
     * Check if there is a error with a given key
     * @param string $key key to look for
     * @return boolean true if key exist else false
     */
    public function existErrorKey($key)
    {
        return (key_exists($key, $this->errors) || key_exists($key, $this->errorStations));
    }

    /**
     * To get Response's attributs
     * @return string[] Response's attributs
     */
    public function getAttributs()
    {
        $map = get_object_vars($this);
        unset($map["files"]);
        unset($map["errorStations"]);
        return $map;
    }

    /**
     * Unset the result at the position given in param
     * @param string $key
     * @return boolean true if value is found and unset else false and unset value
     */
    public function unsetResult($key)
    {
        if (isset($this->results[$key])) {
            unset($this->results[$key]);
            return true;
        }
        unset($this->results[$key]);
        return false;
    }
}
