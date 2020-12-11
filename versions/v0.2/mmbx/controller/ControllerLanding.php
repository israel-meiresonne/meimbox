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
        // $pxlJson = htmlentities(json_encode($pxlDatas));
        $pxlJson = json_encode($pxlDatas);
        $datasView = [
            "maxScroll" => $maxScroll,
            "pxlEvnt" => Pixel::EVENT_SCROLL_OVER,
            "pxlJson" => $pxlJson
        ];
        $this->generateView($datasView, $person);
    }
}
