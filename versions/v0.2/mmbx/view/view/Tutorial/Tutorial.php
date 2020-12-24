<?php
require_once 'view/view/MiniPopUp/MiniPopUp.php';

class Tutorial extends MiniPopUp
{
    /**
     * Holds the steps of the Tutorial
     * @var Map
     * + Map[index{int}][Map::id]           => {string}    id of the step
     * + Map[index{int}][Map::name]         => {string}    name of the step
     * + Map[index{int}][Map::direction]    => {string}    View's direction constant
     * + Map[index{int}][Map::content]      => {string}    content to place in the Tutorial
     */
    private $stepsMap;

    /**
     * Holds type of Tutorial's button
     * @var string
     */
    public const TYPE_SKIP = "type_skip";
    public const TYPE_NEXT = "type_next";
    public const TYPE_CLOSE = "type_close";

    /**
     * Holds class to place on Minipop's wrapper tag
     * @var string
     */
    private const CLASS_MINIPOPUP = "tutorial-dad";

    /**
     * Constructor
     * @param Map $stepsMap the steps of the Tutorial
     *                      + Map[index{int}][Map::name]        => {string}    name of the step
     *                      + Map[index{int}][Map::direction]   => {string}    View's direction constant
     *                      + Map[index{int}][Map::content]     => {string}    content to place in the Tutorial
     */
    public function __construct(Map $stepsMap)
    {
        if (!isset($stepsMap)) {
            throw new Exception("stepsMap must be setted");
        }
        $indexes = $stepsMap->getKeys();
        if (empty($indexes)) {
            throw new Exception("stepsMap can't be empty");
        }
        foreach ($indexes as $index) {
            $id = ModelFunctionality::generateDateCode(25);
            $stepsMap->put($id, $index, Map::id);
        }

        $this->stepsMap = $stepsMap;
    }

    /**
     * To get MiniPopUp's id
     * @param int $index index of a step in stepsMap
     * @return string MiniPopUp's id
     */
    public function getStepId(int $index)
    {
        return $this->getStepDatas($index, Map::id);
        // return $this->id;
    }

    /**
     * To get Tutorial's diercetion
     * @param int $index index of a step in stepsMap
     * @return string Tutorial's diercetion
     */
    private function getDirection(int $index)
    {
        return $this->getStepDatas($index, Map::direction);
    }

    /**
     * To get Tutorial's content
     * @param int $index index of a step in stepsMap
     * @return string Tutorial's content
     */
    private function getContent(int $index)
    {
        return $this->getStepDatas($index, Map::content);
    }

    /**
     * To get map of steps
     * @return Map map of steps
     */
    private function getStepsMap()
    {
        return $this->stepsMap;
    }

    /**
     * To get map of steps
     * + Note: only call this function in getter
     * @return Map map of steps
     */
    private function getStepDatas(int $index, $dataKey)
    {
        $stepsMap = $this->getStepsMap();
        $data = $stepsMap->get($index, $dataKey);
        if (!isset($data)) {
            throw new Exception("This data '$data' don't exist in stepsMap for the index '$index'");
        }
        return $data;
    }

    /**
     * To get Step of the given index
     * @param int $index index of a step in stepsMap
     * @return MiniPopUp minipop containing its Tutorial
     */
    public function getStep(int $index)
    {
        $stepsMap = $this->getStepsMap();
        $indexes = $stepsMap->getKeys();
        if (!in_array($index, $indexes)) {
            throw new Exception("There no step with this index '$index' in stepsMap");
        }
        $content = $this->generateStep($index);
        $direction = $this->getDirection($index, Map::direction);
        $id = $this->getStepId($index);
        $miniPopUp = new MiniPopUp($direction, $content, $id);
        ($index == 0) ? $miniPopUp->setClasses(self::CLASS_MINIPOPUP) : null;
        return $miniPopUp;
    }

    /**
     * To generate step with the given index
     * @param int $index index of a step in stepsMap
     * @return string step generated with the given index
     */
    private function generateStep(int $index)
    {
        $datas = [
            "id" => $this->getStepId($index),
            "classes" => $this->getClasses(),
            "direction" => $this->getDirection($index, Map::direction),
            "content" => $this->getContent($index, Map::content),
            "buttonsMap" => $this->generateButtons($index)
        ];
        return $this->generateFile('view/view/Tutorial/files/tutorial.php', $datas);
    }

    /**
     * To generate Tutorial's buttons
     * @param int $index index of a step in stepsMap
     * @return Map Tutorial's buttons
     *             + Map[Map::left]     => {string}
     *             + Map[Map::right]    => {string}
     */
    private function generateButtons(int $index)
    {
        $buttonsMap = new Map();
        $stepsMap  = $this->getStepsMap();
        $indexes = $stepsMap->getKeys();
        $isLast = (array_reverse($indexes)[0] == $index);
        $id = $this->getStepId($index);
        if ($isLast) {
            $datas = [
                "id" => $id,
                "type" => self::TYPE_CLOSE
            ];
            $close = $this->generateFile('view/view/Tutorial/files/tutorialButton.php', $datas);
            $buttonsMap->put($close, self::DIRECTION_RIGHT);
        } else {
            $nextIndex = $indexes[array_search($index, $indexes) + 1];
            $nextId = $this->getStepId($nextIndex);
            $datas = [
                "id" => $id,
                "nextId" => $nextId,
                "type" => self::TYPE_NEXT,
            ];
            $next = $this->generateFile('view/view/Tutorial/files/tutorialButton.php', $datas);
            $buttonsMap->put($next, self::DIRECTION_RIGHT);
            $datas = [
                "id" => $id,
                "type" => self::TYPE_SKIP
            ];
            $skip = $this->generateFile('view/view/Tutorial/files/tutorialButton.php', $datas);
            $buttonsMap->put($skip, self::DIRECTION_LEFT);
        }
        return $buttonsMap;
    }
}
