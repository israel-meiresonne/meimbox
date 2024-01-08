<?php
require_once 'model/users-management/Client.php';
require_once 'model/API/BlueAPI/BlueEvent.php';

class Administrator extends Client
{
    /**
     * Constructor
     * @param int $userID
     */
    function __construct($ADM_VAL = null)
    {
        $ADM_VAL = (empty($ADM_VAL)) ? Cookie::getCookieValue(Cookie::COOKIE_ADM) : $ADM_VAL;
        if (empty($ADM_VAL)) {
            throw new Exception("Administrator cookie can't be empty");
        }
        $CLT_VAL = $this->getCLT_VAL($ADM_VAL);
        parent::__construct($CLT_VAL);
        $this->manageCookie(Cookie::COOKIE_ADM, true);
    }

    /**
     * To extract from db value of Admin's Client cookie
     * @param string $ADM_VAL value of the Administrator cookie
     * @return string value of Admin's Client cookie
     */
    private function getCLT_VAL($ADM_VAL)
    {
        $cookieID = Cookie::COOKIE_ADM;
        $sql = "SELECT * 
        FROM `Users-Cookies`
        WHERE `cookieId`='CLT' AND `userId`=(SELECT `userId` 
                                             FROM `Users-Cookies`
                                             WHERE `cookieId`='$cookieID' AND `cookieValue`='$ADM_VAL')";
        $tab = $this->select($sql);
        if (empty($tab) || count($tab) != 1) {
            throw new Exception("Number of line can't be different than 1");
        }
        $tabLineMap = new Map($tab[0]);
        return $tabLineMap->get(Map::cookieValue);
    }

    /**
     * To handle event sent by Sendinblue
     * @param Response $response to push in result or accured error
     */
    public function handleBlueEvents(Response $response)
    {
        $blueEvent = new BlueEvent();
        $blueEvent->handleEvent($response);
    }
}
