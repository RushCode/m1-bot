<?php

namespace leocata\m1Bot\Interfaces;

interface EventInterface {

    public function message($msg);

    public function close($close, $reason);

    public function error($exception);

}
