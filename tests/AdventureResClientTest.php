<?php

namespace AdventureRes\Tests;

use \AdventureRes\AdventureResClient;
use AdventureRes\AdventureResApp;
use AdventureRes\Http\AdventureResRequest;
use AdventureRes\Http\ApiRawResponse;
use AdventureRes\HttpClients\AdventureResHttpClientInterface;

class FakeHttpClient implements AdventureResHttpClientInterface
{
    public function send($url, $method, $body, array $headers, $timeout)
    {
        return new ApiRawResponse(
          '[{"code":"123","body":"Foo"},{"code":"1337","body":"Bar"}]',
          "HTTP/1.1 200 OK\r\nDate: Mon, 19 May 2014 18:37:17 GMT");
    }
}

class FakeHttpClientWithError implements AdventureResHttpClientInterface
{
    public function send($url, $method, $body, array $headers, $timeout)
    {
        return new ApiRawResponse(
          '{"LoginResult": "[{\"Session\":\"\",\"ValidSession\":false,\"Result\":\"ERROR: INVALID LOGIN\"}]"}',
          "HTTP/1.1 200 OK\r\nDate: Mon, 19 May 2014 18:37:17 GMT");
    }
}

class AdventureResClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \AdventureRes\AdventureResApp
     */
    protected $app;

    public function setUp()
    {
        $this->app = new AdventureResApp('http://foo.com', 'myApiKey', 'myUser', 'myPass');
    }

    public function testInstantiatesDefaultHttpHandler()
    {
        $client = new AdventureResClient();

        $this->assertInstanceOf('\AdventureRes\HttpClients\AdventureResCurlHttpClient', $client->getHttpClient());
    }

    public function testCanInjectHttpClient()
    {
        $httpClient = new FakeHttpClient();
        $client     = new AdventureResClient($httpClient);

        $this->assertInstanceOf('\AdventureRes\Tests\FakeHttpClient', $client->getHttpClient());
    }

    public function testSendRequestReturnsResponseObject()
    {
        $httpClient = new FakeHttpClient();
        $client     = new AdventureResClient($httpClient);
        $request    = new AdventureResRequest($this->app, 'security', 'POST', 'Login', '');

        $this->assertInstanceOf('\AdventureRes\Http\AdventureResResponse', $client->sendRequest($request));
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testThrowsExceptionIfResponseHasError()
    {
        $httpClient = new FakeHttpClientWithError();
        $client     = new AdventureResClient($httpClient);
        $request    = new AdventureResRequest($this->app, 'security', 'POST', 'Login', '');

        $this->assertInstanceOf('\AdventureRes\Http\AdventureResResponse', $client->sendRequest($request));
    }
}
