<?php

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


    protected function __construct($dbMap){
        parent::__construct($dbMap);
        $this->mail = $dbMap["usersMap"]["userDatas"]["mail"];
        $this->firstname = $dbMap["usersMap"]["userDatas"]["firstname"];
        $this->lastname = $dbMap["usersMap"]["userDatas"]["lastname"];
        $this->birthday = $dbMap["usersMap"]["userDatas"]["birthday"];
        $this->sexe = $dbMap["usersMap"]["userDatas"]["sexe_"];
    }

    
    public function __toString()
    {
        parent::__toString();
        Helper::printLabelValue("mail", $this->mail);
        Helper::printLabelValue("password", null);
        Helper::printLabelValue("firstname", $this->firstname);
        Helper::printLabelValue("lastname", $this->lastname);
        Helper::printLabelValue("birthday", $this->birthday);
        Helper::printLabelValue("sexe", $this->sexe);
        foreach ($this->addresses as $address) {
            $address->__toString();
        }
    }
}