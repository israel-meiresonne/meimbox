<?php
require_once 'ControllerSecure.php';

class ControllerLanding extends ControllerSecure
{
    public function index()
    {
        $this->generateView([], $this->person);
    }
}