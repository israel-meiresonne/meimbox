<?php

class Administrator extends User {
    
    /**
     * Constructor
     * @param int $userID
     */
    function __construct($userID)
    {
        parent::__construct($userID);
    }

    public function __toString()
    {
        parent::__toString();
    }
}