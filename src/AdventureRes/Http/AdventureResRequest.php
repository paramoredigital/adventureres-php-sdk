<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Http;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\AdventureResApp;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\HttpClients\AdventureResHttpClientInterface;

/**
 * Class AdventureResRequest
 *
 * @package AdventureRes\Http
 */
class AdventureResRequest extends AbstractAdventureResBase
{
    /**
     * The default number of seconds for a request to timeout.
     */
    const DEFAULT_TIMEOUT_SECONDS = 120;

    /**
     * @var array A keyed map of the API services.
     */
    protected $serviceScopes = [
        'security'    => '/Security.svc',
        'service'     => '/Service.svc',
        'reservation' => '/Reservation.svc',
        'package'     => '/Package.svc',
        'customer'    => '/Customer.svc',
    ];

    /**
     * @var \AdventureRes\AdventureResApp The configuration app
     */
    protected $app;
    /**
     * @var string The session ID to be used in the request.
     */
    protected $sessionId;
    /**
     * @var string
     */
    protected $service;
    /**
     * @var string A valid HTTP method (GET, POST, PUT, DELETE)
     */
    protected $method;
    /**
     * @var string The API endpoint the request should call
     */
    protected $endpoint;
    /**
     * @var string A JSON encoded string of parameters to be passed to the request.
     */
    protected $body;
    /**
     * @var array An array of HTTP headers
     */
    protected $headers;
    /**
     * @var int The number of seconds before the request should time out.
     */
    protected $timeout;

    /**
     * AdventureResRequest constructor.
     *
     * @param AdventureResApp $app
     * @param string $service
     * @param string $method GET or POST
     * @param string $endpoint
     * @param string $body
     * @param array $headers
     * @param int|null $timeout
     * @param string|null $sessionId
     */
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
     * Gets the stored session ID.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Stores a session ID.
     *
     * @param string $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Gets the name of the service defined in the request.
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Stores the name of the service.
     *
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * Gets the request method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Sets the request method. Should be either GET or POST.
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Gets the defined endpoint for the request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Sets the endpoint for the request.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Gets the defined body for the request.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the body for the request.
     *
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Gets the defined headers for the request.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Sets the headers for the request.
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * Gets the defined timeout length for the request. (Seconds)
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Sets the number of seconds before a request times out.
     *
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = is_null($timeout) ? self::DEFAULT_TIMEOUT_SECONDS : $timeout;
    }

    /**
     * Gets the full URL for the request.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->app->getBaseDomain() . $this->serviceScopes[$this->service] . $this->endpoint;
    }
}

/* End of AdventureResRequest.php */