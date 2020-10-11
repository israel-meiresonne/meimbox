<?php

class MyError {
    public $message;

    public const ADMIN_ERROR = "admin_error";
    public const ERROR_FILE = "error";
    public const FATAL_ERROR = "fat_err";
    public const ERROR_STILL_STOCK = "error_still_stock";

    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * To get error his message attrribut
     * @return mixed  error his message attrribut
     */
    public function getMeassage()
    {
        return $this->message;
    }
}