<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes;

use AdventureRes\Http\AdventureResRequest;
use AdventureRes\Http\AdventureResResponse;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\HttpClients\AdventureResHttpClientInterface;

/**
 * Class AdventureResClient
 *
 * @package AdventureRes
 */
class AdventureResClient extends AbstractAdventureResBase
{
    /**
     * @var AdventureResHttpClientInterface
     */
    protected $httpClient;

    public function __construct($httpClient = null)
    {
        if (is_null($httpClient)) {
            $httpClient = new AdventureResCurlHttpClient();
        }

        $this->setHttpClient($httpClient);
    }

    /**
     * @return AdventureResCurlHttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param AdventureResCurlHttpClient $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function sendRequest(AdventureResRequest $request)
    {
        $rawResponse  = $this->httpClient->send($request->getUrl(), $request->getMethod(), $request->getBody(),
          $request->getHeaders(), $request->getTimeout());
        $fullResponse = new AdventureResResponse($request, $rawResponse->getRawBody(),
          $rawResponse->getHttpStatusCode(), $rawResponse->getRawHeaders());

        if ($fullResponse->isError()) {
            throw $fullResponse->getThrownException();
        }

        return $fullResponse;
    }
}

/* End of AdventureResClient.php */