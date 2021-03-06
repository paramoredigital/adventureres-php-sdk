<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\HttpClients;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Http\ApiRawResponse;

/**
 * Class AdventureResCurlHttpClient
 *
 * @package AdventureRes\HttpClients
 */
class AdventureResCurlHttpClient extends AbstractAdventureResBase implements AdventureResHttpClientInterface
{
    /**
     * @var string The client error message
     */
    protected $errorMessage = '';
    /**
     * @var int The curl client error code
     */
    protected $errorCode = 0;
    /**
     * @var string|boolean The raw response from the server
     */
    protected $rawResponse;
    /**
     * @var AdventureResCurl Procedural curl as object
     */
    protected $adventureResCurl;
    /**
     * @const Curl Version which is unaffected by the proxy header length error.
     */
    const CURL_PROXY_QUIRK_VER = 0x071E00;
    /**
     * @const "Connection Established" header text
     */
    const CONNECTION_ESTABLISHED = "HTTP/1.0 200 Connection established\r\n\r\n";

    /**
     * AdventureResCurlHttpClient constructor
     *
     * @param AdventureResCurl|null Procedural curl as object
     */
    public function __construct(AdventureResCurl $adventureResCurl = null)
    {
        $this->adventureResCurl = $adventureResCurl ?: new AdventureResCurl();
    }

    /**
     * {@inheritdoc}
     */
    public function send($url, $method, $body, array $headers, $timeOut)
    {
        $this->openConnection($url, $method, $body, $headers, $timeOut);
        $this->sendRequest();

        if ($curlErrorCode = $this->adventureResCurl->errno()) {
            throw new AdventureResSDKException($this->adventureResCurl->error(), $curlErrorCode);
        }

        $statusCode = $this->adventureResCurl->getinfo(CURLINFO_HTTP_CODE);
        list($rawHeaders, $rawBody) = $this->extractResponseHeadersAndBody();

        $this->closeConnection();

        return new ApiRawResponse($rawBody, $rawHeaders, $statusCode);
    }

    /**
     * Opens a new curl connection.
     *
     * @param string $url The endpoint to send the request to.
     * @param string $method The request method.
     * @param string $body The body of the request.
     * @param array $headers The request headers.
     * @param int $timeOut The timeout in seconds for the request.
     */
    public function openConnection($url, $method, $body, array $headers, $timeOut)
    {
        $options = [
          CURLOPT_CUSTOMREQUEST  => $method,
          CURLOPT_URL            => $url,
          CURLOPT_CONNECTTIMEOUT => 10,
          CURLOPT_TIMEOUT        => $timeOut,
          CURLOPT_RETURNTRANSFER => true, // Follow 301 redirects
          CURLOPT_HEADER         => true, // Enable header processing
          CURLOPT_SSL_VERIFYHOST => 2,
          CURLOPT_SSL_VERIFYPEER => true,
          CURLOPT_CAINFO         => __DIR__ . '/certs/DigiCertHighAssuranceEVRootCA.pem',
        ];

        if ($method !== "GET") {
            $mergedHeaders               = [
                'Content-Type'   => 'application/json',
                'Content-Length' => strlen($body)
              ] + (array)$headers;
            $options[CURLOPT_POSTFIELDS] = $body;
        } else {
            $options[CURLOPT_URL] = $url . '?' . http_build_query(json_decode($body));
            $mergedHeaders = $headers;
        }

        $options[CURLOPT_HTTPHEADER] = self::compileRequestHeaders($mergedHeaders);

        $this->adventureResCurl->init();
        $this->adventureResCurl->setoptArray($options);
    }

    /**
     * Closes an existing curl connection
     */
    public function closeConnection()
    {
        $this->adventureResCurl->close();
    }

    /**
     * Send the request and get the raw response from curl
     */
    public function sendRequest()
    {
        $this->rawResponse = $this->adventureResCurl->exec();
    }

    /**
     * Compiles the request headers into a curl-friendly format.
     *
     * @param array $headers The request headers.
     * @return array
     */
    public static function compileRequestHeaders(array $headers)
    {
        $formattedHeaders = [];

        foreach ($headers as $key => $value) {
            $formattedHeaders[] = $key . ': ' . $value;
        }

        return $formattedHeaders;
    }

    /**
     * Extracts the headers and the body into a two-part array
     *
     * @return array
     */
    public function extractResponseHeadersAndBody()
    {
        $headerSize = $this->getHeaderSize();
        $rawHeaders = mb_substr($this->rawResponse, 0, $headerSize);
        $rawBody    = mb_substr($this->rawResponse, $headerSize);

        return [trim($rawHeaders), trim($rawBody)];
    }

    /**
     * Return proper header size
     *
     * @return integer
     */
    private function getHeaderSize()
    {
        return $this->adventureResCurl->getinfo(CURLINFO_HEADER_SIZE);
    }
}

/* End of AdventureResCurlHttpClient.php */