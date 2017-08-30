<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Authentication;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\AdventureResApp;
use AdventureRes\AdventureResClient;
use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Http\AdventureResRequest;
use AdventureRes\Http\AdventureResResponse;
use AdventureRes\HttpClients\AdventureResHttpClientInterface;
use AdventureRes\PersistentData\AdventureResSessionKeys;

/**
 * Class AdventureResSession
 *
 * @package AdventureRes\Authentication
 */
class AdventureResSession extends AbstractAdventureResBase
{
    /**
     * The API service used in this class.
     */
    const API_SERVICE = 'security';
    /**
     * The API endpoint used to login.
     */
    const LOGIN_ENDPOINT = '/Login';
    /**
     * The API endpoint used to validate a session.
     */
    const VALID_SESSION_ENDPOINT = '/ValidSession';
    /**
     * @var string
     */
    protected $sessionId;
    /**
     * @var AdventureResHttpClientInterface
     */
    protected $httpClient;
    /**
     * @var \AdventureRes\AdventureResClient
     */
    protected $client;
    /**
     * @var AdventureResApp
     */
    protected $app;

    /**
     * AdventureResSession constructor.

     *
     * @param AdventureResApp $app
     * @param AdventureResHttpClientInterface|null $client
     */
    public function __construct(AdventureResApp $app, AdventureResHttpClientInterface $client = null)
    {
        $this->setApp($app);
        $this->setHttpClient($client);
        $this->client = new AdventureResClient($this->httpClient);
    }

    /**
     * Sets the app in the instance.
     *
     * @param AdventureResApp $app
     */
    public function setApp($app)
    {
        $this->app = $app;
    }

    /**
     * Sets the HTTP client to be used for all requests.
     *
     * @param AdventureResHttpClientInterface $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Returns a valid Session ID. If a session ID has not been created, it will run the authentication to
     * create one. If a session ID has been created, it will validate it and then return a valid ID.
     *
     * @return string
     */
    public function getSessionId()
    {
        $this->setSessionId();

        return $this->sessionId;
    }

    /**
     * Checks to see if a session ID is valid.
     *
     * @param string $sessionId
     * @return bool
     * @throws AdventureResSDKException
     */
    public function isValidSessionId($sessionId)
    {
        $params  = ['Session' => $sessionId];
        $request = new AdventureResRequest(
          $this->app,
          self::API_SERVICE,
          'POST',
          self::VALID_SESSION_ENDPOINT,
          json_encode($params)
        );

        /** @var AdventureResResponse $response */
        $response = $this->client->sendRequest($request);
        $body     = $response->getDecodedBody();

        return $body[0]->ValidSession;
    }

    /**
     * Clears a session ID.
     */
    public function clearSession()
    {
        $handler = $this->app->getDataHandler();

        $handler->delete(AdventureResSessionKeys::SESSION_ID);
    }

    /**
     * Sets the session Id from persistent data or authentication via API.
     */
    protected function setSessionId()
    {
        $dataHandler     = $this->app->getDataHandler();
        $this->sessionId = $dataHandler->get(AdventureResSessionKeys::SESSION_ID);

        if (!$this->sessionId || !$this->isValidSessionId($this->sessionId)) {
            $this->clearSession();

            $this->sessionId = $this->authenticate();

            $dataHandler->set(AdventureResSessionKeys::SESSION_ID, $this->sessionId);
        }
    }

    /**
     * Attempts to login to the API. Returns a valid SessionId if successful.
     *
     * @return string
     * @throws AdventureResSDKException
     */
    protected function authenticate()
    {
        $params  = [
          'APIKey'   => $this->app->getApiKey(),
          'Password' => $this->app->getPassword(),
          'UserName' => $this->app->getUsername()
        ];
        $request = new AdventureResRequest(
          $this->app,
          self::API_SERVICE,
          'POST',
          self::LOGIN_ENDPOINT,
          json_encode($params)
        );

        /** @var AdventureResResponse $response */
        $response = $this->client->sendRequest($request);
        $body     = $response->getDecodedBody();

        if(is_null($body)) {
            throw new AdventureResSDKException('Unable to login. The API would not authenticate.');
        }

        if ($body[0]->ValidSession === false
          || preg_match("/error/i", $body[0]->Result)
          || empty($body[0]->Session)
        ) {
            throw new AdventureResSDKException('Unable to login. The API returned the following result: ' . $body[0]->Result);
        }

        return $body[0]->Session;
    }
}

/* End of AdventureResSession.php */