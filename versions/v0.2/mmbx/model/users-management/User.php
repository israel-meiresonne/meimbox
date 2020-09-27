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
     * @param string $CLT_VAL value of the user's Client  cookie (Cookie::COOKIE_CLT)
     */
    protected function __construct($CLT_VAL)
    {
        // $tab = $this->select("SELECT * FROM `Users` WHERE `userID` = '$userID'");
        $sql = "SELECT u.* 
                FROM `Users-Cookies` uc
                JOIN `Users` u ON uc.`userId` = u.`userID`
                WHERE uc.`cookieId` = '" . Cookie::COOKIE_CLT . "'
                AND uc.`cookieValue` = '$CLT_VAL'";
        $tab = $this->select($sql);
        if (count($tab) != 1) {
            throw new Exception("User with Client cookie '$CLT_VAL' don't exist");
        }
        $this->userLine = $tab[0];
        $this->userID = $this->userLine["userID"];
        parent::__construct(User::class);

        $this->setDate = $this->userLine["setDate"];
        $this->lang = new Language($this->userLine["lang_"]);
        $this->mail = $this->userLine["mail"];
        $this->firstname = $this->userLine["firstname"];
        $this->lastname = $this->userLine["lastname"];
        $this->birthday = $this->userLine["birthday"];
        $this->sexe = $this->userLine["sexe_"];
    }
}
