<?php
require_once 'framework/View.php';

class DropDown extends View
{
    /**
     * Holds the name of the dropdown that will be displayed
     * @var string
     */
    private $title;

    /**
     * Holds all datas required to build inputs
     * + NOTE: only one input can have Map::isChecked set on true
     * @var Map
     * + $inputMap[label][Map::inputName]   =>  string,
     * + $inputMap[label][Map::inputValue]  =>  string,
     * + $inputMap[label][Map::isChecked]   =>  boolean,    set true to check input else false
     * + $inputMap[label][Map::inputFunc]   =>  string|null function to place on the input
     */
    private $inputMap;

    /**
     * Holds function that will be placed on all input
     * @var string
     */
    private $commonFunc;

    /**
     * Indicate if the inputs are radio or just checkbox
     * @var bool set true if it's radio else false
     */
    private $isRadio;

    /**
     * Indicate if Dropdown's body will be displayed
     * @var bool set true to display content else set false
     */
    private $isDisplayed;

    /**
     * Constructor
     * @param string    $title          the name of the dropdown that will be displayed
     * @param Map       $inputMap       all datas required to build inputs
     *                                  + $inputMap[label][Map::inputName]   =>  string,
     *                                  + $inputMap[label][Map::inputValue]  =>  string,
     *                                  + $inputMap[label][Map::isChecked]   =>  boolean,    set true to check input else false
     *                                  + $inputMap[label][Map::inputFunc]   =>  string|null function to place on the input
     * @param string    $commonFunc     function that will be placed on all input
     * @param bool      $isRadio        set true if it's radio else false
     * @param bool      $isDisplayed    set true to display content else set false
     */
    public function __construct($title, $inputMap, $commonFunc, $isRadio, $isDisplayed)
    {
        $this->title = $title;
        $this->inputMap = $inputMap;
        $this->commonFunc = $commonFunc;
        $this->isRadio = (bool) $isRadio;
        $this->isDisplayed = (bool) $isDisplayed;
    }

    /**
     * To get Title
     * @return string
     */
    private function getTitle()
    {
        return $this->title;
    }

    /**
     * To get InputMap
     * @return Map
     */
    private function getInputMap()
    {
        return $this->inputMap;
    }

    /**
     * To get CommonFunc
     * @return string
     */
    private function getCommonFunc()
    {
        return $this->commonFunc;
    }

    /**
     * To get adio
     * @return bool
     */
    private function isRadio()
    {
        return $this->isRadio;
    }

    /**
     * To get isplayed
     * @return bool
     */
    private function isDisplayed()
    {
        return $this->isDisplayed;
    }

    public function __toString()
    {
        $datas = [
            "title" => $this->getTitle(),
            "inputMap" => $this->getInputMap(),
            "func" => $this->getCommonFunc(),
            "isRadio" => $this->isRadio(),
            "isDisplayed" => $this->isDisplayed(),
        ];
        return $this->generateFile('view/elements/dropdown/dropdown2.php', $datas);
    }
}
