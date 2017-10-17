<?php

namespace leocata\m1Bot\Events;

use leocata\M1\Api;

class MessageEvent
{
    private $method;

    /**
     * MessageEvent constructor.
     * @param $message
     */
    final public function __construct($message)
    {
        $apiWrapper = new Api();
        $client = new \GearmanClient();
        $client->addServer();
        $this->method = $apiWrapper->getCallbackMethod($message);
        $methodName = lcfirst($this->method->getMethodName());
        $client->doHighBackground($methodName, \GuzzleHttp\json_encode($this->method));
    }
}
