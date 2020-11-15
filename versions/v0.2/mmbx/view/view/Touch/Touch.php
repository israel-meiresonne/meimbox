<?php
require_once 'framework/View.php';

/**
 * Represente a clickable touch
 */
class Touch extends View
{
    /**
     * Holds content of the Touch
     * @var string
     */
    private $content;

    /**
     * Holds the number of notif on the Touch
     * @var int
     */
    private $nbNofif;

    /**
     * Holds vertical and horizontal position of the notification
     * @var Map
     * + $positionMap[Map::vertical] => [top|bottom]
     * + $positionMap[Map::side] => [left|right]
     */
    private $positionMap;

    /**
     * Constructor
     */
    public function __construct($content, int $nbNofif = null, Map $positionMap)
    {
        $this->content = $content;
        if((!empty($nbNofif)) && ($nbNofif > 0)){
            $dir = $positionMap->get(Map::vertical);
            if(($dir != self::DIRECTION_TOP) && ($dir != self::DIRECTION_BOTTOM)){
                throw new Exception("The vertical position of the notification('$dir') is incorrect");
            }
            $side = $positionMap->get(Map::side);
            if(($side != self::DIRECTION_LEFT) && ($side != self::DIRECTION_RIGHT)){
                throw new Exception("The side of the notification('$side') is incorrect");
            }
            $this->nbNofif = $nbNofif;
            $this->positionMap = $positionMap;
        }
    }

    /**
     * To get Touch's content
     * @return string Touch's content
     */
    private function getContent()
    {
        return $this->content;
    }
    /**
     * To get Touch's number of notification
     * @return int Touch's number of notification
     */
    private function getNbNofif()
    {
        return $this->nbNofif;
    }
    /**
     * To get the position Map of Touch's notification
     * @return Map  the position Map of Touch's notification
     */
    private function getPositionMap()
    {
        return $this->positionMap;
    }

    public function __toString()
    {
        $datas = [
            "content" => $this->getContent(),
            "nbNofif" => $this->getNbNofif(),
            "positionMap" => $this->getPositionMap(),
        ];
        return $this->generateFile('view/view/Touch/files/touch.php', $datas);
    }
}