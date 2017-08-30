<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Http;

use AdventureRes\AbstractAdventureResBase;

/**
 * Class ApiRawResponse
 *
 * @package AdventureRes\Http
 */
class ApiRawResponse extends AbstractAdventureResBase
{
    /**
     * @var string The raw body returned from the response.
     */
    protected $rawBody;
    /**
     * @var string A string of headers returned from the response.
     */
    protected $rawHeaders;
    /**
     * @var int|null The status code returned from the response.
     */
    protected $httpStatusCode;

    /**
     * ApiRawResponse constructor.
     *
     * @param string $body
     * @param string $headers
     * @param int|null $httpStatusCode
     */
    public function __construct($body, $headers, $httpStatusCode = null)
    {
        $this->rawBody        = $body;
        $this->rawHeaders     = $headers;
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * Returns the raw body from the API response.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * Returns the raw headers from the API response.
     *
     * @return string
     */
    public function getRawHeaders()
    {
        return $this->rawHeaders;
    }

    /**
     * Returns the status code from the API response.
     *
     * @return int|null
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

}

/* End of ApiRawResponse.php */