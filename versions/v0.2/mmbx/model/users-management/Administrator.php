<?php

class Administrator extends User
{
    /**
     * Holds the class's name
     */
    public const CLASS_NAME = "Administrator";


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
