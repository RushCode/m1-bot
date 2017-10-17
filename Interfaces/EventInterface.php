<?php

namespace leocata\m1Bot\Interfaces;

interface EventInterface
{
    public function message($message);

    public function close($close, $reason);

    public function error(\Exception $exception);
}
