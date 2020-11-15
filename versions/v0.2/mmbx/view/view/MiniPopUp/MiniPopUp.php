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
     * Constructor
     */
    public function __construct($direction, $content)
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
        $this->id = ModelFunctionality::generateDateCode(25);
        $this->content = $content;
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
     * To get Touch's content
     * @return string Touch's content
     */
    private function getContent()
    {
        return $this->content;
    }

    public function __toString()
    {
        $datas = [
            "id" => $this->getId(),
            "direction" => $this->getDirection(),
            "content" => $this->getContent()
        ];
        return $this->generateFile('view/view/MiniPopUp/files/miniPopUp.php', $datas);
    }
}
