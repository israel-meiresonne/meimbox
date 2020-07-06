<?php

require_once 'ControllerSecure.php';

class ControllerHome extends ControllerSecure
{
    public function index()
    {
        $this->secureSession();
        $language = $this->person->getLanguage();
        $this->generateView($language);
    }
}
