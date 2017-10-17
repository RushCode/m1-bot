<?php

namespace leocata\m1Bot\Bot;

use leocata\m1Bot\Abstracts\MessageEvent;

class ExampleBot extends MessageEvent {

    public function contactAccepted(\GearmanJob $job)
    {
        echo $job->workload();
    }

    public function contactRejected(\GearmanJob $job)
    {
        echo $job->workload();
    }

    public function contactRequested(\GearmanJob $job)
    {
        echo $job->workload();
    }

    public function delivery(\GearmanJob $job)
    {
        echo $job->workload();
    }

    public function message(\GearmanJob $job)
    {
        echo $job->workload();
        $job->sendComplete('{"It\'s bot message"}');
    }

    public function messageDeleted(\GearmanJob $job)
    {
        echo $job->workload();
    }

    public function read(\GearmanJob $job)
    {
        echo $job->workload();
    }

    public function state(\GearmanJob $job)
    {
        echo $job->workload();
    }

    public function typing(\GearmanJob $job)
    {
        echo $job->workload();
        $job->sendComplete('{"It\'s bot message"}');
    }
}
