<?php
require_once 'framework/View.php';

class MiniPopUp extends View
{
    /**
     * Holds MiniPopUp's id
     * @var string
     */
    private $id;

    /**
     * Holds the direction where to dipay the pop up following its relative elements
     * @var string  [up|down|left|right]
     */
    private $direction;

    /**
     * Holds MiniPopUp's content
     * @var string
     */
    private $content;

    /**
     * Holds additional class for the wrapper
     * @var string
     */
    private $classes;

    /**
     * Constructor
     * @param string    $direction  View's direction constant
     *                              + View::DIRECTION_*
     * @param mixed     $content    content to place in the MiniPopUp
     * @param mixed     $id         id for the MiniPopUp
     */
    public function __construct($direction, $content, $id = null)
    {
        switch ($direction) {
            case self::DIRECTION_BOTTOM:
            case self::DIRECTION_LEFT:
            case self::DIRECTION_RIGHT:
            case self::DIRECTION_TOP:
                $this->direction = $direction;
                break;

            default:
                throw new Exception("The MiniPopUp's direction('$direction') is incorrect");
                break;
        }
        $this->id = (isset($id)) ? $id : ModelFunctionality::generateDateCode(25);
        $this->content = $content;
    }

    /**
     * To set additional classes on wrapper
     * @param string $class additional classes
     */
    protected function setClasses(string $class)
    {
        $this->classes = $class;
    }

    /**
     * To get MiniPopUp's id
     * @return string MiniPopUp's id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * To get MiniPopUp's diercetion
     * @return string MiniPopUp's diercetion
     */
    private function getDirection()
    {
        return $this->direction;
    }

    /**
     * To get MiniPopUp's content
     * @return string MiniPopUp's content
     */
    private function getContent()
    {
        return $this->content;
    }

    /**
     * To get MiniPopUp's additional classes
     * @return string MiniPopUp's additional classes
     */
    protected function getClasses()
    {
        return $this->classes;
    }

    public function __toString()
    {
        $datas = [
            "id" => $this->getId(),
            "classes" => $this->getClasses(),
            "direction" => $this->getDirection(),
            "content" => $this->getContent()
        ];
        return $this->generateFile('view/view/MiniPopUp/files/miniPopUp.php', $datas);
    }
}
