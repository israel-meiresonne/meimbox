<?php

class Navigation
{
    /**
     * @var Page[]
     */
    private $pages;

    /**
     * @var Action[]
     */
    private $actions;

    private $BACK_DATE;

    private static $NB_DAYS_BEFORE;

    function __construct($userID, $dbMap)
    {
        self::setConstants($dbMap);
        
        $db = $dbMap["db"];
        // Navigation::setNB_DAYS_BEFORE($db);
        $this->BACK_DATE = date('Y-m-d 00:00:00', strtotime('-' . self::$NB_DAYS_BEFORE . 'days'));
        $this->pages = [];
        $this->actions = [];
        Navigation::setPages($db, $userID);
        Navigation::setActions($db, $userID);
    }

    /**
     * Initialize Navigator's constants
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    private function setConstants($dbMap){
        if(!isset(self::$NB_DAYS_BEFORE)){
            self::$NB_DAYS_BEFORE = "NB_DAYS_BEFORE";
            self::$NB_DAYS_BEFORE = $dbMap["constantMap"][self::$NB_DAYS_BEFORE]["stringValue"];
        }
    }

    /**
     * Get user's navigation history from Database since $BACK_DATE days and creat Page objects with.
     * If user hasn't any history, this methode get all history since $BACK_DATE days
     * @param Database $db
     * @param int $userID
     */
    private function setPages($db, $userID)
    {
        $query =
            'SELECT * 
        FROM `Pages` pg
        JOIN PagesParameters pp ON pg.userId = pp.userId && pg.setDate = pp.setDate_ && pg.page = pp.page_
        WHERE pg.userId = "' . $userID . '" && pg.setDate >= "' . $this->BACK_DATE . '" 
        ORDER BY pg.setDate ASC';

        $userNavTable = $db->select($query); // Table = Pages + PagesParameters

        if (count($userNavTable) > 0) {
            Navigation::createPushPageObj($userNavTable);
        } else {
            $query =
                'SELECT * 
            FROM `Pages` pg
            JOIN PagesParameters pp ON pg.userId = pp.userId && pg.setDate = pp.setDate_ && pg.page = pp.page_
            WHERE pg.setDate >= "' . $this->BACK_DATE . '" 
            ORDER BY pg.setDate ASC';
            $allNavTable = $db->select($query); // Table = Pages + PagesParameters

            Navigation::createPushPageObj($allNavTable);
        }
    }

    /**
     * Get user's actions history in Database since $BACK_DATE and create Action object with each action
     * @param Database $db
     * @param int $userID
     */
    private function setActions($db, $userID)
    {
        $query =
            'SELECT * 
            FROM `Pages-Actions`
            WHERE userId = "' . $userID . '" && setDate >= "' . $this->BACK_DATE . '" 
            ORDER BY setDate ASC';
        $actionPageTable = $db->select($query);

        if (count($actionPageTable) > 0) {
            foreach ($actionPageTable as $line) {
                $action = new Action($line["page"], $line["setDate"], $line["action"], $line["on"], $line["onName"], $line["response"]);
                $key = $action->getDateInSec();
                $this->actions[$key] = $action;
                ksort($this->actions);
            }
        }
    }

    /**
     * This method create and push Page object in self::pages
     * @param array Pages + PagesParameters
     */
    private function createPushPageObj($dbTable)
    {
        $lastUserId = $dbTable[0]["userId"];
        $lastSetDate = $dbTable[0]["setDate"];
        $nbLine = count($dbTable);

        for ($i = 0; $i < $nbLine;) {
            $page = new Page($dbTable[$i]["page"], $dbTable[$i]["setDate"], $dbTable[$i]["timeOn"]);
            while ($dbTable[$i]["userId"] == $lastUserId && $dbTable[$i]["setDate"] == $lastSetDate) {
                $page->addParam($dbTable[$i]["param_key"], $dbTable[$i]["param_data"]);
                $i++;
            }
            $key = $page->getDateInSec();
            $this->pages[$key] = $page;
            ksort($this->pages);

            $lastUserId = $dbTable[$i]["userId"];
            $lastSetDate = $dbTable[$i]["setDate"];
        }
    }

    /**
     * Get in Database the number of days to go back in navigation history
     * @param Database $db
     * @return int number of day
     */
    private function setNB_DAYS_BEFORE($db)
    {
        $constantsTable = $db->select('SELECT * FROM `Constants` WHERE constName = "NB_DAYS_BEFORE"');
        if (count($constantsTable) > 0) {
            self::$NB_DAYS_BEFORE = (int) $constantsTable[0]["stringValue"];
        }
    }

    public function __toString()
    {

        foreach ($this->pages as $page) {
            $page->__toString();
        }
        foreach ($this->actions as $action) {
            $action->__toString();
        }
        // $this->pages->__toString();
        Helper::printLabelValue("BACK_DATE", $this->BACK_DATE);
        Helper::printLabelValue("NB_DAYS_BEFORE", self::$NB_DAYS_BEFORE);
    }
}
