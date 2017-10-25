<?php

namespace leocata\m1Bot\Interfaces;

use leocata\M1\Api;

interface EventInterface
{
    public function message($message, Api $apiWrapper, \GearmanClient $gearmanClient);

    public function close($close, $reason);

    public function error(\Exception $exception);
}
