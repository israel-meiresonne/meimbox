<?php
require_once 'model/ModelFunctionality.php';

/**
 * This class represente a action done on a web page by the Visitor
 */
class Action extends ModelFunctionality
{
    /**
     * Holds the action done
     * @var string
     */
    private $action;

    /**
     * Holds support where the Action's applied
     * @var string
     */
    private $element;

    /**
     * Holds identifient of the support where the Action's applied
     * @var string
     */
    private $name;

    /**
     * Holds the result of the action
     * @var string
     */
    private $result;

    /**
     * Holds datas related to the action
     * @var Map
     */
    private $datas;

    /**
     * @var string
     */
    private $setDate;

    /**
     * Holds available actions
     * @var Map
     */
    private $actionMap;
    public const ACT_CLICK = "click";
    public const ACT_FOCUS = "focus";
    public const ACT_UNFOCUS = "unfocus";
    public const ACT_CHANGE = "change";
    public const ACT_SCROLL = "scroll";

    /**
     * Holds available support
     * @var Map
     */
    private $onMap;
    public const ON_BUTTON = "button";
    public const ON_PAGE = "page";
    public const ON_LINK = "link";
    public const ON_TEXT = "text";

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setConstants();
        $args = func_get_args();
        switch (func_num_args()) {
            case 4:
                $this->__construct4($args[0], $args[1], $args[2], $args[3]);
                break;
        }
    }

    /**
     * @param string $action
     * @param string $element
     * @param string $name
     * @param string $result
     */
    private function __construct4($action, $element, $name, $result, Map $datas = null)
    {
        $this->action = $action;
        $this->element = $element;
        $this->name = $name;
        $this->result = $result;
        $this->datas = $datas;
    }

    /**
     * To set constants
     */
    private function setConstants()
    {
        if (!isset($this->actionMap)) {
            $this->actionMap = new Map();
        }
        if (!isset($this->onMap)) {
            $this->onMap = new Map();
        }
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->setDate);
    }
}
