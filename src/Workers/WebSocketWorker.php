<?php

namespace leocata\m1Bot\Workers;

use leocata\M1\HttpClientAuthorization;
use leocata\m1Bot\Events;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;

class WebSocketWorker extends Events
{
    private $subProtocol = 'json.api.smile-soft.com';
    private $wssHost = 'wss://m1online.net';
    private $host = 'm1online.net';
    private $auth;
    private $events;

    public function __construct(HttpClientAuthorization $auth, Events $events)
    {
        $this->events = $events;
        $this->auth = $auth;
    }

    public function execute()
    {
        $loop = Factory::create();
        $connector = new Connector($loop);

        $connector($this->wssHost, [$this->subProtocol], ['Host' => $this->host] + $this->auth->getBasicAuth())->then(

            function (WebSocket $stream) {
                $stream->on('message', function (MessageInterface $msg) {
                    $this->message($msg);
                });

                $stream->on('close', function ($code = null, $reason = null) {
                    $this->close($code, $reason);
                });
            }, function (\Exception $e) use ($loop) {
                echo "Could not connect: {$e->getMessage()}\n";
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
}
