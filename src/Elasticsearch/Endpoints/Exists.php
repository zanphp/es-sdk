<?php
/**
 * User: zach
 * Date: 7/23/13
 * Time: 4:51 PM
 */

namespace Elasticsearch\Endpoints;

use Elasticsearch\Endpoints\AbstractEndpoint;
use Elasticsearch\Common\Exceptions;

/**
 * Class Exists
 * @package Elasticsearch\Endpoints\Indices\Exists
 */
class Exists extends AbstractEndpoint
{

    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {

        if (isset($this->index) !== true) {
            throw new Exceptions\RuntimeException(
                'index is required for Exists'
            );
        }

        if (isset($this->id) !== true) {
            throw new Exceptions\RuntimeException(
                'id is required for Exists'
            );
        }

        $index = $this->index;
        $type  = $this->type;
        $id    = $this->id;

        if (isset($type) === true) {
            $uri  = "/$index/$type/$id";
        } else {
            $uri  = "/$index/_all/$id";
        }

        return $uri;

    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return array(
            'parent',
            'preference',
            'refresh',
            'realtime',
            'routing'
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
            if (isset($response['found']) === true && $response['found'] === true) {
                $result = true;
            } else {
                $result = false;
            }
            call_user_func($callback, $result);
        };

        return $this;
    }
}