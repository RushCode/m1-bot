<?php

namespace leocata\m1Bot\Commands;

use GetOpt\Command;
use leocata\m1Bot\Bot\BaseBot;
use leocata\m1Bot\Workers\WebSocketWorker;

class WebSocketCommand extends Command
{
    public function __construct()
    {
        parent::__construct('websocket', [$this, 'handle']);
    }

    public function handle()
    {
        $baseBot = new BaseBot();
        $socket = new WebSocketWorker($baseBot->getAuth());
        $socket->setMessageEvents('leocata\\m1Bot\Bot\\ExampleBot');
        $socket->execute();
    }
}
