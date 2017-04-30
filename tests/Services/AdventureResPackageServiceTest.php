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
use AdventureRes\Models\Input\PackageAddInputModel;
use AdventureRes\Models\Input\PackageAvailabilityInputModel;
use AdventureRes\Models\Input\PackageDisplayInputModel;
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
        $this->curlMock = m::mock('AdventureRes\HttpClients\AdventureResCurl');
        $this->curlClient = new AdventureResCurlHttpClient($this->curlMock);
        $this->app = new AdventureResApp('http://foo.com', 'myApiKey', 'myUser', 'myPass', 10);
        $this->service = new AdventureResPackageService($this->app, $this->curlClient, false);

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

    public function testGetPackageAvailability()
    {
        $this->setupCurlMock($this->fakeRawBodyPackageAvailability);

        /** @var \AdventureRes\Models\Input\PackageAvailabilityInputModel $input */
        $input = PackageAvailabilityInputModel::populateModel([
            'PackageGroupId' => 123,
            'ResDate'        => '06/30/2017',
            'AdultQty'       => 2,
            'YouthQty'       => 0,
            'Units'          => 0,
        ]);
        $options = $this->service->getPackageAvailability($input);
        $firstOption = $options[0];

        $firstOption->isValid();

        $this->assertInternalType('array', $options);
        $this->assertNotEmpty($options);
        $this->assertInstanceOf('\AdventureRes\Models\Output\PackageModel', $firstOption);
        $this->assertTrue($firstOption->isValid());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testGetServiceAvailabilityWithInvalidInputThrowsException()
    {
        /** @var \AdventureRes\Models\Input\PackageAvailabilityInputModel $input */
        $input = PackageAvailabilityInputModel::populateModel([]);
        $options = $this->service->getPackageAvailability($input);
    }

    public function testGetPackage()
    {
        $this->setupCurlMock($this->fakeRawBodyPackageDisplay);

        /** @var \AdventureRes\Models\Input\PackageDisplayInputModel $input */
        $input = PackageDisplayInputModel::populateModel(['PackageId' => 123]);
        $package = $this->service->getPackage($input);

        $package->isValid();

        $this->assertInstanceOf('\AdventureRes\Models\Output\PackageModel', $package);
        $this->assertTrue($package->isValid());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testGetServiceWithInvalidInputThrowsException()
    {
        /** @var \AdventureRes\Models\Input\PackageDisplayInputModel $input */
        $input = PackageDisplayInputModel::populateModel([]);
        $package = $this->service->getPackage($input);
    }

    public function testAddPackageToReservation()
    {
        $this->setupCurlMock($this->fakeRawBodyPackageAdd);

        $input = PackageAddInputModel::populateModel([
            'PackageId'    => 5,
            'ResDate'      => '7/30/2016',
            'AdultQty'     => 2,
            'YouthQty'     => 0,
            'Units'        => 0
        ]);

        /** @var \AdventureRes\Models\Output\ReservationModel $result */
        $result = $this->service->addPackageToReservation($input);

        $this->assertInstanceOf('\AdventureRes\Models\Output\ReservationModel', $result);
        $this->assertTrue($result->isValid());
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
