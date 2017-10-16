<?php

namespace leocata\m1Bot\Interfaces;

interface WebSocketMethodsInterface
{
    public function ContactAccepted();

    public function ContactReject();

    public function ContactRequested();

    public function Delivery();

    public function Message();

    public function MessageDeleted();

    public function Read();

    public function State();

    public function Typing();
}
