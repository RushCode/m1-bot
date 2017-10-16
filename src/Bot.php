<?php

namespace leocata\m1Bot;

use leocata\M1\HttpClientAuthorization;
use leocata\m1Bot\Workers\WebSocketWorker;

class Bot
{
    public $pass = '';
    public $username = '';
    private $auth;

    public function __construct()
    {
        $this->setAuth();
    }

    public function setAuth()
    {
        $this->auth = new HttpClientAuthorization($this->username, $this->pass);
    }

    protected function runWebSocketWorker($auth, $events)
    {
        $callbackWebSocket = new WebSocketWorker($auth, $events);

        return $callbackWebSocket->execute();
    }
}
