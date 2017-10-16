<?php

namespace leocata\m1Bot;

use leocata\m1Bot\Interfaces\EventInterface;

class Events implements EventInterface
{

    public function message($msg)
    {
        return $msg;
    }

    public function close($code, $reason)
    {
        echo "Connection closed ({$code} - {$reason})\n";
    }

    public function error($exception)
    {
        return $exception;
    }
}
