<?php

namespace Elasticsearch\Connections;


class SwooleConnection
{
    const USER_AGENT = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36';
    const ACCEPT = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
    const ACCEPT_ENCODING = 'gzip,deflate';

    private $host;
    private $port;

    private $method;
    private $uri;
    private $data = [];

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function handle(callable $callback)
    {
        swoole_async_dns_lookup($this->host, function($host, $ip) use($callback) {
            $client = new \swoole_http_client($ip, $this->port);
            $client->setHeaders([
                'Host' => "$this->host:$this->port",
                'User-Agent' => self::USER_AGENT,
                'Accept' => self::ACCEPT,
                'Accept-Encoding' => self::ACCEPT_ENCODING,
            ]);

            if ($this->method == 'GET' or $this->method == 'HEAD') {
                $client->get($this->uri, function($client) use ($callback){
                    call_user_func($callback, $client->body);
                });
            } else {
                $client->post($this->uri, $this->data, function($client) use ($callback){
                    call_user_func($callback, $client->body);
                });
            }
        });
    }
}