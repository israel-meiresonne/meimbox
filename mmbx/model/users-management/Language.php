<?php
class Language
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
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    private function __construct0()
    {
    }

    private function __construct1($dbMap)
    {
        self::setConstants($dbMap);
        self::initLang($dbMap);
    }

    /**
     * Initialize Language's constants
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    private function setConstants($dbMap)
    {
        if (!isset(self::$DEFAULT_LANGUAGE)) {
            self::$DEFAULT_LANGUAGE = "DEFAULT_LANGUAGE";
            self::$DEFAULT_LANGUAGE = $dbMap["constantMap"][self::$DEFAULT_LANGUAGE]["stringValue"];
        }
    }


    function getIsoCode()
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
     * Get the language of the user's driver and check if it match a supported language of the website
     * if it match the attribute $langName is updated with the found value
     * otherwise the attribute $langName still at "en" (english)
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    private function initLang($dbMap) //[,-;]*fr[,-;]*
    {
        $linkLang = GeneralCode::clean($_GET["lang"]);
        $found = false;

        $found = isset($linkLang) ? self::setLanguage($linkLang, $dbMap) : $found;

        $driverLang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        $found = $found ? $found : self::setLanguage($driverLang, $dbMap);

        if (!$found) {
            $this->isoLang = self::$DEFAULT_LANGUAGE;
            $this->langName = $dbMap["languageMap"][self::$DEFAULT_LANGUAGE]["langName"];
            $this->langLocalName = $dbMap["languageMap"][self::$DEFAULT_LANGUAGE]["langLocalName"];
        }
    }

    /**
     * Check if the language given in param is supported by the website and 
     * if it supported set attribute isoLang, langName and langLocalName
     * @param string $language the iso code 2 of the language
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @return true if the language iso code is supported else false
     */
    private function setLanguage($language, $dbMap)
    {
        $languages = explode(",", $language);
        $isoLangSupported = array_keys($dbMap["languageMap"]);
        $nbSupportedLang = count($isoLangSupported);
        $nbLanguage = count($languages);
        $found = false;
        $j = 0;
        while ($j < $nbLanguage && !$found) {
            $i = 0;
            while ($i < $nbSupportedLang && !$found) {
                $isoLang = $isoLangSupported[$i];
                $filter = Language::buildRegEx($isoLang);
                if (preg_match($filter, $languages[$j]) == 1) {
                    $this->isoLang = $isoLang;
                    $this->langName = $dbMap["languageMap"][$isoLang]["langName"];
                    $this->langLocalName = $dbMap["languageMap"][$isoLang]["langLocalName"];
                    $found = true;
                }
                $i++;
            }
            $j++;
        }
        return $found;
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
     * To get a protected copy of the Language
     * @return Language a protected copy of the current language
     */
    public function getCopy()
    {
        $copy = new Language();
        $copy->isoLang = $this->isoLang;
        $copy->langName = $this->langName;
        $copy->langLocalName = $this->langLocalName;
        return $copy;
    }

    public function __toString()
    {

        Helper::printLabelValue("isoLang", $this->isoLang);
        Helper::printLabelValue("langName", $this->langName);
        Helper::printLabelValue("langLocalName", $this->langLocalName);
    }
}
