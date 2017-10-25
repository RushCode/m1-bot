<?php

namespace leocata\m1Bot\Commands;

use leocata\m1Bot\Bot\BaseBot;

class GearmanCommand
{
    public static function run(BaseBot $userBot)
    {
        $worker = new \GearmanWorker();
        $worker->addServer();
        $worker->addFunction('message', [$userBot, 'message']);
        $worker->addFunction('typing', [$userBot, 'typing']);
        $worker->addFunction('state', [$userBot, 'state']);
        $worker->addFunction('contactRequested', [$userBot, 'contactRequested']);
        $worker->addFunction('contactAccepted', [$userBot, 'contactAccepted']);
        $worker->addFunction('contactRejected', [$userBot, 'contactRejected']);
        $worker->addFunction('delivery', [$userBot, 'delivery']);
        $worker->addFunction('messageDeleted', [$userBot, 'messageDeleted']);
        $worker->addFunction('read', [$userBot, 'read']);

        while ($worker->work()) {
            //Worker processing
        }
    }
}
