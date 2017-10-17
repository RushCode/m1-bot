<?php

namespace leocata\m1Bot\Workers;

use leocata\M1\Authorization;
use leocata\m1Bot\Abstracts\MessageEvent;
use leocata\m1Bot\Events\WebSocketEvents;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;

class WebSocketWorker
{
    private $subProtocol = 'json.api.smile-soft.com';
    private $wssHost = 'wss://m1online.net';
    private $host = 'm1online.net';
    private $auth;
    private $events;
    private $messageEvents;

    public function __construct(Authorization $auth)
    {
        $this->events = new WebSocketEvents();
        $this->auth = $auth;
    }

    public function execute()
    {
        $loop = Factory::create();
        $connector = new Connector($loop);

        $connector($this->wssHost, [$this->subProtocol], ['Host' => $this->host] + $this->auth->getBasicAuth())->then(

            function (WebSocket $stream) {
                $stream->on('message', function (MessageInterface $message) {
                    $this->events->message($message);
                });

                $stream->on('close', function ($code = null, $reason = null) {
                    $this->events->close($code, $reason);
                });
            }, function (\Exception $e) use ($loop) {
                $this->events->error($e);
                $loop->stop();
            }
        );

        $loop->run();
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getWssHost(): string
    {
        return $this->wssHost;
    }

    /**
     * @param string $wssHost
     */
    public function setWssHost(string $wssHost)
    {
        $this->wssHost = $wssHost;
    }

    /**
     * @return string
     */
    public function getSubProtocol(): string
    {
        return $this->subProtocol;
    }

    /**
     * @param string $subProtocol
     */
    public function setSubProtocol(string $subProtocol)
    {
        $this->subProtocol = $subProtocol;
    }

    /**
     * @return mixed
     */
    public function getMessageEvents() : MessageEvent
    {
        return $this->messageEvents;
    }

    /**
     * @param mixed $messageEvents
     */
    public function setMessageEvents($messageEvents)
    {
        $this->messageEvents = $messageEvents;
    }
}
