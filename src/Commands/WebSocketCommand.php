<?php

namespace leocata\m1Bot\Commands;

use leocata\m1Bot\Bot\BaseBot;
use leocata\m1Bot\Workers\WebSocketWorker;

class WebSocketCommand
{
    public static function run(BaseBot $userBot)
    {
        $socket = new WebSocketWorker($userBot);
        $socket->execute();
    }
}
