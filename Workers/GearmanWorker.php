<?php

namespace leocata\m1Bot\Workers;

use leocata\M1\Api;
use leocata\m1Bot\Bot\ExampleBot;

class GearmanWorker
{
    private $apiWrapper;
    private $worker;

    public function __construct()
    {
        $this->apiWrapper = new Api();
        $this->worker = new ExampleBot();
    }

    public function run()
    {
        $this->worker->run();
    }
}
