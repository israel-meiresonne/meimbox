<?php

require_once 'model/ModelFunctionality.php';

/**
 * This class provide traduction for the system
 * + it holded by the View and can be instanciated only one time by the View's 
 * constructor
 */
class Translator extends ModelFunctionality
{
    /**
     * Hold a map with containt translation ordered by post and language. 
     * + $stationMap = [
     *      station => [                      
     *          iso_lang => translation{string}
     *      ]
     * ]
     */
    private static $stationMap;

    /**
     * Holds a translation map witch give the translation of english word to 
     * other language. 
     * $translateMap = [
     *      translation => [        // translation is the string to translate from english to other language
     *          iso_lang => string  // string is the translation
     *      ]
     *  ]
     * @var $transMap
     */
    private static $translateMap;

    /**
     * Holds the Visitor's current language. 
     * + It's used to translate
     * @var Language 
     */
    private $language;

    private static $nbInstance;

    // /**
    //  * Holds the default lagnuage's iso code 2
    //  * @var string 
    //  */
    // private $defaultIsoLang = "DEFAULT_LANGUAGE";

    /**
     * Constuctor
     * @param Language $language the Visitor's current language
     */
    public function __construct(Language $language = null)
    {
        if(isset(self::$nbInstance)){
            throw new Exception("Traduction class can be instanciated one time only!");
        }
        self::$nbInstance++;
        $this->language = isset($language) ? $language : new Language();
        (!isset(self::$stationMap)) ? $this->setStationMap() : null;
        (!isset(self::$translateMap)) ? $this->setTranslateMap() : null;
    }

    /**
     * Setter for stationMap
     */
    private function setStationMap()
    {
        self::$stationMap = [];
        $tab = $this->select("SELECT * FROM `TranslationStations`");
        foreach ($tab as $tabLine) {
            $station = $tabLine["station"];
            $iso_lang = $tabLine["iso_lang"];
            $translation = $tabLine["translation"];
            self::$stationMap[$station][$iso_lang] = $translation;
        }
    }

    /**
     * Setter for translateMap
     */
    private function setTranslateMap()
    {
        self::$translateMap = [];
        $tab = $this->select("SELECT * FROM `Translations`");
        foreach($tab as $tabLine){
            self::$translateMap[$tabLine["en"]][$tabLine["iso_lang"]] = $tabLine["translation"];
        }
    }

    /**
     * Give the translation of a string for a specified station. 
     * + If there is any translation of the string for asked station, a 
     * translation is returned in the default language of the 
     * Translator
     * @param string $station the id of the station where to get the translation
     * @return string the translation at the station and into the language given in param
     */
    public function translateStation($station)
    {
        (!isset(self::$stationMap)) ? $this->setStationMap() : null;
        // var_dump(self::$stationMap);
        // echo "<hr>";
        $isoLang = $this->language->getIsoLang();
        return !empty(self::$stationMap[$station][$isoLang]) ? self::$stationMap[$station][$isoLang]
            : self::$stationMap[$station][$this->language->getDEFAULT_LANGUAGE()];
    }

    /**
     * Give the translation of a text given in param. 
     * + If there is any translation for the text in the language 
     * asked, the text is returned
     * @param string $text to translate
     * @return string the text's translation else the text
     */
    public function translateString($text)
    {
        (!isset(self::$translateMap)) ? $this->setTranslateMap() : null;
        $isoLang = $this->language->getIsoLang();
        return !empty(self::$translateMap[$text][$isoLang]) ? self::$translateMap[$text][$isoLang]
            : $text;
    }
}
