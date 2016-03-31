<?php
/**
 * User: zach
 * Date: 05/31/2013
 * Time: 16:47:11 pm
 */

namespace Elasticsearch\Endpoints;

use Elasticsearch\Endpoints\AbstractEndpoint;
use Elasticsearch\Common\Exceptions;

/**
 * Class Ping
 * @package Elasticsearch\Endpoints
 */
class Ping extends AbstractEndpoint
{



    /**
     * @return string
     */
    protected function getURI()
    {

        $uri   = "/";

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return array(
        );
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'HEAD';
    }

    /**
     * {@inheritdoc}
     */
    public function setCallback(Callable $callback)
    {
        $this->callback = function($response) use ($callback) {
            if (isset($response['status']) === true && $response['status'] === 200) {
                $result = true;
            } else {
                $result = false;
            }
            call_user_func($callback, $result);
        };

        return $this;
    }
}