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
 * @package AdventureRes
 */
class ApiRawResponse extends AbstractAdventureResBase
{
    /**
     * @var string
     */
    protected $rawBody;
    /**
     * @var string
     */
    protected $rawHeaders;
    /**
     * @var int|null
     */
    protected $httpStatusCode;

    public function __construct($body, $headers, $httpStatusCode = null)
    {
        $this->rawBody        = $body;
        $this->rawHeaders     = $headers;
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * Returns the raw body from the API response.
     *
*@return string
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * @return string
     */
    public function getRawHeaders()
    {
        return $this->rawHeaders;
    }

    /**
     * @return int|null
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

}

/* End of ApiRawResponse.php */