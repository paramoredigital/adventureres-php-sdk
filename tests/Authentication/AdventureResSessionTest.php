<?php

namespace AdventureRes\Tests\Authentication;

use AdventureRes\AdventureResApp;
use Mockery as m;
use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Tests\HttpClients\AbstractHttpClientTest;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\Authentication\AdventureResSession;
use AdventureRes\PersistentData\AdventureResSessionPersistentDataHandler;

class AdventureResSessionTest extends AbstractHttpClientTest
{
    /**
     * @var \AdventureRes\HttpClients\AdventureResCurl
     */
    protected $curlMock;
    /**
     * @var AdventureResCurlHttpClient
     */
    protected $curlClient;
    /**
     * @var AdventureResApp
     */
    protected $app;

    public function setUp()
    {
        $this->curlMock   = m::mock('AdventureRes\HttpClients\AdventureResCurl');
        $this->curlClient = new AdventureResCurlHttpClient($this->curlMock);
        $this->app        = new AdventureResApp('http://foo.com', 'myApiKey', 'myUser', 'myPass');

        parent::setUp();
    }

    public function testCanGetSessionIdFromPersistentData()
    {
        $handler = new AdventureResSessionPersistentDataHandler($shouldCheckSessionStatus = false);
        $session = new AdventureResSession($this->app);

        $handler->set(AdventureResSession::SESSION_ID_KEY, 'foo');

        $this->assertEquals('foo', $session->getSessionId());
    }

    public function testClearSessionId()
    {
        $handler = new AdventureResSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $handler->set(AdventureResSession::SESSION_ID_KEY, 'foo');
        AdventureResSession::clearSession();

        $this->assertNull($handler->get(AdventureResSession::SESSION_ID_KEY));
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testAuthWithInvalidCredentialsThrowsException()
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
          ->andReturn($this->fakeRawHeader . $this->fakeRawBodyLoginInvalid);
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
        $session = new AdventureResSession($this->app, $this->curlClient);

        $session->getSessionId();
    }

    public function testCanGetSessionIdFromApi()
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
          ->andReturn($this->fakeRawHeader . $this->fakeRawBodyLogin);
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
        $session = new AdventureResSession($this->app, $this->curlClient);

        $this->assertEquals('sampleSessionId', $session->getSessionId());
    }
}
