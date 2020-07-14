<?php

class MyError {
    public $message;

    const ADMIN_ERROR = "admin_error";
    const ERROR_FILE = "error";
    const FATAL_ERROR = "fat_err";

    function __construct($message)
    {
        $this->message = $message;
    }
}