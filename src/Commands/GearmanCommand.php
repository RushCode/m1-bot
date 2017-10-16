<?php

namespace leocata\m1Bot\Commands;

use GetOpt\Command;
use leocata\M1\HttpClientAuthorization;
use leocata\m1Bot\Workers\GearmanWorker;

class GearmanCommand extends Command
{

    private $username = '';
    private $pass = '';

    public function __construct()
    {
        parent::__construct('gearman', [$this, 'handle']);
    }

    public function handle()
    {
        $auth = new HttpClientAuthorization($this->username, $this->pass);
        return new GearmanWorker($auth);
    }
}
