<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Http;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\Exceptions\AdventureResSDKException;

/**
 * Class AdventureResResponse
 *
 * @package AdventureRes
 */
class AdventureResResponse extends AbstractAdventureResBase
{
    /**
     * @var int The HTTP status code response from the API request.
     */
    protected $httpStatusCode;
    /**
     * @var array The headers returned from the API request.
     */
    protected $headers;
    /**
     * @var string The raw body of the response from the API request.
     */
    protected $body;
    /**
     * @var array The decoded body of the API response.
     */
    protected $decodedBody = [];
    /**
     * @var AdventureResRequest The original request that returned this response.
     */
    protected $request;
    /**
     * @var AdventureResSDKException The exception thrown by this request.
     */
    protected $thrownException;

    /**
     * Creates a new Response entity.
     *
     * @param AdventureResRequest $request
     * @param string|null $body
     * @param int|null $httpStatusCode
     * @param string|null $headers
     */
    public function __construct(AdventureResRequest $request, $body = null, $httpStatusCode = null, $headers = null)
    {
        $this->request        = $request;
        $this->body           = $body;
        $this->httpStatusCode = $httpStatusCode;
        $this->headers        = $headers; // TODO: Parse headers into an array

        $this->decodeBody();
    }

    /**
     * Return the original request that returned this response.
     *
     * @return AdventureResRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Return the HTTP status code for this response.
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Return the HTTP headers for this response.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Return the raw body response.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Return the decoded body response.
     *
     * @return array
     */
    public function getDecodedBody()
    {
        return $this->decodedBody;
    }

    /**
     * Returns true if the API returned an error message.
     *
     * @return boolean
     * @todo
     */
    public function isError()
    {
        return (preg_match("/\bERROR\b/", $this->body));
    }

    /**
     * Throws the exception.
     *
     * @throws AdventureResSDKException
     */
    public function throwException()
    {
        throw $this->thrownException;
    }

    /**
     * Instantiates an exception to be thrown later.
     *
     * @todo
     */
    public function makeException()
    {
        //        $this->thrownException = AdventureResResponseException::create($this);
        $this->thrownException = new AdventureResSDKException('Error'); // TODO: Extract to separate exception.
    }

    /**
     * Returns the exception that was thrown for this request.
     *
     * @return AdventureResSDKException|null
     */
    public function getThrownException()
    {
        return $this->thrownException;
    }

    /**
     * @todo
     */
    public function decodeBody()
    {
        $decodedBody = json_decode($this->body);

        if (is_object($decodedBody)) {
            $key = key(get_object_vars($decodedBody));

            if (strstr(strtolower($key), 'result')) {
                $decodedBody = $decodedBody->$key;
            }
        }

        if (is_string($decodedBody)) {
            $decodedBody = json_decode($decodedBody);
        }

        if ($this->isError()) {
            $this->makeException();
        }

        $this->decodedBody = $decodedBody;

        return $decodedBody;
    }

    /**
     * Convenience method for retrieving the session used in this response.
     *
     * @todo Should return info about the session used in this response
     */
    public function getSessionInfo()
    {}
}

/* End of AdventureResResponse.php */