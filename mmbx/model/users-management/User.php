<?php

require_once 'model/users-management/Visitor.php';

abstract class User extends  Visitor{
    
    // protected $password;
    
    /**
     * Holds the mail of the user
     * @var string
     */
    protected $mail;
    
    /**
     * Holds the firstname of the user
     * @var string
     */
    protected $firstname;
    
    /**
     * Holds the lastname of the user
     * @var string
     */
    protected $lastname;
    
    /**
     * Holds the birthday of the user
     * @var string
     */
    protected $birthday;

    /**
     * Holds the sexe of the user
     * @var string
     */
    protected $sexe;
    
    /**
     * .
     * The selected address have to move to index = 0
     * @var Address[]
     */
    protected $addresses;

    protected $userLine;


    protected function __construct($userID){
        parent::__construct();
        $this->userID = $userID;
        $this->userLine = $this->select("SELECT * FROM `Users` WHERE `userID` = '$this->userID'")[0];
        $this->mail = $this->userLine["mail"];
        $this->firstname = $this->userLine["firstname"];
        $this->lastname = $this->userLine["lastname"];
        $this->birthday = $this->userLine["birthday"];
        $this->sexe = $this->userLine["sexe_"];
    }

    
    // public function __toString()
    // {
    //     parent::__toString();
    //     Helper::printLabelValue("mail", $this->mail);
    //     Helper::printLabelValue("password", null);
    //     Helper::printLabelValue("firstname", $this->firstname);
    //     Helper::printLabelValue("lastname", $this->lastname);
    //     Helper::printLabelValue("birthday", $this->birthday);
    //     Helper::printLabelValue("sexe", $this->sexe);
    //     foreach ($this->addresses as $address) {
    //         $address->__toString();
    //     }
    // }
}