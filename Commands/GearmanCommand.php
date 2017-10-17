<?php

namespace leocata\m1Bot\Commands;

use GetOpt\Command;
use leocata\m1Bot\Workers\GearmanWorker;

class GearmanCommand extends Command
{
    public function __construct()
    {
        parent::__construct('gearman', [$this, 'handle']);
    }

    public function handle()
    {
        $gearmanWorker = new GearmanWorker();
        $gearmanWorker->run();
    }
}
