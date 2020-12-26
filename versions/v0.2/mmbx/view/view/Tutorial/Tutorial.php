<?php
require_once 'view/view/MiniPopUp/MiniPopUp.php';

class Tutorial extends MiniPopUp
{
    /**
     * Holds the steps of the Tutorial
     * @var Map
     * + Map[index{int}][Map::tutoID]       => {string}    id of the Tutorial in database
     * + Map[index{int}][Map::id]           => {string}    id of the step
     * + Map[index{int}][Map::name]         => {string}    name of the step
     * + Map[index{int}][Map::direction]    => {string}    View's direction constant
     * + Map[index{int}][Map::content]      => {string}    content to place in the Tutorial
     * + Map[index{int}][Map::obj]          => {MiniPopUp} MiniPopUp generated with a step
     */
    private $stepsMap;

    /**
     * Holds the event code to use in all steps with different params
     * @var string
     */
    private $eventCode;

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
     * Holds access key for Tutorial's id
     * @var string
     */
    public const TUTO_ID_K = "tuto_id_k";

    /**
     * Holds access key for Tutorial
     * @var string
     */
    public const TUTO_TYPE_K = "tuto_type_k";
    public const NAME_K = "tuto_name_k";
    public const STEP_POSITION_K = "tuto_pos_k";
    public const STEP_TOT_K = "tuto_tot_k";
    public const STEP_ACTION_K = "tuto_action_k";

    /**
     * Constructor
     * @param Map       $stepsMap   the steps of the Tutorial
     *                              + Map[index{int}][Map::name]        => {string}    name of the step
     *                              + Map[index{int}][Map::direction]   => {string}    View's direction constant
     *                              + Map[index{int}][Map::content]     => {string}    content to place in the Tutorial
     * @param string    $eventCode  the steps of the Tutorial
     */
    public function __construct(Map $stepsMap, string $eventCode)
    {
        if (!isset($stepsMap)) {
            throw new Exception("stepsMap must be setted");
        }
        $indexes = $stepsMap->getKeys();
        if (empty($indexes)) {
            throw new Exception("stepsMap can't be empty");
        }
        $cleanedSteapMap = new Map();
        $i = 0;
        foreach ($indexes as $index) {
            $id = ModelFunctionality::generateDateCode(25);
            $step = $stepsMap->get($index);
            $cleanedSteapMap->put($step, $i);
            $cleanedSteapMap->put($id, $index, Map::id);
            $i++;
        }
        $this->stepsMap = $cleanedSteapMap;
        $this->eventCode = $eventCode;
    }

    /**
     * To get MiniPopUp's id
     * @param int $index index of a step in stepsMap
     * @return string MiniPopUp's id
     */
    public function getStepId(int $index)
    {
        return $this->getStepDatas($index, Map::id);
    }

    /**
     * To get Tutorial's tutoID
     * @param int $index index of a step in stepsMap
     * @return string Tutorial's tutoID
     */
    private function getTutoID(int $index)
    {
        return $this->getStepDatas($index, Map::tutoID);
    }

    /**
     * To get Tutorial's name
     * @param int $index index of a step in stepsMap
     * @return string Tutorial's name
     */
    private function getStepName(int $index)
    {
        return $this->getStepDatas($index, Map::name);
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
     * To get Tutorial's event code
     * @return string Tutorial's event code
     */
    private function getEventCode()
    {
        return $this->eventCode;
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
        $miniPopUp = $stepsMap->get(Map::obj);
        if (empty($miniPopUp)) {
            $content = $this->generateStep($index);
            $direction = $this->getDirection($index, Map::direction);
            $id = $this->getStepId($index);
            $miniPopUp = new MiniPopUp($direction, $content, $id);
            ($index == 0) ? $miniPopUp->setClasses(self::CLASS_MINIPOPUP) : null;
        }
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
        $tutoID = $this->getTutoID($index);
        $eventCode = $this->getEventCode();
        $id = $this->getStepId($index);
        $name = $this->getStepName($index);
        $position = ($index + 1);
        $nbStep = count($indexes);
        if ($isLast) {
            $datas = [
                "tutoID" => $tutoID,
                "eventCode" => $eventCode,
                "id" => $id,
                "type" => self::TYPE_CLOSE,
                "name" => $name,
                "position" => $position,
                "nbStep" => $nbStep
            ];
            $close = $this->generateFile('view/view/Tutorial/files/tutorialButton.php', $datas);
            $buttonsMap->put($close, self::DIRECTION_RIGHT);
        } else {
            $nextIndex = $indexes[array_search($index, $indexes) + 1];
            $nextId = $this->getStepId($nextIndex);
            $datas = [
                "tutoID" => $tutoID,
                "eventCode" => $eventCode,
                "id" => $id,
                "nextId" => $nextId,
                "type" => self::TYPE_NEXT,
                "name" => $name,
                "position" => $position,
                "nbStep" => $nbStep
            ];
            $next = $this->generateFile('view/view/Tutorial/files/tutorialButton.php', $datas);
            $buttonsMap->put($next, self::DIRECTION_RIGHT);
            $datas = [
                "tutoID" => $tutoID,
                "eventCode" => $eventCode,
                "id" => $id,
                "type" => self::TYPE_SKIP,
                "name" => $name,
                "position" => $position,
                "nbStep" => $nbStep
            ];
            $skip = $this->generateFile('view/view/Tutorial/files/tutorialButton.php', $datas);
            $buttonsMap->put($skip, self::DIRECTION_LEFT);
        }
        return $buttonsMap;
    }
}
