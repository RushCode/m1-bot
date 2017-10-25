<?php

namespace leocata\m1Bot\Bot;

use leocata\M1\Api;
use leocata\M1\Authorization;

abstract class BaseBot
{
    public $pass;
    public $username;
    private $auth;
    private $apiWrapper;

    final public function __construct()
    {
        $this->auth = new Authorization($this->username, $this->pass);
        $this->apiWrapper = new Api();
        $this->apiWrapper->setAuth($this->auth);
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function contactAccepted(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function contactRejected(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function contactRequested(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function delivery(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function message(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function messageDeleted(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function read(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function state(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    public function typing(\GearmanJob $job)
    {
        $job->sendComplete(true);
    }

    /**
     * @return Api
     */
    public function getApiWrapper(): Api
    {
        return $this->apiWrapper;
    }
}
