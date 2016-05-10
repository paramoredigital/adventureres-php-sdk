<?php

namespace AdventureRes;

use AdventureRes\AdventureResApp;
use AdventureRes\Models\Input\ServiceAddInputModel;
use AdventureRes\Models\Input\ServiceAvailabilityInputModel;
use AdventureRes\Models\Input\ServiceDisplayInputModel;
use AdventureRes\Models\Input\ServiceRemoveInputModel;
use AdventureRes\PersistentData\AdventureResSessionKeys;
use Mockery as m;
use AdventureRes\Tests\HttpClients\AbstractHttpClientTest;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\PersistentData\AdventureResSessionPersistentDataHandler;
use AdventureRes\Services\AdventureResServiceService;

class AdventureResServiceServiceTest extends AbstractHttpClientTest
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
     * @var \AdventureRes\Services\AdventureResServiceService
     */
    protected $service;

    public function setUp()
    {
        $this->curlMock   = m::mock('AdventureRes\HttpClients\AdventureResCurl');
        $this->curlClient = new AdventureResCurlHttpClient($this->curlMock);
        $this->app        = new AdventureResApp('http://foo.com', 'myApiKey', 'myUser', 'myPass', 10);
        $this->service    = new AdventureResServiceService($this->app, $this->curlClient, false);

        $this->service->setSessionId('mySessionId');

        parent::setUp();
    }

    public function testGetClassificationList()
    {
        $this->setupCurlMock($this->fakeRawBodyClassificationList);

        $classificationList = $this->service->getClassifications();

        $this->assertInternalType('array', $classificationList);
        $this->assertNotEmpty($classificationList);
        $this->assertInstanceOf('\AdventureRes\Models\Output\ClassificationModel', $classificationList[0]);
        $this->assertTrue($classificationList[0]->isValid());
    }

    public function testGetService()
    {
        $this->setupCurlMock($this->fakeRawBodyServiceDisplay);

        /** @var \AdventureRes\Models\Input\ServiceDisplayInputModel $input */
        $input               = ServiceDisplayInputModel::populateModel(['ServiceId' => 123]);
        $adventureResService = $this->service->getService($input);

        $this->assertInstanceOf('\AdventureRes\Models\Output\ServiceModel', $adventureResService);
        $this->assertTrue($adventureResService->isValid());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testGetServiceWithInvalidInputThrowsException()
    {
        /** @var \AdventureRes\Models\Input\ServiceDisplayInputModel $input */
        $input               = ServiceDisplayInputModel::populateModel([]);
        $adventureResService = $this->service->getService($input);
    }

    public function testGetServiceAvailability()
    {
        $this->setupCurlMock($this->fakeRawBodyServiceAvailability);

        /** @var \AdventureRes\Models\Input\ServiceAvailabilityInputModel $input */
        $input       = ServiceAvailabilityInputModel::populateModel([
          'ServiceId'  => 123,
          'LocationId' => 10,
          'AdultQty'   => 2,
          'YouthQty'   => 0,
          'Units'      => 0,
          'StartDate'  => '06/30/2016',
          'Display'    => 'ITEM'
        ]);
        $options     = $this->service->getServiceAvailability($input);
        $firstOption = $options[0];

        $this->assertInternalType('array', $options);
        $this->assertNotEmpty($options);
        $this->assertInstanceOf('\AdventureRes\Models\Output\ServiceModel', $firstOption);
        $this->assertTrue($firstOption->isValid());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testGetServiceAvailabilityWithInvalidInputThrowsException()
    {
        /** @var \AdventureRes\Models\Input\ServiceAvailabilityInputModel $input */
        $input   = ServiceAvailabilityInputModel::populateModel([]);
        $options = $this->service->getServiceAvailability($input);
    }

    public function testAddServiceToReservation()
    {
        $this->setupCurlMock($this->fakeRawBodyServiceAdd);

        /** @var \AdventureRes\Models\Input\ServiceAddInputModel $input */
        $input = ServiceAddInputModel::populateModel([
          'ServiceId'    => 5,
          'Display'      => 'ITEM',
          'ResDate'      => '7/30/2016',
          'ScheduleTime' => '',
          'AdultQty'     => 0,
          'YouthQty'     => 0,
          'Units'        => 0
        ]);

        /** @var \AdventureRes\Models\Output\ReservationModel $result */
        $result = $this->service->addServiceToReservation($input);

        $this->assertInstanceOf('\AdventureRes\Models\Output\ReservationModel', $result);
        $this->assertTrue($result->isValid());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testAddServiceWithInvalidInputThrowsException()
    {
        /** @var \AdventureRes\Models\Input\ServiceAddInputModel $input */
        $input   = ServiceAddInputModel::populateModel([]);
        $options = $this->service->addServiceToReservation($input);
    }

    public function testAddServiceSetsReservationId()
    {
        $dataHandler = new AdventureResSessionPersistentDataHandler();

        $dataHandler->delete(AdventureResSessionKeys::RESERVATION_ID);
        $this->assertEquals(0, $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID, 0));
        $this->setupCurlMock($this->fakeRawBodyServiceAdd);

        /** @var \AdventureRes\Models\Input\ServiceAddInputModel $input */
        $input = ServiceAddInputModel::populateModel([
          'ServiceId'    => 5,
          'Display'      => 'ITEM',
          'ResDate'      => '7/30/2016',
          'ScheduleTime' => '',
          'AdultQty'     => 0,
          'YouthQty'     => 0,
          'Units'        => 0
        ]);

        /** @var \AdventureRes\Models\Output\ReservationModel $result */
        $result = $this->service->addServiceToReservation($input);

        $this->assertEquals(123, $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID, 0));
    }

    public function testRemoveServiceFromReservation()
    {
        $dataHandler = new AdventureResSessionPersistentDataHandler();

        $dataHandler->set(AdventureResSessionKeys::RESERVATION_ID, 111);
        $this->setupCurlMock($this->fakeRawBodyServiceRemove);

        /** @var \AdventureRes\Models\Input\ServiceRemoveInputModel $input */
        $input = ServiceRemoveInputModel::populateModel(['ReservationItemId' => 123]);

        $itemRemoved = $this->service->removeServiceFromReservation($input);

        $this->assertEquals(123, $itemRemoved);
        $this->assertEquals(0, $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID, 0));
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testRemovingServiceWithInvalidInputThrowsException()
    {
        /** @var \AdventureRes\Models\Input\ServiceAddInputModel $input */
        $input   = ServiceAddInputModel::populateModel([]);
        $options = $this->service->addServiceToReservation($input);
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
