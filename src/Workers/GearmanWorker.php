<?php

namespace leocata\m1Bot\Workers;

use leocata\M1\Api;
use leocata\M1\Methods\Request\GetUserInfo;

class GearmanWorker {

    private $apiConn;
    private $worker;

    public function __construct($auth)
    {
        $this->apiConn = new Api($auth);
        $this->worker = new \GearmanWorker();
        $this->worker->addServer();
        $this->worker->addFunction('Message', 'Message', $this->apiConn);
        $this->worker->addFunction('Typing', 'Typing', $this->apiConn);
        $this->worker->addFunction('State', 'State', $this->apiConn);
        $this->worker->addFunction('ContactRequested', 'ContactRequested', $this->apiConn);
    }

    public function whoaMe()
    {
        /** @var GetUserInfo $method */
        $method = $this->apiConn->sendApiRequest(new GetUserInfo());
        return $method->getUserId();
    }
}
