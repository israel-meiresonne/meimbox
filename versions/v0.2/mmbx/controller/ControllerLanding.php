<?php
require_once 'ControllerSecure.php';

class ControllerLanding extends ControllerSecure
{
    public function index()
    {
        $person = $this->getPerson();
        $constantsMap = new Map(Configuration::getFromJson(Configuration::JSON_KEY_CONSTANTS));
        $maxScroll = $constantsMap->get(Map::ad_config, Map::max_scroll);
        $datasView = [
            "maxScroll" => $maxScroll,
            "pxlEvnt" => Pixel::EVENT_LP_TIME_UP
        ];
        $this->generateView($datasView, $person);
    }
}
