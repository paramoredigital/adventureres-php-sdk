<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Http;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\HttpClients\AdventureResHttpClientInterface;

/**
 * Class AdventureResRequest
 *
 * @package AdventureRes
 */
class AdventureResRequest extends AbstractAdventureResBase
{
    /**
     * The default number of seconds for a request to timeout.
     */
    const DEFAULT_TIMEOUT_SECONDS = 120;

    /**
     * @var array
     */
    protected $serviceScopes = [
      'security' => '/Security.svc',
      'service' => '/Service.svc',
      'reservation' => '/Reservation.svc'
    ];

    /**
     * @var \AdventureRes\AdventureResApp
     */
    protected $app;
    /**
     * @var string
     */
    protected $sessionId;
    /**
     * @var string
     */
    protected $service;
    /**
     * @var string
     */
    protected $method;
    /**
     * @var string
     */
    protected $endpoint;
    /**
     * @var string
     */
    protected $body;
    /**
     * @var array
     */
    protected $headers;
    /**
     * @var int
     */
    protected $timeout;

    public function __construct(
      $app,
      $service,
      $method,
      $endpoint,
      $body,
      $headers = [],
      $timeout = null,
      $sessionId = null
    ) {
        $this->app = $app;
        $this->setService($service);
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setBody($body);
        $this->setHeaders($headers);
        $this->setTimeout($timeout);
        $this->setSessionId($sessionId);
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = is_null($timeout) ? self::DEFAULT_TIMEOUT_SECONDS : $timeout;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->app->getBaseDomain() . $this->serviceScopes[$this->service] . $this->endpoint;
    }
}

/* End of AdventureResRequest.php */