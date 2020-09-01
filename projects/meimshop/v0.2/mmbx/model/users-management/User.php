<?php

require_once 'model/users-management/Visitor.php';

abstract class User extends  Visitor
{

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

    /**
     * Holds user's db line
     * + this attribut is used to avoid multiple request for each children
     * @var string[]
     */
    protected $userLine;

    /**
     * Constructor
     */
    protected function __construct($userID)
    {
        parent::__construct();
        $tab = $this->select("SELECT * FROM `Users` WHERE `userID` = '$userID'");
        if (count($tab) != 1) {
            throw new Exception("User with id '$this->userID' don't exist");
        }
        $this->userLine = $tab[0];
        $this->userID = $this->userLine["userID"];
        $this->setDate = $this->userLine["setDate"];
        $this->lang = new Language($this->userLine["lang_"]);
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
