<?php

namespace leocata\m1Bot\Bot;

use leocata\M1\Authorization;

class BaseBot
{
    public $pass = '';
    public $username = '';
    private $auth;

    public function __construct()
    {
        $this->auth = new Authorization($this->username, $this->pass);
    }

    public function getAuth()
    {
        return $this->auth;
    }
}
