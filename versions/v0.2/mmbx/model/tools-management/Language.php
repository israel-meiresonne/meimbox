<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/special/Query.php';

class Language extends ModelFunctionality
{
    /**
     * @var string language's iso code
     */
    private $isoLang;

    /**
     * @var string language name in english
     */
    private $langName;

    /**
     * @var string language name translated in the language himself
     */
    private $langLocalName;

    /**
     * holds the id of the default language value stored in database in a constant table
     * @var string 
     */
    private static $DEFAULT_LANGUAGE;


    function __construct()
    {
        $args = func_get_args();
        $this->setConstants();
        switch (func_num_args()) {
            case 0:
                $this->__construct0();
                break;
            case 1:
                $this->__construct1($args[0]);
                break;
        }
    }

    /**
     * Contructor
     * + NOTE: used to create language with url param or driver's language 
     * else system's default language
     */
    private function __construct0()
    {
        $this->initLang();
    }

    /**
     * Contructor
     * @param string $isoLang language's iso code 2
     */
    private function __construct1($isoLang)
    {
        $this->initLang($isoLang);
    }

    /**
     * Initialize Language's constants
     */
    private function setConstants()
    {
        if (!isset(self::$DEFAULT_LANGUAGE)) {
            self::$DEFAULT_LANGUAGE = "DEFAULT_LANGUAGE";
            self::$DEFAULT_LANGUAGE = $this->getConstantLine(self::$DEFAULT_LANGUAGE)["stringValue"];
        }
    }


    /**
     * Get the language of the user's driver and check if it match a supported language of the website
     * if it match the attribute $langName is updated with the found value
     * otherwise the attribute $langName still at "en" (english)
     * @param string $
     */
    private function initLang($isoLang = null) //[,-;]*fr[,-;]*
    {
        $found = false;
        $found = isset($isoLang) ? $this->setLanguage($isoLang) : $found;

        if (!$found) {
            $urlLang = Query::getParam("lang");
            $found = isset($urlLang) ? $this->setLanguage($urlLang) : $found;
        }

        if (!$found) {
            $driverLang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
            $found = $found ? $found : $this->setLanguage($driverLang);
        }

        if (!$found) {
            $this->buildLanguage(self::$DEFAULT_LANGUAGE);
        }
    }

    /**
     * Check if the language given in param is supported by the website and 
     * if it supported set attribute isoLang, langName and langLocalName
     * @param string $driverLang server's language or any otheer string
     * @return boolean true if the language iso code is supported else false
     */
    private function setLanguage($driverLang)
    {
        $found = false;
        $isoLangs = $this->cleanLanguage($driverLang);
        foreach ($isoLangs as $isoLang) {
            if ($this->existLanguage($isoLang)) {
                $this->buildLanguage($isoLang);
                $found = true;
                break;
            }
        }
        return $found;
    }


    function getIsoLang()
    {
        return $this->isoLang;
    }

    private function getLangName()
    {
        return $this->langName;
    }

    /**
     * Getter of the default language's iso code 2
     * @return string the default language's iso code 2
     */
    public function getDEFAULT_LANGUAGE()
    {
        return self::$DEFAULT_LANGUAGE;
    }

    /**
     * Static Getter of the default language's iso code 2
     * @return string the default language's iso code 2
     */
    public static function __getDEFAULT_LANGUAGE()
    {
        return self::$DEFAULT_LANGUAGE;
    }

    /**
     * Convert $_SERVER["HTTP_ACCEPT_LANGUAGE"] to iso 2 language
     * + ex: en-us,zh;q=0.5 =>  array[en, us, zh]
     * @param string $driverLang server's language or any otheer string
     * @return string[] iso language 2
     */
    private function cleanLanguage($driverLang)
    {
        $isoLangs = [];
        $split = preg_split("#[-,;=]#", $driverLang);
        foreach ($split as $isoLang) {
            if (preg_match("#[A-z]{2}#", $isoLang) == 1) {
                array_push($isoLangs, $isoLang);
            }
        }
        return $isoLangs;
    }

    /**
     * put each char of a string between bracket
     * ex: tomson => [t][o][m][s][o][n]
     * @var string $string an language's iso code 2
     * @return string a regular expression like tomson => "#[t][o][m][s][o][n]#"
     */
    private function buildRegEx($string)
    {

        $charList = str_split($string);
        $open = "[";
        $close = "]";
        $regEx = "#";

        foreach ($charList as $char) {
            $regEx .= $open . $char . $close;
        }
        $regEx .= "#";
        return $regEx;
    }

    /**
     * Anitialize this Language's attributs
     * @param string $isoLang language's iso code
     */
    private function buildLanguage($isoLang)
    {
        $languageTab = $this->getLanguageLine($isoLang);
        $this->isoLang = $isoLang;
        $this->langName = $languageTab["langName"];
        $this->langLocalName = $languageTab["langLocalName"];
    }

    /**
     * To get a protected copy of the Language
     * @return Language a protected copy of the current language
     */
    // public function getCopy()
    // {
    //     $copy = new Language();
    //     $copy->isoLang = $this->isoLang;
    //     $copy->langName = $this->langName;
    //     $copy->langLocalName = $this->langLocalName;
    //     return $copy;
    // }

    // public function __toString()
    // {

    //     Helper::printLabelValue("isoLang", $this->isoLang);
    //     Helper::printLabelValue("langName", $this->langName);
    //     Helper::printLabelValue("langLocalName", $this->langLocalName);
    // }
}
