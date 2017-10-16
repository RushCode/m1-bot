<?php

namespace leocata\m1Bot\Commands;

use GetOpt\Command;
use leocata\M1\HttpClientAuthorization;
use leocata\m1Bot\Events;
use leocata\m1Bot\Workers\WebSocketWorker;

class WebSocketCommand extends Command
{
    public $pass = '';
    public $username = '';

    public function __construct()
    {
        parent::__construct('websocket', [$this, 'handle']);
    }

    public function handle()
    {
        $auth = new HttpClientAuthorization($this->username, $this->pass);
        $socket = new WebSocketWorker($auth, new Events());
        $socket->execute();
    }
}
