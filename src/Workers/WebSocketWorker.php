<?php

namespace leocata\m1Bot\Workers;

use leocata\M1\Api;
use leocata\m1Bot\Bot\BaseBot;
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
    private $apiWrapper;
    private $gearmanClient;

    public function __construct(BaseBot $baseBot)
    {
        $this->events = new WebSocketEvents();
        $this->auth = $baseBot->getAuth();
        $this->apiWrapper = new Api();
        $this->gearmanClient = new \GearmanClient();
        $this->gearmanClient->addServer();
    }

    public function execute()
    {
        $loop = Factory::create();
        $connector = new Connector($loop);

        $connector($this->wssHost, [$this->subProtocol], ['Host' => $this->host] + $this->auth->getBasicAuth())->then(

            function (WebSocket $stream) {
                $stream->on('message', function (MessageInterface $message) {
                    $this->events->message($message, $this->apiWrapper, $this->gearmanClient);
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
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @param string $wssHost
     */
    public function setWssHost(string $wssHost)
    {
        $this->wssHost = $wssHost;
    }
    /**
     * @param string $subProtocol
     */
    public function setSubProtocol(string $subProtocol)
    {
        $this->subProtocol = $subProtocol;
    }
}
