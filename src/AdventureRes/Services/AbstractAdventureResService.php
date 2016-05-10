<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Services;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\AdventureResApp;
use AdventureRes\Http\AdventureResRequest;
use AdventureRes\Authentication\AdventureResSession;
use AdventureRes\HttpClients\AdventureResHttpClientInterface;
use AdventureRes\AdventureResClient;

class AbstractAdventureResService extends AbstractAdventureResBase
{
    /**
     * The API service used in this class.
     */
    const API_SERVICE = '';
    /**
     * @var AdventureResHttpClientInterface
     */
    protected $httpClient;
    /**
     * @var AdventureResClient
     */
    protected $client;
    /**
     * @var AdventureResApp
     */
    protected $app;
    /**
     * @var string
     */
    protected $sessionId;
    /**
     * @var bool This should only be used for testing.
     */
    protected $shouldValidateSessionIds;

    public function __construct(
      AdventureResApp $app,
      AdventureResHttpClientInterface $client = null,
      $shouldValidateSessionIds = true
    ) {
        $this->setApp($app);
        $this->setHttpClient($client);
        $this->client = new AdventureResClient($this->httpClient);
        $this->shouldValidateSessionIds = $shouldValidateSessionIds;
    }

    /**
     * @param \AdventureRes\AdventureResApp $app
     */
    public function setApp($app)
    {
        $this->app = $app;
    }

    /**
     * @param AdventureResHttpClientInterface $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        if ($this->shouldValidateSessionIds || !$this->sessionId) {
            $authService = new AdventureResSession($this->app);

            $this->setSessionId($authService->getSessionId());
        }

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
     * Generates an AdventureResRequest and sends it via the client.
     *
     * @param $method
     * @param $endpoint
     * @param $params
     * @return \AdventureRes\Http\AdventureResResponse
     * @throws \AdventureRes\Exceptions\AdventureResResponseException
     */
    protected function makeApiCall($method, $endpoint, $params)
    {
        $request = new AdventureResRequest(
          $this->app,
          static::API_SERVICE,
          $method,
          $endpoint,
          json_encode($params)
        );

        return $this->client->sendRequest($request);
    }
}

/* End of AbstractAdventureResService.php */