<?php
require_once 'ControllerSecure.php';

class ControllerLanding extends ControllerSecure
{
    public function index()
    {
        $person = $this->getPerson();
        $constantsMap = new Map(Configuration::getFromJson(Configuration::JSON_KEY_CONSTANTS));
        $maxScroll = $constantsMap->get(Map::ad_config, Map::scroll_up);
        $pxlDatas = [strtolower(Page::class) => $this->extractController(ControllerLanding::class)];
        $pxlJson = json_encode($pxlDatas);
        $sql = "SELECT picture
                FROM `Products`p
                JOIN `ProductsPictures`pp ON p.`prodID`=pp.`prodId`
                WHERE pp.`pictureID`=0
                ORDER BY p.`prodRate`  DESC
                LIMIT 99";
        $picturesTab = Search::execute($sql);
        $datasView = [
            "maxScroll" => $maxScroll,
            "pxlEvnt" => Pixel::EVENT_SCROLL_OVER,
            "pxlJson" => $pxlJson,
            "picturesTab" => $picturesTab
        ];
        $this->generateView($datasView, $person);
    }
}
