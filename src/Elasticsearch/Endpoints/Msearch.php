<?php
/**
 * User: zach
 * Date: 05/31/2013
 * Time: 16:47:11 pm
 */

namespace Elasticsearch\Endpoints;

use Elasticsearch\Endpoints\AbstractEndpoint;
use Elasticsearch\Common\Exceptions;
use Elasticsearch\Serializers\SerializerInterface;
use Elasticsearch\Transport;

/**
 * Class Msearch
 * @package Elasticsearch\Endpoints
 */
class Msearch extends AbstractEndpoint implements BulkEndpointInterface
{
    /** @var SerializerInterface  */
    private $serializer;


    /**
     * @param Transport           $transport
     * @param SerializerInterface $serializer
     */
    public function __construct(Transport $transport, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        parent::__construct($transport);
    }


    /**
     * @param array|string $body
     *
     * @throws \Elasticsearch\Common\Exceptions\InvalidArgumentException
     * @return $this
     */
    public function setBody($body)
    {
        if (isset($body) !== true) {
            return $this;
        }

        if (is_array($body) === true) {
            $bulkBody = "";
            foreach ($body as $item) {
                $bulkBody .= $this->serializer->serialize($item)."\n";
            }
            $body = $bulkBody;
        }

        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    protected function getURI()
    {
        return $this->getOptionalURI('_msearch');
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return array(
            'search_type',
        );
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'GET';
    }

    /**
     * {@inheritdoc}
     */
    public function setCallback(Callable $callback)
    {
        $this->callback = function($response) use ($callback) {
            call_user_func($callback, $response);
        };

        return $this;
    }
}