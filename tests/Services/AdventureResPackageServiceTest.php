<?php
/**
 * Copyright 2017 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace Services;

use AdventureRes\AdventureResApp;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\Models\Input\GroupListInputModel;
use AdventureRes\Services\AdventureResPackageService;
use AdventureRes\Tests\HttpClients\AbstractHttpClientTest;
use Mockery as m;

class AdventureResPackageServiceTest extends AbstractHttpClientTest
{
    /**
     * @var \AdventureRes\HttpClients\AdventureResCurl
     */
    protected $curlMock;
    /**
     * @var \AdventureRes\HttpClients\AdventureResCurlHttpClient
     */
    protected $curlClient;
    /**
     * @var \AdventureRes\AdventureResApp
     */
    protected $app;
    /**
     * @var \AdventureRes\Services\AdventureResPackageService
     */
    protected $service;

    public function setUp()
    {
        $this->curlMock   = m::mock('AdventureRes\HttpClients\AdventureResCurl');
        $this->curlClient = new AdventureResCurlHttpClient($this->curlMock);
        $this->app        = new AdventureResApp('http://foo.com', 'myApiKey', 'myUser', 'myPass', 10);
        $this->service    = new AdventureResPackageService($this->app, $this->curlClient, false);

        $this->service->setSessionId('mySessionId');

        parent::setUp();
    }

    public function testGetGroupList()
    {
        $this->setupCurlMock($this->fakeRawBodyPackageGroupList);

        $input = GroupListInputModel::populateModel([
            'ResDate' => '04/20/2017'
        ]);

        $groupList = $this->service->getGroups($input);

        $this->assertInternalType('array', $groupList);
        $this->assertNotEmpty($groupList);
        $this->assertInstanceOf('\AdventureRes\Models\Output\GroupModel', $groupList[0]);
        $this->assertTrue($groupList[0]->isValid());
    }

    private function setupCurlMock($body)
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
            ->andReturn($this->fakeRawHeader . $body);
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
    }
}
