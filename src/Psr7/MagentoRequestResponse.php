<?php

namespace VerticalResponse\Client\Psr7;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class MagentoRequestResponse implements ResponseInterface, RequestInterface
{
    /** @var string */
    protected $protocolVersion;
    /** @var array */
    protected $headers = [];
    /** @var StreamInterface */
    protected $body;
    /** @var int */
    protected $statusCode;
    /** @var string */
    protected $reasonPhrase;
    /** @var  string */
    protected $requestTarget = '/';
    /** @var  string */
    protected $requestMethod;
    /** @var  UriInterface */
    protected $uri;

    /** @inheritdoc */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /** @inheritdoc */
    public function withProtocolVersion($version)
    {
        $self = clone $this;
        $self->protocolVersion = $version;
        return $self;
    }

    /** @inheritdoc */
    public function getHeaders()
    {
        return $this->headers;
    }

    /** @inheritdoc */
    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
    }

    /** @inheritdoc */
    public function getHeader($name)
    {
        $this->hasHeader($name) ? $this->headers[$name] : [];
    }

    /** @inheritdoc */
    public function getHeaderLine($name)
    {
        if (!$this->hasHeader($name)) {
            return '';
        }
        $header = $this->getHeader($name);
        return is_array($header) ? implode(',',$header) : $header;
    }

    /** @inheritdoc */
    public function withHeader($name, $value)
    {
        $self = clone $this;
        $self->headers[$name] = $value;
        return $self;
    }

    /** @inheritdoc */
    public function withAddedHeader($name, $value)
    {
        $self = clone $this;
        switch(true) {
            case isset($self->headers[$name]) && is_array($self->headers[$name]):
                $self->headers[$name][] = $value;
                break;
            case isset($self->headers[$name]):
                $self->headers[$name] = [$self->headers[$name], $value];
                break;
            default:
                $self->headers[$name] = [$value];
        }
        return $self;
    }

    /** @inheritdoc */
    public function withoutHeader($name)
    {
        $self = clone $this;
        unset($self->headers[$name]);
        return $self;
    }

    /** @inheritdoc */
    public function getBody()
    {
        return $this->body;
    }

    /** @inheritdoc */
    public function withBody(StreamInterface $body)
    {
        $self = clone $this;
        $self->body = $body;
        return $self;
    }

    /** @inheritdoc */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /** @inheritdoc */
    public function withStatus($code, $reasonPhrase = '')
    {
        $self = clone $this;
        $self->statusCode = $code;
        $self->reasonPhrase = $reasonPhrase;
        return $self;
    }

    /** @inheritdoc */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /** @inheritdoc */
    public function getRequestTarget()
    {
        return $this->requestTarget;
    }

    /** @inheritdoc */
    public function withRequestTarget($requestTarget)
    {
        $self = clone $this;
        $self->requestTarget = $requestTarget;
        return $self;
    }

    /** @inheritdoc */
    public function getMethod()
    {
        return $this->requestMethod;
    }

    /** @inheritdoc */
    public function withMethod($method)
    {
        $self = clone $this;
        $self->requestMethod = $method;
        return $self;
    }

    /** @inheritdoc */
    public function getUri()
    {
        return $this->uri;
    }

    /** @inheritdoc */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $self = clone $this;
        $self->uri = $uri;
        return $self;
    }
}
