<?php

class Status {
    private $author;
    private $status;
    private $setDate;

    function __construct()
    {
        $argv = func_get_args();
        switch(func_num_args()){
            case 3:
                self::__construct3($argv[0], $argv[1], $argv[2]);
        }
    }

    private function __construct3($author, $status, $setDate){
        $this->author = $author;
        $this->status = $status;
        $this->setDate = $setDate;
    }

}