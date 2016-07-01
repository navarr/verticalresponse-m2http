<?php

namespace VerticalResponse\Client;

use Psr\Http\Message\RequestInterface;
use VerticalResponse\Client\Psr7\MagentoRequestResponse;

class MagentoRequestFactory implements RequestProvider
{
    /**
     * @param string      $method
     * @param string      $uri
     * @param array       $headers
     * @param string|null $body
     * @param string      $version
     * @return RequestInterface
     */
    public function createRequest(
        $method,
        $uri,
        array $headers = [],
        $body = null,
        $version = '1.1'
    ) {
        $request = new MagentoRequestResponse();
        $request = $request->withMethod($method);
        $request = $request->withUri(\GuzzleHttp\Psr7\uri_for($uri));
        foreach($headers as $header => $value) {
            $request = $request->withHeader($header, $value);
        }
        $request = $request->withBody(\GuzzleHttp\Psr7\stream_for($body));
        $request = $request->withProtocolVersion($version);

        return $request;
    }
}
