<?php

namespace leocata\m1Bot\Events;

use leocata\M1\Api;
use leocata\m1Bot\Interfaces\EventInterface;

class WebSocketEvents implements EventInterface
{
    public function message($message, Api $apiWrapper, \GearmanClient $gearmanClient)
    {
        $method = $apiWrapper->getCallbackMethod($message);
        $methodName = lcfirst($method->getMethodName());
        $gearmanClient->doHighBackground($methodName, json_encode($method));
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
