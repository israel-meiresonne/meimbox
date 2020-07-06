<?php

class Translator
{
    /**
     * Hold a map with containt translation ordered by post and language. 
     * $stationMap = [
     *     usedInside => [                       
     *         index => [                      
     *             iso_lang => string          
     *         ]
     *     ]
     * ]
     * // name of the file or the method where is used the station
     * // index = station : is the number of the station
     * // string is the translation
     */
    private $stationMap;

    /**
     * Holds a translation map witch give the translation of english word to 
     * other language. 
     * $translationMap = [
     *      translation => [        // translation is the string to translate from englesh to other language
     *          iso_lang => string  // string is the translation
     *      ]
     *  ]
     * @var $transMap
     */
    private $translationMap;

    /**
     * Holds the Visitor's current language. It's used to translate
     * @var Language 
     */
    private $language;

    // /**
    //  * Holds the default lagnuage's iso code 2
    //  * @var string 
    //  */
    // private $defaultIsoLang = "DEFAULT_LANGUAGE";

    /**
     * Constructor
     * @param Language $language the Visitor's current language
     * @var string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    function __construct($language, $dbMap)
    {
        $this->stationMap = $dbMap["stationMap"];
        $this->translationMap = $dbMap["translationMap"];
        $this->language = $language;
        // $this->defaultIsoLang = $dbMap["constantMap"][$this->defaultIsoLang]["stringValue"];
    }

    /**
     * Give the translation of a string for a specified station. 
     * If there is any translation of the string for asked station, a 
     * translation is returned in the default language of the 
     * Translator
     * @param int $station the id of the station where to get the translation
     * @return string the translation at the station and into the language given in param
     */
    public function translateStation($fileName, $station){
        // $isoLang = gettype($language) == "string" ? $language : $language->getIsoCode();
        $isoLang = $this->language->getIsoLang();
        return !empty($this->stationMap[$fileName][$station][$isoLang]) ? $this->stationMap[$fileName][$station][$isoLang]
                                                             : $this->stationMap[$fileName][$station][$this->language->getDEFAULT_LANGUAGE()];
    }

    /**
     * Give the translation of a string given in param. 
     * If there is any translation of the string and language 
     * asked, a translation is returned in the default language of the 
     * Translator
     * @param int $station the id of the station to get the translation
     * @return string the translation at the station and into the language given in param
     */
    public function translateString($string){
        // $isoLang = gettype($language) == "string" ? $language : $language->getIsoCode();
        $isoLang = $this->language->getIsoLang();
        return !empty($this->translationMap[$string][$isoLang]) ? $this->translationMap[$string][$isoLang]
                                                             : $string;
    }
}
