<?php

namespace AdventureRes\Tests\HttpClients;

use Mockery as m;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;

class AdventureResCurlHttpClientTest extends AbstractHttpClientTest
{
    /**
     * @var \AdventureRes\HttpClients\AdventureResCurl
     */
    protected $curlMock;

    /**
     * @var AdventureResCurlHttpClient
     */
    protected $curlClient;

    const CURL_VERSION_STABLE = 0x072400;
    const CURL_VERSION_BUGGY = 0x071400;

    public function setUp()
    {
        $this->curlMock   = m::mock('AdventureRes\HttpClients\AdventureResCurl');
        $this->curlClient = new AdventureResCurlHttpClient($this->curlMock);
    }

    public function testCanOpenGetCurlConnection()
    {
        $this->curlMock
          ->shouldReceive('init')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('setoptArray')
          ->with(m::on(function ($arg) {
              // array_diff() will sometimes trigger error on child-arrays
              if (['X-Foo-Header: X-Bar'] !== $arg[CURLOPT_HTTPHEADER]) {
                  return false;
              }
              unset($arg[CURLOPT_HTTPHEADER]);
              $caInfo = array_diff($arg, [
                CURLOPT_CUSTOMREQUEST  => 'GET',
                CURLOPT_URL            => 'http://foo.com',
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT        => 123,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => true,
              ]);
              if (count($caInfo) !== 1) {
                  return false;
              }
              if (1 !== preg_match('/.+\/certs\/DigiCertHighAssuranceEVRootCA\.pem$/', $caInfo[CURLOPT_CAINFO])) {
                  return false;
              }

              return true;
          }))
          ->once()
          ->andReturn(null);
        $this->curlClient->openConnection('http://foo.com', 'GET', 'foo_body', ['X-Foo-Header' => 'X-Bar'], 123);
    }

    public function testCanOpenCurlConnectionWithPostBody()
    {
        $this->curlMock
          ->shouldReceive('init')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('setoptArray')
          ->with(m::on(function ($arg) {
              // array_diff() will sometimes trigger error on child-arrays
              if ([] !== $arg[CURLOPT_HTTPHEADER]) {
                  return false;
              }
              unset($arg[CURLOPT_HTTPHEADER]);
              $caInfo = array_diff($arg, [
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_URL            => 'http://bar.com',
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT        => 60,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_POSTFIELDS     => 'baz=bar',
              ]);
              if (count($caInfo) !== 1) {
                  return false;
              }
              if (1 !== preg_match('/.+\/certs\/DigiCertHighAssuranceEVRootCA\.pem$/', $caInfo[CURLOPT_CAINFO])) {
                  return false;
              }

              return true;
          }))
          ->once()
          ->andReturn(null);
        $this->curlClient->openConnection('http://bar.com', 'POST', 'baz=bar', [], 60);
    }

    public function testCanCloseConnection()
    {
        $this->curlMock
          ->shouldReceive('close')
          ->once()
          ->andReturn(null);
        $this->curlClient->closeConnection();
    }

    public function testCanSendNormalRequest()
    {
        $this->curlMock
          ->shouldReceive('init')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('setoptArray')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('exec')
          ->once()
          ->andReturn($this->fakeRawHeader . $this->fakeRawBody);
        $this->curlMock
          ->shouldReceive('errno')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('getinfo')
          ->with(CURLINFO_HEADER_SIZE)
          ->once()
          ->andReturn(mb_strlen($this->fakeRawHeader));
        $this->curlMock
          ->shouldReceive('getinfo')
          ->with(CURLINFO_HTTP_CODE)
          ->once()
          ->andReturn(200);
        $this->curlMock
          ->shouldReceive('version')
          ->once()
          ->andReturn(['version_number' => self::CURL_VERSION_STABLE]);
        $this->curlMock
          ->shouldReceive('close')
          ->once()
          ->andReturn(null);
        $response = $this->curlClient->send('http://foo.com/', 'GET', '', [], 60);
        $this->assertEquals($this->fakeRawBody, $response->getRawBody());
        $this->assertEquals(trim($this->fakeRawHeader), $response->getRawHeaders());
        $this->assertEquals(200, $response->getHttpStatusCode());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testThrowsExceptionOnClientError()
    {
        $this->curlMock
          ->shouldReceive('init')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('setoptArray')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('exec')
          ->once()
          ->andReturn(false);
        $this->curlMock
          ->shouldReceive('errno')
          ->once()
          ->andReturn(123);
        $this->curlMock
          ->shouldReceive('error')
          ->once()
          ->andReturn('Foo error');
        $this->curlClient->send('http://foo.com/', 'GET', '', [], 60);
    }
}
