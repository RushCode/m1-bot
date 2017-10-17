<?php

namespace leocata\m1Bot\Abstracts;

use leocata\M1\Api;
use leocata\m1Bot\Bot\BaseBot;

abstract class MessageEvent
{

    private $method;
    private $apiWrapper;
    private $worker;
    private $auth;

    /**
     * MessageEvent constructor.
     */
    final public function __construct()
    {

        $this->auth = (new BaseBot())->getAuth();
        $this->apiWrapper = new Api();
        $this->worker = new \GearmanWorker();
        $this->worker->addServer();
        $this->worker->addFunction('message', [$this, 'message']);
        $this->worker->addFunction('typing', [$this, 'typing']);
        $this->worker->addFunction('state', [$this, 'state']);
        $this->worker->addFunction('contactRequested', [$this, 'contactRequested']);
        $this->worker->addFunction('contactAccepted', [$this, 'contactAccepted']);
        $this->worker->addFunction('contactRejected', [$this, 'contactRejected']);
        $this->worker->addFunction('delivery', [$this, 'delivery']);
        $this->worker->addFunction('messageDeleted', [$this, 'messageDeleted']);
        $this->worker->addFunction('read', [$this, 'read']);
    }

    public function getMethod()
    {
        return $this->method;
    }

    abstract public function contactAccepted(\GearmanJob $job);

    abstract public function contactRejected(\GearmanJob $job);

    abstract public function contactRequested(\GearmanJob $job);

    abstract public function delivery(\GearmanJob $job);

    abstract public function message(\GearmanJob $job);

    abstract public function messageDeleted(\GearmanJob $job);

    abstract public function read(\GearmanJob $job);

    abstract public function state(\GearmanJob $job);

    abstract public function typing(\GearmanJob $job);

    final public function run()
    {
        while ($this->worker->work()) {
            //Worker processing
        }
    }
}
