<?php

namespace AdventureRes\Tests\Authentication;

use AdventureRes\AdventureResApp;
use AdventureRes\PersistentData\AdventureResSessionKeys;
use Mockery as m;
use AdventureRes\Tests\HttpClients\AbstractHttpClientTest;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\Authentication\AdventureResSession;
use AdventureRes\PersistentData\PhpSessionPersistentDataHandler;

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
          ->andReturn($this->fakeRawHeader . $this->fakeRawBodySessionValid);
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

        $handler = new PhpSessionPersistentDataHandler($shouldCheckSessionStatus = false);
        $session = new AdventureResSession($this->app, $this->curlClient);

        $handler->set(AdventureResSessionKeys::SESSION_ID, 'foo');

        $this->assertEquals('foo', $session->getSessionId());
    }

    public function testClearSessionId()
    {
        $sessionService = new AdventureResSession($this->app);
        $handler = new PhpSessionPersistentDataHandler($shouldCheckSessionStatus = false);

        $handler->set(AdventureResSessionKeys::SESSION_ID, 'foo');
        $sessionService->clearSession();

        $this->assertNull($handler->get(AdventureResSessionKeys::SESSION_ID));
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResResponseException
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

    public function testIsSessionValid()
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
          ->twice()
          ->andReturn($this->fakeRawHeader . $this->fakeRawBodySessionValid,
            $this->fakeRawHeader . $this->fakeRawBodySessionInvalid);
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

        $this->assertTrue($session->isValidSessionId('foo'));
        $this->assertFalse($session->isValidSessionId('bar'));
    }
}
