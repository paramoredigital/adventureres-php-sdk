<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Http;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\Exceptions\AdventureResResponseException;

/**
 * Class AdventureResResponse
 *
 * @package AdventureRes\Http
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
     * @var AdventureResResponseException The exception thrown by this request.
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
        $this->headers        = is_array($headers) ? $headers : $this->extractHeaders($headers);

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
     */
    public function isError()
    {
        return (preg_match("/\bERROR\b/", $this->body));
    }

    /**
     * Throws the exception.
     *
     * @throws AdventureResResponseException
     */
    public function throwException()
    {
        throw $this->thrownException;
    }

    /**
     * Instantiates an exception to be thrown later.
     */
    public function makeException()
    {
        $this->thrownException = new AdventureResResponseException($this->body);
    }

    /**
     * Returns the exception that was thrown for this request.
     *
     * @return AdventureResResponseException|null
     */
    public function getThrownException()
    {
        return $this->thrownException;
    }

    /**
     * Formats the response body into a usable format.
     *
     * @return mixed
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
     * Converts raw headers to an array.
     *
     * @param string $rawHeaders
     */
    private function extractHeaders($rawHeaders)
    {
        $rawHeaders       = str_replace("\r\n", "\n", $rawHeaders);
        $headerCollection = explode("\n\n", trim($rawHeaders));
        $rawHeader        = array_pop($headerCollection);
        $headerComponents = explode("\n", $rawHeader);

        foreach ($headerComponents as $line) {
            if (strpos($line, ': ') !== false) {
                list($key, $value) = explode(': ', $line);
                $this->headers[$key] = $value;
            }
        }
    }
}

/* End of AdventureResResponse.php */