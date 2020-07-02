<?php

require_once 'ControllerSecure.php';

class ControllerHome extends Secure
{
    public function index()
    {
        $this->generateView();
    }
}
