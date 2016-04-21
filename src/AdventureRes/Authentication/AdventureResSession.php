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
use AdventureRes\PersistentData\AdventureResSessionPersistentDataHandler;

/**
 * Class AdventureResSession
 *
 * @package AdventureRes
 */
class AdventureResSession extends AbstractAdventureResBase
{
    /**
     * The key to store the session with in persistent data.
     */
    const SESSION_ID_KEY = 'session_id';
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
     * @param AdventureResHttpClientInterface|null $client
     * @param AdventureResApp $app
     */
    public function __construct($app, AdventureResHttpClientInterface $client = null)
    {
        $this->setApp($app);
        $this->setHttpClient($client);
        $this->client = new AdventureResClient($this->httpClient);
    }

    /**
     * @param AdventureResApp $app
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
        $this->setSessionId();

        return $this->sessionId;
    }

    /**
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
    public static function clearSession()
    {
        $handler = new AdventureResSessionPersistentDataHandler();

        $handler->delete(self::SESSION_ID_KEY);
    }

    /**
     * Sets the session Id from persistent data or authentication via API.
     */
    protected function setSessionId()
    {
        $dataHandler     = new AdventureResSessionPersistentDataHandler();
        $this->sessionId = $dataHandler->get(self::SESSION_ID_KEY);

        if (!$this->sessionId || !$this->isValidSessionId($this->sessionId)) {
            $this->clearSession();
            $this->sessionId = $this->authenticate();
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

        if ($body[0]->ValidSession === false
          || preg_match("/error/i", $body[0]->Result
            || empty($body[0]->Session))
        ) {
            throw new AdventureResSDKException('Unable to login. The API returned the following result: ' . $body[0]->Result);
        }

        return $body[0]->Session;
    }
}

/* End of AdventureResSession.php */