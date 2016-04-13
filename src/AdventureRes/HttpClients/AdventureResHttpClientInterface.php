<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\HttpClients;

/**
 * Interface AdventureResHttpClientInterface
 *
 * @package AdventureRes
 */
interface AdventureResHttpClientInterface
{
    /**
     * Sends a request to the server and returns the raw response.
     *
     * @param string $url The endpoint to send the request to.
     * @param string $method The request method.
     * @param string $body The body of the request.
     * @param array $headers The request headers.
     * @param int $timeOut The timeout in seconds for the request.
     * @return \AdventureRes\Http\ApiRawResponse Raw response from the server.
     * @throws \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function send($url, $method, $body, array $headers, $timeOut);

}

/* End of AdventureResHttpClientInterface.php */