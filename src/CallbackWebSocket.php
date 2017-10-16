<?php

namespace leocata\m1Bot;

use leocata\M1\Api;
use leocata\M1\HttpClientAuthorization;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;

class CallbackWebSocket
{

    private $subProtocol = 'json.api.smile-soft.com';
    private $wssHost = 'wss://m1online.net';
    private $host = 'm1online.net';
    private $auth;

    public function __construct(HttpClientAuthorization $auth)
    {
        $this->auth = $auth;

    }

    public function execute()
    {
        $apiWrapper = new Api($this->auth);

        $loop = Factory::create();
        $connector = new Connector($loop);

        $gearman = new \GearmanClient();
        $gearman->addServer();

        $connector($this->wssHost, [$this->subProtocol], ['Host' => $this->host] + $this->auth->getBasicAuth())->then(

            function (WebSocket $stream) use ($gearman, $apiWrapper) {

                $stream->on('message', function (MessageInterface $msg) use ($gearman, $apiWrapper) {
                    $result = $apiWrapper->getApiCallbackMethod($msg);
                    $gearman->doHighBackground($result->getMethodName(), $msg);
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
