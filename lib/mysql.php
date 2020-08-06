<?php

class mysql extends PDO 
{
    public function __construct(config $config)
    {
        parent::__construct("mysql:host=$config->hostname;dbname=$config->database", $config->username, $config->password);
    }
}
