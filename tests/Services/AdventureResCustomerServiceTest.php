<?php
/**
 * Copyright 2017 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace Services;

use AdventureRes\AdventureResApp;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\Models\Input\CustomerInputModel;
use AdventureRes\Models\Output\CustomerModel;
use AdventureRes\Services\AdventureResCustomerService;
use AdventureRes\Tests\HttpClients\AbstractHttpClientTest;
use Mockery as m;

class AdventureResCustomerServiceTest extends AbstractHttpClientTest
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
     * @var \AdventureRes\Services\AdventureResCustomerService
     */
    protected $service;

    public function setUp()
    {
        $this->curlMock = m::mock('AdventureRes\HttpClients\AdventureResCurl');
        $this->curlClient = new AdventureResCurlHttpClient($this->curlMock);
        $this->app = new AdventureResApp('http://foo.com', 'myApiKey', 'myUser', 'myPass', 10);
        $this->service = new AdventureResCustomerService($this->app, $this->curlClient, false);

        $this->service->setSessionId('mySessionId');

        parent::setUp();
    }

    public function testCreateCustomer()
    {
        $this->setupCurlMock($this->fakeRawBodyCreateCustomer);

        $input = CustomerInputModel::populateModel([
            'ReservationId' => 123,
            'CustomerId'    => 456,
            'FirstName'     => 'Joe',
            'LastName'      => 'Tester',
            'OrgName'       => 'Test, Inc.',
            'Address'       => '555 Main Street',
            'Address2'      => '',
            'City'          => 'Nashville',
            'State'         => 'TN',
            'Zip'           => 37211,
            'Country'       => 'US',
            'DOB'           => '11/12/1970',
            'Age'           => 21,
            'Gender'        => 'M',
            'HomePhone'     => '6155551234',
            'WorkPhone'     => '',
            'CellPhone'     => '',
            'Email'         => 'joe@adventureres.com',
            'GroupTypeId'   => 0,
            'HTHId'         => 0,
        ]);

        $result = $this->service->createCustomer($input);

        $this->assertInstanceOf(CustomerModel::class, $result);
        $this->assertTrue($result->isValid());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testCreateCustomerWithInvalidInputThrowsException()
    {
        $inputModel = new CustomerInputModel();
        $this->service->createCustomer($inputModel);
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
