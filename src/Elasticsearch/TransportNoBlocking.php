<?php
/**
 * User: zach
 * Date: 5/1/13
 * Time: 9:51 PM
 */

namespace Elasticsearch;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Serializers\SerializerInterface;

use Elasticsearch\Connections\SwooleConnection;


class TransportNoBlocking
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    private $host;
    private $callback;

    public function __construct($hosts, $params)
    {
        if (is_array($hosts) !== true) {
            throw new Exceptions\InvalidArgumentException('Hosts parameter must be an array');
        }

        $this->serializer = $params['serializer'];

        $this->host = $hosts[0];
    }

    public function setCallback(callable $callback)
    {
        $this->callback = $callback;
        return $this;
    }

    public function performRequest($method, $uri, $params = null, $body = null)
    {
        if (isset($body) === true) {
            $body = $this->serializer->serialize($body);
        }

        $connection = new SwooleConnection($this->host['host'], $this->host['port']);
        $connection->setMethod($method)->setUri($uri)->setData($body)->handle($this->getFilterResponseCallback());
    }

    private function getFilterResponseCallback()
    {
        return function($response) {
            $data = $this->serializer->deserialize($response);
            call_user_func($this->callback, $data);
        };
    }
}