<?php

namespace VerticalResponse\Client;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class MagentoRequestFactory implements RequestProvider
{
    /**
     * @param string      $method
     * @param string      $uri
     * @param array       $headers
     * @param string|null $body
     * @param string      $version
     *
     * @return RequestInterface
     */
    public function createRequest(
        $method,
        $uri,
        array $headers = [],
        $body = null,
        $version = '1.1'
    ) {
        return new Request($method, $uri, $headers, $body, $version);
    }
}
