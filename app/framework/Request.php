<?php

// require_once 'Session.php';

/**
 * Class modeling an incoming HTTP request.
 * 
 */
class Request
{
    /** Query parameter table */
    private $parameters;

    /** 
     * Session object associated with the request
     */
    private $session;

    /**
     * Constructor
     * 
     * @param array $parameters Request parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns true if the parameter exists in the request
     * 
     * @param string $name Parameter name
     * @return bool True if the parameter exists and its value is not empty
     */
    public function existingParameter($name)
    {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

    /**
     * Returns the value of the requested parameter
     * 
     * @param string $name Parameter name
     * @return string Parameter value
     * @throws Exception If the parameter does not exist in the query
     */
    public function getParameter($name)
    {
        if ($this->existingParameter($name)) {
            return $this->parameters[$name];
        } else {
            throw new Exception("Paramètre '$name' absent de la requête");
        }
    }
}
