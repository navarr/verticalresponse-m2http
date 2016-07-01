<?php

namespace VerticalResponse\Client;

use Magento\Framework\HTTP\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use VerticalResponse\Client\Psr7\MagentoRequestResponse;

class MagentoClient implements HttpClient
{
    /** @var ClientInterface  */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function send(RequestInterface $request)
    {
        $headers = $request->getHeaders();
        $body = $request->getBody();
        $method = $request->getMethod();
        $uri = $request->getUri();

        $this->client->setHeaders($headers);
        if ($method == 'GET') {
            $this->client->get($uri);
        }
        if ($method == 'POST') {
            $contents = (string)$body;
            $this->client->post($uri, $contents);
        }

        $response = new MagentoRequestResponse();
        $headers = $this->client->getHeaders();
        foreach($headers as $header => $value) {
            $response = $response->withHeader($header, $value);
        }
        $response = $response->withBody(\GuzzleHttp\Psr7\stream_for($this->client->getBody()));
        $response = $response->withStatus($this->client->getStatus());
        return $response;
    }
}
