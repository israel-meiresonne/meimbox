<?php

require_once 'ControllerSecure.php';

class ControllerHome extends ControllerSecure
{
    public function index()
    {
        $this->generateView();
    }
}
