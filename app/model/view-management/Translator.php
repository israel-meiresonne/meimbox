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

    private const PATTERN = "#{+}#";
    private const PATTERN_SALT = "+";

    /**
     * Constuctor
     * @param Language $language the Visitor's current language
     */
    public function __construct(Language $language = null)
    {
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
        foreach ($tab as $tabLine) {
            self::$translateMap[$tabLine["en"]][$tabLine["iso_lang"]] = $tabLine["translation"];
        }
    }

    /**
     * Give the translation of a string for a specified station. 
     * + If there is any translation of the string for asked station, a 
     * translation is returned in the default language of the 
     * Translator
     * @param string $station the id of the station where to get the translation
     * @param Map $replacements used to replace {key} in translation
     * + key => replacement
     * + NOTE: the replacement have to be Understandable in all language like number or brand name
     * @return string the translation at the station and into the language given in param
     */
    public function translateStation($station, Map $replacements = null)
    {
        (!isset(self::$stationMap)) ? $this->setStationMap() : null;
        $isoLang = $this->language->getIsoLang();
        $translation = !empty(self::$stationMap[$station][$isoLang]) ? self::$stationMap[$station][$isoLang]
            : self::$stationMap[$station][$this->language->getDEFAULT_LANGUAGE()];
        if (!empty($replacements)) {
            $translation = $this->replacePattern($translation, $replacements);
        }

        return $translation;
    }

    /**
     * Replace pattern found in translation
     * @param string $translation
     * @param Map $replacements used to replace {key} in translation
     * + key => replacement
     * + NOTE: the replacement have to be Understandable in all logage like number or brand name
     * @return string the translation given
     */
    private function replacePattern($translation, Map $replacements)
    {
        $patterns = $replacements->getKeys();
        foreach ($patterns as $key => $search) {
            $pattern = str_replace(self::PATTERN_SALT, $search, self::PATTERN);
            $patterns[$key] = $pattern;
        }
        return preg_replace($patterns, $replacements->getMap(), $translation);
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
        return (key_exists($text, self::$translateMap) && (!empty(self::$translateMap[$text][$isoLang])))
            ? self::$translateMap[$text][$isoLang]
            : $text;
    }

    /**
     * To get Translator's Language
     * @return Language
     */
    public function getLanguage() : Language
    {
        return $this->language;
    }
}
