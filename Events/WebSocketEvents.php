<?php

namespace leocata\m1Bot\Events;

use leocata\m1Bot\Interfaces\EventInterface;

class WebSocketEvents implements EventInterface
{

    public function message($message)
    {
        return new MessageEvent($message);
    }

    public function close($code, $reason)
    {
        echo "Connection closed. ({$code}){$reason}" . PHP_EOL;
    }

    public function error(\Exception $exception)
    {
        echo $exception->getMessage();
    }
}
